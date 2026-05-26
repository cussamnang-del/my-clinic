<?php

namespace App\Http\Controllers\Admin\Quality;

use App\Http\Controllers\Controller;
use App\Models\SopDocument;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Read-only listing for Document Control / SOPs.
 *
 * Backend (model + revisions table) shipped in Phase 3. Phase 5 wires
 * the listing so the QMS team can review the current SOP library
 * without poking the database directly. Edits remain manual until
 * Phase 6 — adding the editor here would silently bypass the
 * release-approval workflow in SopReleaseService.
 */
class SopDocumentController extends Controller
{
    protected string $prefix = 'sop_document_';

    public function index(): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $documents = SopDocument::query()
            ->with(['currentRevision', 'owner'])
            ->orderBy('code')
            ->paginate(25);

        return view('admin.quality.sop.index', [
            'prefix' => $this->prefix,
            'documents' => $documents,
        ]);
    }

    public function show(SopDocument $sop): View
    {
        abort_if(Gate::denies($this->prefix.'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sop->load(['revisions', 'currentRevision', 'owner']);

        return view('admin.quality.sop.show', [
            'prefix' => $this->prefix,
            'sop' => $sop,
        ]);
    }
}
