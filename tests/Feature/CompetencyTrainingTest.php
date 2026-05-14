<?php

namespace Tests\Feature;

use App\Models\Competency;
use App\Models\CompetencyAssessment;
use App\Models\TrainingRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CompetencyTrainingTest extends TestCase
{
    use RefreshDatabase;

    public function test_training_record_links_user_competency_and_trainer(): void
    {
        $user = User::factory()->create();
        $trainer = User::factory()->create();
        Auth::login($trainer);

        $competency = Competency::create([
            'code' => 'CMP-PHLEBOTOMY',
            'name' => 'Phlebotomy',
            'reassessment_interval_months' => 12,
        ]);

        $record = TrainingRecord::create([
            'user_id' => $user->id,
            'competency_id' => $competency->id,
            'trainer_id' => $trainer->id,
            'training_at' => '2026-01-15',
            'training_type' => 'onboarding',
        ]);

        $this->assertSame($user->id, $record->user->id);
        $this->assertSame($competency->id, $record->competency->id);
        $this->assertSame($trainer->id, $record->trainer->id);
    }

    public function test_reassessment_is_due_when_due_date_passed(): void
    {
        Auth::login(User::factory()->create());

        $user = User::factory()->create();
        $competency = Competency::create(['code' => 'CMP-CBC', 'name' => 'CBC']);

        $past = CompetencyAssessment::create([
            'user_id' => $user->id,
            'competency_id' => $competency->id,
            'assessed_at' => '2025-01-01',
            'result' => 'competent',
            'reassessment_due_at' => Carbon::now()->subMonth(),
        ]);
        $future = CompetencyAssessment::create([
            'user_id' => $user->id,
            'competency_id' => $competency->id,
            'assessed_at' => '2026-01-01',
            'result' => 'competent',
            'reassessment_due_at' => Carbon::now()->addMonth(),
        ]);

        $this->assertTrue($past->isReassessmentDue());
        $this->assertFalse($future->isReassessmentDue());
    }
}
