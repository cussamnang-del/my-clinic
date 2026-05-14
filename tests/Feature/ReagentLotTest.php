<?php

namespace Tests\Feature;

use App\Models\ReagentLot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ReagentLotTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Auth::login(User::factory()->create());
    }

    public function test_shelf_expired_when_expires_at_in_past(): void
    {
        $lot = ReagentLot::create([
            'lot_number' => 'LOT-001',
            'expires_at' => Carbon::now()->subDay(),
            'status' => 'in_use',
        ]);

        $this->assertTrue($lot->isShelfExpired());
        $this->assertFalse($lot->isUsable());
    }

    public function test_in_use_expired_when_open_use_window_exceeded(): void
    {
        $lot = ReagentLot::create([
            'lot_number' => 'LOT-002',
            'expires_at' => Carbon::now()->addYear(),
            'opened_at' => Carbon::now()->subDays(40),
            'open_use_days_allowed' => 30,
            'status' => 'in_use',
        ]);

        $this->assertFalse($lot->isShelfExpired());
        $this->assertTrue($lot->isInUseExpired());
        $this->assertFalse($lot->isUsable());
    }

    public function test_usable_when_unopened_and_unexpired(): void
    {
        $lot = ReagentLot::create([
            'lot_number' => 'LOT-003',
            'expires_at' => Carbon::now()->addYear(),
            'status' => 'received',
        ]);

        $this->assertTrue($lot->isUsable());
    }
}
