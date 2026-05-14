<?php

namespace Tests\Feature;

use App\Models\SopAcknowledgement;
use App\Models\SopDocument;
use App\Models\SopRevision;
use App\Models\User;
use App\Services\SopReleaseService;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SopReleaseWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private function newDocument(User $owner): SopDocument
    {
        return SopDocument::create([
            'code' => 'SOP-LAB-001',
            'title' => 'Specimen collection',
            'owner_user_id' => $owner->id,
            'status' => 'draft',
        ]);
    }

    private function newRevision(SopDocument $doc, int $rev = 1): SopRevision
    {
        return SopRevision::create([
            'sop_document_id' => $doc->id,
            'revision_number' => $rev,
            'change_summary' => "Initial draft (rev {$rev})",
            'status' => SopReleaseService::STATE_DRAFT,
        ]);
    }

    public function test_happy_path_draft_to_effective_and_supersedes_previous(): void
    {
        $svc = app(SopReleaseService::class);
        $owner = User::factory()->create();
        $approver = User::factory()->create();
        Auth::login($owner);

        $doc = $this->newDocument($owner);
        $rev1 = $this->newRevision($doc, 1);

        $rev1 = $svc->submit($rev1, $owner);
        $rev1 = $svc->approve($rev1, $approver);
        $rev1 = $svc->makeEffective($rev1);

        $this->assertSame(SopReleaseService::STATE_EFFECTIVE, $rev1->status);
        $this->assertSame($rev1->id, $doc->fresh()->current_revision_id);
        $this->assertSame('active', $doc->fresh()->status);

        // Now publish a second revision and make sure rev1 is superseded.
        $rev2 = $this->newRevision($doc, 2);
        $rev2 = $svc->submit($rev2, $owner);
        $rev2 = $svc->approve($rev2, $approver);
        $rev2 = $svc->makeEffective($rev2);

        $this->assertSame(SopReleaseService::STATE_EFFECTIVE, $rev2->status);
        $this->assertSame(SopReleaseService::STATE_SUPERSEDED, $rev1->fresh()->status);
        $this->assertSame($rev2->id, $doc->fresh()->current_revision_id);
    }

    public function test_submitter_cannot_approve_their_own_revision(): void
    {
        $svc = app(SopReleaseService::class);
        $author = User::factory()->create();
        Auth::login($author);

        $doc = $this->newDocument($author);
        $rev = $this->newRevision($doc);
        $rev = $svc->submit($rev, $author);

        $this->expectException(DomainException::class);
        $svc->approve($rev, $author);
    }

    public function test_acknowledgement_is_idempotent_per_user_per_revision(): void
    {
        $svc = app(SopReleaseService::class);
        $author = User::factory()->create();
        $approver = User::factory()->create();
        $reader = User::factory()->create();
        Auth::login($author);

        $doc = $this->newDocument($author);
        $rev = $this->newRevision($doc);
        $rev = $svc->submit($rev, $author);
        $rev = $svc->approve($rev, $approver);
        $rev = $svc->makeEffective($rev);

        $svc->acknowledge($rev, $reader);
        $svc->acknowledge($rev, $reader); // second call should not create a duplicate

        $this->assertSame(1, SopAcknowledgement::query()
            ->where('sop_revision_id', $rev->id)
            ->where('user_id', $reader->id)
            ->count());
    }
}
