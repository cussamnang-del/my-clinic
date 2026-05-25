<?php

namespace App\Http\Controllers\Admin\Quality;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Read-only listing for the Equipment register + calibration status.
 *
 * Highlights rows whose next_calibration_due_at is within 30 days, so
 * the lab can plan calibration runs (ISO 15189:2022 §6.4 / §6.5).
 */
class EquipmentController extends Controller
{
    protected string $prefix = 'equipment_';

    public function index(): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $equipment = Equipment::query()
            ->orderBy('code')
            ->paginate(25);

        $cutoff = now()->addDays(30)->toDateString();

        return view('admin.quality.equipment.index', [
            'prefix' => $this->prefix,
            'equipment' => $equipment,
            'dueCutoff' => $cutoff,
        ]);
    }

    public function show(Equipment $equipment): View
    {
        abort_if(Gate::denies($this->prefix.'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $equipment->load('calibrations');

        return view('admin.quality.equipment.show', [
            'prefix' => $this->prefix,
            'equipment' => $equipment,
        ]);
    }
}
