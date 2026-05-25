<?php

namespace App\Http\Controllers\Admin\Quality;

use App\Http\Controllers\Controller;
use App\Models\InternalAudit;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Read-only listing for Internal Audit cycles + findings.
 *
 * ISO 9001:2015 §9.2 ("Internal audit"). The listing surfaces the
 * audit calendar and per-cycle findings count so the QMS team can
 * plan follow-ups against scheduled but not-yet-started cycles.
 */
class InternalAuditController extends Controller
{
    protected string $prefix = 'internal_audit_';

    public function index(): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $audits = InternalAudit::query()
            ->with(['leadAuditor', 'findings'])
            ->withCount('findings')
            ->orderByDesc('scheduled_at')
            ->paginate(25);

        return view('admin.quality.internal_audits.index', [
            'prefix' => $this->prefix,
            'audits' => $audits,
        ]);
    }

    public function show(InternalAudit $audit): View
    {
        abort_if(Gate::denies($this->prefix.'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $audit->load(['findings', 'leadAuditor']);

        return view('admin.quality.internal_audits.show', [
            'prefix' => $this->prefix,
            'audit' => $audit,
        ]);
    }
}
