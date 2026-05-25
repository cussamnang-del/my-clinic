<?php

namespace Tests\Feature;

use App\Models\QcResult;
use App\Models\User;
use App\Services\QcStatisticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * Covers the four Westgard rules implemented in QcStatisticsService
 * plus the chart-data shape the Blade view depends on.
 *
 * The lab considers a run "out of control" when any reject-level
 * Westgard rule fires (1-3s / 2-2s / R-4s). 1-2s is warning-only.
 */
class QcStatisticsTest extends TestCase
{
    use RefreshDatabase;

    private QcStatisticsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new QcStatisticsService;
        Auth::login(User::factory()->create());
    }

    public function test_classify_returns_null_when_no_sd(): void
    {
        $this->assertNull($this->service->classify(10.0, null, null, null, 10.0, null));
    }

    public function test_classify_returns_1_3s_when_value_beyond_3_sd(): void
    {
        // Mean 100, SD 5 → 3 SD line at 115.
        $this->assertSame('1-3s', $this->service->classify(118.0, null, 3.6, null, 100.0, 5.0));
        $this->assertSame('1-3s', $this->service->classify(80.0, null, -4.0, null, 100.0, 5.0));
    }

    public function test_classify_returns_2_2s_for_two_consecutive_same_side_beyond_2_sd(): void
    {
        // Both points +2.5 SD → 2-2s on the high side.
        $this->assertSame('2-2s', $this->service->classify(112.5, 112.5, 2.5, 2.5, 100.0, 5.0));
    }

    public function test_classify_returns_r_4s_when_range_exceeds_4_sd(): void
    {
        // Previous +2.5 SD, current −2.5 SD → range = 5 SD → R-4s.
        $this->assertSame('R-4s', $this->service->classify(87.5, 112.5, -2.5, 2.5, 100.0, 5.0));
    }

    public function test_classify_returns_1_2s_warning_when_only_one_above_2_sd(): void
    {
        // Single point +2.2 SD with no comparable previous → warning.
        $this->assertSame('1-2s', $this->service->classify(111.0, null, 2.2, null, 100.0, 5.0));
    }

    public function test_baseline_returns_mean_and_sample_sd(): void
    {
        $values = collect([10, 12, 11, 9, 13]);
        $baseline = $this->service->baseline($values);

        $this->assertSame(5, $baseline['n']);
        $this->assertSame(11.0, $baseline['mean']);
        // Sample SD of [10,12,11,9,13] is sqrt(2.5) ≈ 1.58.
        $this->assertEqualsWithDelta(1.58, $baseline['sd'], 0.01);
    }

    public function test_build_chart_data_returns_in_control_dataset(): void
    {
        $this->seedRuns([
            ['2024-01-01 09:00', 100.0],
            ['2024-01-02 09:00', 102.0],
            ['2024-01-03 09:00', 99.0],
        ]);

        $chart = $this->service->buildChartData('Glucose', 'normal', 'LOT-1');

        $this->assertCount(3, $chart['points']);
        $this->assertTrue($chart['in_control']);
        $this->assertSame(100.0, (float) $chart['mean']);
        $this->assertSame(5.0, (float) $chart['sd']);
    }

    public function test_build_chart_data_flags_out_of_control_run(): void
    {
        // Big jump in the third run trips 1-3s.
        $this->seedRuns([
            ['2024-01-01 09:00', 100.0],
            ['2024-01-02 09:00', 99.0],
            ['2024-01-03 09:00', 130.0],
        ]);

        $chart = $this->service->buildChartData('Glucose', 'normal', 'LOT-1');

        $this->assertFalse($chart['in_control']);
        $this->assertSame('1-3s', $chart['points'][2]['flag']);
    }

    /**
     * @param  array<int, array{0: string, 1: float}>  $runs
     */
    private function seedRuns(array $runs, float $mean = 100.0, float $sd = 5.0): void
    {
        foreach ($runs as $r) {
            QcResult::create([
                'analyte' => 'Glucose',
                'control_name' => 'BioRad L1',
                'level' => 'normal',
                'lot_number' => 'LOT-1',
                'value' => $r[1],
                'unit' => 'mg/dL',
                'mean' => $mean,
                'sd' => $sd,
                'measured_at' => $r[0],
                'status' => 'accepted',
            ]);
        }
    }
}
