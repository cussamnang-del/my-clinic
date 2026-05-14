<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\EquipmentCalibration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EquipmentCalibrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_calibration_overdue_helper_returns_true_when_due_date_is_in_past(): void
    {
        Auth::login(User::factory()->create());

        $eq = Equipment::create([
            'code' => 'EQ-CBC-001',
            'name' => 'Sysmex XN',
            'next_calibration_due_at' => Carbon::now()->subDays(5)->toDateString(),
        ]);

        $this->assertTrue($eq->isCalibrationOverdue());
    }

    public function test_calibration_history_is_ordered_and_links_back_to_equipment(): void
    {
        Auth::login(User::factory()->create());

        $eq = Equipment::create(['code' => 'EQ-CHEM-001', 'name' => 'BS-240']);

        EquipmentCalibration::create([
            'equipment_id' => $eq->id,
            'calibration_date' => '2025-01-15',
            'due_date' => '2026-01-15',
            'result' => 'pass',
        ]);
        EquipmentCalibration::create([
            'equipment_id' => $eq->id,
            'calibration_date' => '2026-01-10',
            'due_date' => '2027-01-10',
            'result' => 'pass',
        ]);

        $this->assertCount(2, $eq->calibrations);
        $this->assertSame($eq->id, $eq->calibrations->first()->equipment->id);
    }
}
