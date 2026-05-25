<?php

namespace App\Http\Controllers\Admin\Quality;

use App\Http\Controllers\Controller;
use App\Models\Risk;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Read-only listing for the Risk Register.
 *
 * ISO 9001:2015 §6.1 ("Actions to address risks and opportunities").
 * Highlights risks with an inherent score of 15+ (high) so the
 * quality manager can prioritise mitigations.
 */
class RiskController extends Controller
{
    protected string $prefix = 'risk_';

    public function index(): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $risks = Risk::query()
            ->with('owner')
            ->orderByDesc('inherent_score')
            ->paginate(25);

        return view('admin.quality.risks.index', [
            'prefix' => $this->prefix,
            'risks' => $risks,
        ]);
    }

    public function show(Risk $risk): View
    {
        abort_if(Gate::denies($this->prefix.'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $risk->load('owner');

        return view('admin.quality.risks.show', [
            'prefix' => $this->prefix,
            'risk' => $risk,
        ]);
    }
}
