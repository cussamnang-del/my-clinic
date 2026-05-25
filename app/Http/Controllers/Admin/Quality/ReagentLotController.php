<?php

namespace App\Http\Controllers\Admin\Quality;

use App\Http\Controllers\Controller;
use App\Models\ReagentLot;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Read-only listing for reagent lots, with expiry alerts.
 *
 * ISO 15189:2022 §6.4.3 ("Reagents and consumables") requires that
 * reagents are tracked by lot and that expired lots are prevented
 * from being used. The listing highlights lots expiring within 30
 * days to give the lab a heads-up.
 */
class ReagentLotController extends Controller
{
    protected string $prefix = 'reagent_lot_';

    public function index(): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lots = ReagentLot::query()
            ->with('item')
            ->orderByDesc('received_at')
            ->paginate(25);

        return view('admin.quality.reagents.index', [
            'prefix' => $this->prefix,
            'lots' => $lots,
            'expiryCutoff' => now()->addDays(30)->toDateString(),
        ]);
    }
}
