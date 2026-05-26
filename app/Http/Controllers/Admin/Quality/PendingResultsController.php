<?php

namespace App\Http\Controllers\Admin\Quality;

use App\Http\Controllers\Controller;
use App\Models\BioDetail;
use App\Services\ResultReleaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pending-results worklist + the result-release UI.
 *
 * Lists BioDetail rows that still need a workflow transition (draft,
 * submitted_for_review, reviewed) and renders the e-signature form
 * for the next step. Submitting the form posts to one of the
 * existing ResultReleaseController endpoints, so all
 * state-transition rules (segregation of duties, audit log) stay in
 * the service layer.
 */
class PendingResultsController extends Controller
{
    protected string $prefix = 'quality_';

    public function index(Request $request): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = $request->string('status', 'pending')->toString();

        $query = BioDetail::query()
            ->with(['customer', 'itemType', 'bio'])
            ->orderByDesc('updated_at');

        if ($status === 'released') {
            $query->where('result_status', ResultReleaseService::STATE_RELEASED);
        } elseif ($status === 'amended') {
            $query->where('result_status', ResultReleaseService::STATE_AMENDED);
        } else {
            $query->whereIn('result_status', [
                ResultReleaseService::STATE_DRAFT,
                ResultReleaseService::STATE_SUBMITTED,
                ResultReleaseService::STATE_REVIEWED,
            ]);
        }

        $results = $query->paginate(25)->appends($request->query());

        return view('admin.quality.results.index', [
            'prefix' => $this->prefix,
            'status' => $status,
            'results' => $results,
        ]);
    }

    public function show(BioDetail $biodetail): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biodetail->load(['customer', 'itemType', 'bio']);

        return view('admin.quality.results.show', [
            'prefix' => $this->prefix,
            'biodetail' => $biodetail,
        ]);
    }
}
