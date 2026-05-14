<?php

namespace Tests\Feature;

use App\Models\Bio;
use App\Models\BioDetail;
use App\Models\Customer;
use App\Models\Document;
use App\Models\Item;
use App\Models\ItemGroup;
use App\Models\ItemType;
use App\Models\User;
use App\Services\ResultReleaseService;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ResultReleaseWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private Customer $customer;

    private Document $document;

    private Bio $bio;

    private ItemGroup $group;

    private ItemType $type;

    private Item $item;

    protected function setUp(): void
    {
        parent::setUp();

        // SQLite enforces foreign keys when the driver opens; the legacy
        // schema has FK chains (bios.user_id, bios.item_id) we need to
        // satisfy. Disabling FK checks for the test setup is simpler than
        // hand-wiring all the parent rows.
        DB::statement('PRAGMA foreign_keys = OFF');

        $admin = User::factory()->create();
        Auth::login($admin);

        $this->customer = Customer::create([
            'name' => 'Test',
            'sex' => 'M',
            'province_id' => 1, 'district_id' => 1, 'commune_id' => 1, 'village_id' => 1,
        ]);

        $this->group = ItemGroup::create(['name' => 'Haematology']);
        $this->type = ItemType::create(['name' => 'CBC', 'item_group_id' => $this->group->id]);
        $this->item = Item::create([
            'item_name' => 'Haemoglobin',
            'item_group_id' => $this->group->id,
            'item_type_id' => $this->type->id,
        ]);

        $this->document = Document::create([
            'customer_id' => $this->customer->id,
            'user_id' => $admin->id,
        ]);

        $this->bio = Bio::create([
            'customer_id' => $this->customer->id,
            'document_id' => $this->document->id,
            'user_id' => $admin->id,
            'item_id' => $this->item->id,
        ]);

        Auth::logout();
    }

    private function makeResult(): BioDetail
    {
        return BioDetail::create([
            'bio_id' => $this->bio->id,
            'customer_id' => $this->customer->id,
            'document_id' => $this->document->id,
            'item_group_id' => $this->group->id,
            'item_type_id' => $this->type->id,
            'date' => now(),
            'result' => '13.5',
            'result_status' => ResultReleaseService::STATE_DRAFT,
        ]);
    }

    public function test_happy_path_draft_to_released(): void
    {
        $svc = app(ResultReleaseService::class);
        $tech = User::factory()->create();
        $reviewer = User::factory()->create();
        $releaser = User::factory()->create();

        $result = $this->makeResult();

        Auth::login($tech);
        $result = $svc->submit($result, $tech);
        $this->assertSame(ResultReleaseService::STATE_SUBMITTED, $result->result_status);

        Auth::login($reviewer);
        $result = $svc->review($result, $reviewer);
        $this->assertSame(ResultReleaseService::STATE_REVIEWED, $result->result_status);

        Auth::login($releaser);
        $result = $svc->release($result, $releaser);
        $this->assertSame(ResultReleaseService::STATE_RELEASED, $result->result_status);
        $this->assertNotNull($result->released_at);
        $this->assertSame($releaser->id, $result->released_by);
    }

    public function test_cannot_review_own_submission(): void
    {
        $svc = app(ResultReleaseService::class);
        $tech = User::factory()->create();

        $result = $this->makeResult();

        Auth::login($tech);
        $result = $svc->submit($result, $tech);

        $this->expectException(DomainException::class);
        $svc->review($result, $tech);
    }

    public function test_cannot_skip_states(): void
    {
        $svc = app(ResultReleaseService::class);
        $tech = User::factory()->create();
        $reviewer = User::factory()->create();

        $result = $this->makeResult();

        Auth::login($reviewer);
        $this->expectException(DomainException::class);
        $svc->release($result, $reviewer);
    }

    public function test_amendment_requires_reason_and_creates_new_row(): void
    {
        $svc = app(ResultReleaseService::class);
        $tech = User::factory()->create();
        $reviewer = User::factory()->create();
        $releaser = User::factory()->create();

        $result = $this->makeResult();
        Auth::login($tech);
        $result = $svc->submit($result, $tech);
        Auth::login($reviewer);
        $result = $svc->review($result, $reviewer);
        Auth::login($releaser);
        $result = $svc->release($result, $releaser);

        // Empty reason rejected.
        try {
            $svc->amend($result, $releaser, '14.0', '');
            $this->fail('Empty reason should throw');
        } catch (DomainException $e) {
            $this->assertStringContainsString('reason', strtolower($e->getMessage()));
        }

        $amendment = $svc->amend($result, $releaser, '14.0', 'Reagent calibration corrected.');

        $this->assertNotSame($result->id, $amendment->id);
        $this->assertSame($result->id, $amendment->amends_id);
        $this->assertSame('14.0', $amendment->result);
        $this->assertSame(ResultReleaseService::STATE_RELEASED, $amendment->result_status);

        $original = $result->fresh();
        $this->assertSame(ResultReleaseService::STATE_AMENDED, $original->result_status);
        $this->assertSame('Reagent calibration corrected.', $original->amendment_reason);
    }
}
