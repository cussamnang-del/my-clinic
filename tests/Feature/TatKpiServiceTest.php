<?php

namespace Tests\Feature;

use App\Models\BioDetail;
use App\Models\User;
use App\Services\TatKpiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Smoke test for the TatKpiService — covers the summary shape,
 * the on-time % calculation, the breach detector, and that
 * pending rows contribute to total/pending but not to released
 * statistics.
 */
class TatKpiServiceTest extends TestCase
{
    use RefreshDatabase;

    private TatKpiService $service;

    protected function setUp(): void
    {
        parent::setUp();
        DB::statement('PRAGMA foreign_keys = OFF');
        Auth::login(User::factory()->create());
        $this->service = new TatKpiService;
        config()->set('observability.tat_target_minutes', 120);
    }

    public function test_summary_counts_released_and_pending(): void
    {
        $base = Carbon::parse('2024-01-15 08:00:00');
        Carbon::setTestNow($base->copy()->addHours(2));

        // On-time: 60 min < 120 target.
        $this->makeRow($base, $base->copy()->addMinutes(60));
        // Breach: 200 min > 120 target.
        $this->makeRow($base->copy()->subHours(1), $base->copy()->addMinutes(140));
        // Still pending — submitted but no released_at.
        $this->makeRow($base, null);

        $summary = $this->service->summary(
            Carbon::parse('2024-01-14 00:00:00'),
            Carbon::parse('2024-01-16 00:00:00'),
        );

        $this->assertSame(3, $summary['total']);
        $this->assertSame(2, $summary['released']);
        $this->assertSame(1, $summary['pending']);
        $this->assertSame(1, $summary['breached']);
        $this->assertSame(120, $summary['target_minutes']);
        $this->assertSame(50.0, $summary['on_time_pct']); // 1 on-time out of 2 released.

        Carbon::setTestNow();
    }

    public function test_breaches_includes_pending_past_target(): void
    {
        Carbon::setTestNow(Carbon::parse('2024-01-15 08:00:00'));

        // Submitted 4 hours ago and never released — beyond target.
        $this->makeRow(now()->subHours(4), null);
        // Submitted 1 hour ago and never released — still within target.
        $this->makeRow(now()->subHour(), null);

        $breaches = $this->service->breaches(10);

        $this->assertCount(1, $breaches);
        $this->assertNull($breaches->first()->released_at);

        Carbon::setTestNow();
    }

    private function makeRow(Carbon $submittedAt, ?Carbon $releasedAt): BioDetail
    {
        // bio_details has NOT NULL columns we don't care about for the
        // KPI math; fill them with stub IDs since FKs are off in tests.
        return BioDetail::create([
            'bio_id' => 1,
            'customer_id' => 1,
            'document_id' => 1,
            'item_group_id' => 1,
            'item_type_id' => 1,
            'date' => $submittedAt,
            'submitted_at' => $submittedAt,
            'released_at' => $releasedAt,
            'result_status' => $releasedAt ? 'released' : 'submitted_for_review',
        ]);
    }
}
