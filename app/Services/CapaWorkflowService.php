<?php

namespace App\Services;

use App\Models\CapaAction;
use App\Models\NonConformance;
use App\Models\User;
use DomainException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Drives the lifecycle of a CAPA action.
 *
 *   open → in_progress → effectiveness_check → closed
 *                                              ↘ cancelled
 *
 * Closing a CAPA requires `verification_evidence` and `action_taken` to be
 * non-empty — without these we have no way to attest the action was
 * effective (ISO 9001:2015 §10.2.2 d).
 *
 * Closing the last open CAPA on a non-conformance also flips the parent
 * non_conformance.status to `closed_with_capa`.
 */
class CapaWorkflowService
{
    public const STATE_OPEN = 'open';

    public const STATE_IN_PROGRESS = 'in_progress';

    public const STATE_EFFECTIVENESS_CHECK = 'effectiveness_check';

    public const STATE_CLOSED = 'closed';

    public const STATE_CANCELLED = 'cancelled';

    public function __construct(private readonly ActivityLogService $logger) {}

    public function start(CapaAction $action, User $user): CapaAction
    {
        $this->requireStatus($action, self::STATE_OPEN);

        return DB::transaction(function () use ($action, $user) {
            $action->update(['status' => self::STATE_IN_PROGRESS]);

            $this->logger->record(
                event: 'capa.started',
                subject: $action,
                old: ['status' => self::STATE_OPEN],
                new: ['status' => self::STATE_IN_PROGRESS, 'started_by' => $user->id],
            );

            return $action->fresh();
        });
    }

    public function submitForEffectivenessCheck(CapaAction $action, User $user): CapaAction
    {
        $this->requireStatus($action, self::STATE_IN_PROGRESS);

        if (trim((string) $action->action_taken) === '') {
            throw new DomainException('Cannot submit a CAPA for effectiveness check without recording the action taken.');
        }

        return DB::transaction(function () use ($action, $user) {
            $action->update(['status' => self::STATE_EFFECTIVENESS_CHECK]);

            $this->logger->record(
                event: 'capa.submitted_for_check',
                subject: $action,
                old: [], new: ['status' => self::STATE_EFFECTIVENESS_CHECK, 'submitted_by' => $user->id],
            );

            return $action->fresh();
        });
    }

    public function close(CapaAction $action, User $user): CapaAction
    {
        $this->requireStatus($action, self::STATE_EFFECTIVENESS_CHECK);

        if (trim((string) $action->verification_evidence) === '') {
            throw new DomainException('Cannot close a CAPA without verification evidence (ISO 9001:2015 §10.2.2 d).');
        }

        return DB::transaction(function () use ($action, $user) {
            $action->update([
                'status' => self::STATE_CLOSED,
                'closed_by' => $user->id,
                'closed_at' => Carbon::now(),
            ]);

            // If every CAPA on the parent non-conformance is now closed,
            // mark the non-conformance itself closed_with_capa.
            $nc = NonConformance::find($action->non_conformance_id);
            if ($nc) {
                $openCount = CapaAction::query()
                    ->where('non_conformance_id', $nc->id)
                    ->whereNotIn('status', [self::STATE_CLOSED, self::STATE_CANCELLED])
                    ->count();

                if ($openCount === 0 && $nc->status !== 'closed_with_capa') {
                    $nc->update([
                        'status' => 'closed_with_capa',
                        'closed_at' => Carbon::now(),
                    ]);
                }
            }

            $this->logger->record(
                event: 'capa.closed',
                subject: $action,
                old: [], new: ['status' => self::STATE_CLOSED],
            );

            return $action->fresh();
        });
    }

    public function cancel(CapaAction $action, User $user, string $reason): CapaAction
    {
        if (in_array($action->status, [self::STATE_CLOSED, self::STATE_CANCELLED], true)) {
            throw new DomainException(sprintf(
                'Cannot cancel a CAPA in terminal state "%s".',
                $action->status,
            ));
        }

        if (trim($reason) === '') {
            throw new DomainException('Cancellation requires a non-empty reason.');
        }

        return DB::transaction(function () use ($action, $user, $reason) {
            $action->update([
                'status' => self::STATE_CANCELLED,
                'closed_by' => $user->id,
                'closed_at' => Carbon::now(),
            ]);

            $this->logger->record(
                event: 'capa.cancelled',
                subject: $action,
                old: [], new: ['status' => self::STATE_CANCELLED],
                reason: $reason,
            );

            return $action->fresh();
        });
    }

    private function requireStatus(CapaAction $action, string $expected): void
    {
        if ($action->status !== $expected) {
            throw new DomainException(sprintf(
                'CAPA is in state "%s" but must be "%s" for this action.',
                $action->status,
                $expected,
            ));
        }
    }
}
