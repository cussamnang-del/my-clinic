<?php

namespace App\Http\Controllers\Admin\Quality;

use App\Http\Controllers\Controller;
use App\Models\NonConformance;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Read-only listing for Non-conformance Reports (NCRs) and their
 * linked CAPA actions.
 *
 * ISO 9001:2015 §10.2 ("Nonconformity and corrective action").
 */
class NonConformanceController extends Controller
{
    protected string $prefix = 'non_conformance_';

    public function index(): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ncrs = NonConformance::query()
            ->with('capaActions')
            ->orderByDesc('reported_at')
            ->paginate(25);

        return view('admin.quality.ncrs.index', [
            'prefix' => $this->prefix,
            'ncrs' => $ncrs,
        ]);
    }

    public function show(NonConformance $ncr): View
    {
        abort_if(Gate::denies($this->prefix.'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ncr->load(['capaActions', 'reporter']);

        return view('admin.quality.ncrs.show', [
            'prefix' => $this->prefix,
            'ncr' => $ncr,
        ]);
    }
}
