<?php

namespace App\Services;

use App\Models\BioDetail;
use App\Models\User;
use DomainException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * State machine for the Sample → Result release workflow.
 *
 *   draft ─submit→ submitted_for_review ─review→ reviewed ─release→ released ─amend→ amended
 *
 * Rules enforced here (NOT in the controller, so the service is the
 * single source of truth):
 *   - You can only progress forward; no rollback once released.
 *   - The same user cannot submit AND review the result (segregation
 *     of duties — ISO 15189:2022 §7.3.7.4).
 *   - Likewise the releaser must differ from the submitter.
 *   - Every state transition writes an audit-log row via
 *     ActivityLogService — no transition is silent.
 *   - Amendment requires a non-empty reason (ISO 15189:2022 §7.3.7.4 c)
 *     and creates an *amendment chain* via `amends_id` rather than
 *     mutating the released row in place.
 */
class ResultReleaseService
{
    public const STATE_DRAFT = 'draft';

    public const STATE_SUBMITTED = 'submitted_for_review';

    public const STATE_REVIEWED = 'reviewed';

    public const STATE_RELEASED = 'released';

    public const STATE_AMENDED = 'amended';

    public function __construct(private readonly ActivityLogService $logger) {}

    public function submit(BioDetail $result, User $user): BioDetail
    {
        $this->assertState($result, [self::STATE_DRAFT]);

        return DB::transaction(function () use ($result, $user) {
            $result->forceFill([
                'result_status' => self::STATE_SUBMITTED,
                'submitted_by' => $user->id,
                'submitted_at' => Carbon::now(),
            ])->save();

            $this->logger->record(
                event: 'result.submitted',
                subject: $result,
                new: ['result_status' => self::STATE_SUBMITTED],
            );

            return $result->fresh();
        });
    }

    public function review(BioDetail $result, User $user): BioDetail
    {
        $this->assertState($result, [self::STATE_SUBMITTED]);
        $this->assertSegregation($result, $user, 'submitted_by', 'review');

        return DB::transaction(function () use ($result, $user) {
            $result->forceFill([
                'result_status' => self::STATE_REVIEWED,
                'reviewed_by' => $user->id,
                'reviewed_at' => Carbon::now(),
            ])->save();

            $this->logger->record(
                event: 'result.reviewed',
                subject: $result,
                new: ['result_status' => self::STATE_REVIEWED],
            );

            return $result->fresh();
        });
    }

    public function release(BioDetail $result, User $user): BioDetail
    {
        $this->assertState($result, [self::STATE_REVIEWED]);
        $this->assertSegregation($result, $user, 'submitted_by', 'release');

        return DB::transaction(function () use ($result, $user) {
            $result->forceFill([
                'result_status' => self::STATE_RELEASED,
                'released_by' => $user->id,
                'released_at' => Carbon::now(),
            ])->save();

            $this->logger->record(
                event: 'result.released',
                subject: $result,
                new: ['result_status' => self::STATE_RELEASED],
            );

            return $result->fresh();
        });
    }

    /**
     * Amend a released result. Creates a NEW bio_details row that
     * references the original via `amends_id`; the original is left
     * intact except for `result_status = amended` so reports can show
     * the chain.
     */
    public function amend(BioDetail $original, User $user, string $newValue, string $reason): BioDetail
    {
        if (trim($reason) === '') {
            throw new DomainException('Amendment reason is required.');
        }

        $this->assertState($original, [self::STATE_RELEASED, self::STATE_AMENDED]);

        return DB::transaction(function () use ($original, $user, $newValue, $reason) {
            $amendment = $original->replicate([
                'submitted_by', 'submitted_at',
                'reviewed_by', 'reviewed_at',
                'released_by', 'released_at',
                'amended_by', 'amended_at',
                'amendment_reason', 'amends_id',
            ]);
            $amendment->result = $newValue;
            $amendment->result_status = self::STATE_RELEASED;
            $amendment->released_by = $user->id;
            $amendment->released_at = Carbon::now();
            $amendment->amends_id = $original->id;
            $amendment->amendment_reason = $reason;
            $amendment->save();

            $original->forceFill([
                'result_status' => self::STATE_AMENDED,
                'amended_by' => $user->id,
                'amended_at' => Carbon::now(),
                'amendment_reason' => $reason,
            ])->save();

            $this->logger->record(
                event: 'result.amended',
                subject: $original,
                old: ['result' => $original->getOriginal('result')],
                new: ['result' => $newValue, 'amendment_id' => $amendment->id],
                reason: $reason,
            );

            return $amendment->fresh();
        });
    }

    private function assertState(BioDetail $result, array $allowed): void
    {
        if (! in_array($result->result_status, $allowed, true)) {
            throw new DomainException(sprintf(
                'Result %d is in state %s; expected one of: %s',
                $result->id,
                $result->result_status ?? 'null',
                implode(', ', $allowed),
            ));
        }
    }

    private function assertSegregation(BioDetail $result, User $user, string $otherColumn, string $action): void
    {
        $other = $result->{$otherColumn};
        if ($other !== null && (int) $other === (int) $user->id) {
            throw new DomainException(sprintf(
                'User %d cannot %s a result they also %s.',
                $user->id,
                $action,
                str_replace('_by', '', $otherColumn),
            ));
        }
    }
}
