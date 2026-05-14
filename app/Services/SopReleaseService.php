<?php

namespace App\Services;

use App\Models\SopAcknowledgement;
use App\Models\SopDocument;
use App\Models\SopRevision;
use App\Models\User;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * State machine for controlled-document (SOP) revisions.
 *
 * Workflow:
 *   draft → submitted → approved → effective → superseded
 *
 * Only one revision per SopDocument can be `effective` at a time;
 * promoting a new revision to `effective` automatically supersedes
 * the previous one and updates `sop_documents.current_revision_id`.
 *
 * The author of a revision cannot also approve it
 * (ISO 9001:2015 §7.5.3 — segregation of duties).
 */
class SopReleaseService
{
    public const STATE_DRAFT = 'draft';

    public const STATE_SUBMITTED = 'submitted';

    public const STATE_APPROVED = 'approved';

    public const STATE_EFFECTIVE = 'effective';

    public const STATE_SUPERSEDED = 'superseded';

    public function __construct(private readonly ActivityLogService $logger) {}

    public function submit(SopRevision $revision, User $user): SopRevision
    {
        $this->requireStatus($revision, self::STATE_DRAFT);

        return DB::transaction(function () use ($revision, $user) {
            $revision->fill([
                'status' => self::STATE_SUBMITTED,
                'submitted_by' => $user->id,
                'submitted_at' => Carbon::now(),
            ])->save();

            $this->logger->record(
                event: 'sop_revision.submitted',
                subject: $revision,
                old: [], new: ['status' => self::STATE_SUBMITTED],
            );

            return $revision->fresh();
        });
    }

    public function approve(SopRevision $revision, User $user): SopRevision
    {
        $this->requireStatus($revision, self::STATE_SUBMITTED);

        if ($revision->submitted_by !== null && (int) $revision->submitted_by === (int) $user->id) {
            throw new DomainException('A revision cannot be approved by its submitter.');
        }

        return DB::transaction(function () use ($revision, $user) {
            $revision->fill([
                'status' => self::STATE_APPROVED,
                'approved_by' => $user->id,
                'approved_at' => Carbon::now(),
            ])->save();

            $this->logger->record(
                event: 'sop_revision.approved',
                subject: $revision,
                old: [], new: ['status' => self::STATE_APPROVED, 'approved_by' => $user->id],
            );

            return $revision->fresh();
        });
    }

    public function makeEffective(SopRevision $revision, ?Carbon $effectiveAt = null): SopRevision
    {
        $this->requireStatus($revision, self::STATE_APPROVED);

        return DB::transaction(function () use ($revision, $effectiveAt) {
            $now = $effectiveAt ?? Carbon::now();

            // Supersede whichever revision is currently effective on this document.
            SopRevision::query()
                ->where('sop_document_id', $revision->sop_document_id)
                ->where('status', self::STATE_EFFECTIVE)
                ->update([
                    'status' => self::STATE_SUPERSEDED,
                    'superseded_at' => $now,
                ]);

            $revision->fill([
                'status' => self::STATE_EFFECTIVE,
                'effective_at' => $now,
            ])->save();

            SopDocument::query()
                ->where('id', $revision->sop_document_id)
                ->update([
                    'current_revision_id' => $revision->id,
                    'status' => 'active',
                    'effective_at' => $now,
                ]);

            $this->logger->record(
                event: 'sop_revision.effective',
                subject: $revision,
                old: [], new: ['status' => self::STATE_EFFECTIVE],
            );

            return $revision->fresh();
        });
    }

    public function acknowledge(SopRevision $revision, User $user, ?Request $request = null): SopAcknowledgement
    {
        if ($revision->status !== self::STATE_EFFECTIVE) {
            throw new DomainException('Only the currently effective revision can be acknowledged.');
        }

        $request ??= request() instanceof Request ? request() : null;

        return SopAcknowledgement::firstOrCreate(
            ['sop_revision_id' => $revision->id, 'user_id' => $user->id],
            [
                'acknowledged_at' => Carbon::now(),
                'ip_address' => $request?->ip(),
                'user_agent' => $request?->userAgent(),
            ],
        );
    }

    private function requireStatus(SopRevision $revision, string $expected): void
    {
        if ($revision->status !== $expected) {
            throw new DomainException(sprintf(
                'Revision is in state "%s" but must be "%s" for this action.',
                $revision->status,
                $expected,
            ));
        }
    }
}
