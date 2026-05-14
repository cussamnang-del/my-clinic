<?php

namespace Tests\Feature;

use App\Models\Risk;
use App\Models\User;
use App\Services\RiskScoringService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Tests\TestCase;

class RiskScoringTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Auth::login(User::factory()->create());
    }

    public function test_inherent_score_is_likelihood_times_severity(): void
    {
        $svc = app(RiskScoringService::class);

        $this->assertSame(20, $svc->compute(4, 5));
        $this->assertSame(1, $svc->compute(1, 1));
        $this->assertSame(25, $svc->compute(5, 5));
    }

    public function test_out_of_range_inputs_throw(): void
    {
        $svc = app(RiskScoringService::class);

        $this->expectException(InvalidArgumentException::class);
        $svc->compute(0, 3);
    }

    public function test_band_accessor_classifies_scores_correctly(): void
    {
        $svc = app(RiskScoringService::class);

        $extreme = Risk::create([
            'code' => 'R-1', 'description' => 'x', 'likelihood' => 5, 'severity' => 5, 'score' => 25,
        ]);
        $high = Risk::create([
            'code' => 'R-2', 'description' => 'x', 'likelihood' => 4, 'severity' => 3, 'score' => 12,
        ]);
        $medium = Risk::create([
            'code' => 'R-3', 'description' => 'x', 'likelihood' => 2, 'severity' => 3, 'score' => 6,
        ]);
        $low = Risk::create([
            'code' => 'R-4', 'description' => 'x', 'likelihood' => 1, 'severity' => 2, 'score' => 2,
        ]);

        $this->assertSame('extreme', $extreme->band());
        $this->assertSame('high', $high->band());
        $this->assertSame('medium', $medium->band());
        $this->assertSame('low', $low->band());
    }

    public function test_service_persists_inherent_and_residual_scores(): void
    {
        $svc = app(RiskScoringService::class);

        $risk = Risk::create([
            'code' => 'R-99',
            'description' => 'Power outage during analyser run',
            'likelihood' => 3,
            'severity' => 4,
            'score' => 0, // intentionally stale — service should overwrite
            'residual_likelihood' => 2,
            'residual_severity' => 2,
            'residual_score' => 0,
        ]);

        $risk = $svc->score($risk);

        $this->assertSame(12, (int) $risk->score);
        $this->assertSame(4, (int) $risk->residual_score);
    }
}
