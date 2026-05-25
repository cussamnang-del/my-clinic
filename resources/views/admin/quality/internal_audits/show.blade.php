@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Internal Audit — '.$audit->code)
  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <h4 class="mb-3">{{ $audit->code }}</h4>
      <dl class="row mb-0">
        <dt class="col-sm-3">Scope</dt><dd class="col-sm-9">{{ $audit->scope }}</dd>
        <dt class="col-sm-3">Lead auditor</dt><dd class="col-sm-9">{{ $audit->leadAuditor?->name ?? '—' }}</dd>
        <dt class="col-sm-3">Scheduled</dt><dd class="col-sm-9">{{ optional($audit->scheduled_at)->format('Y-m-d') ?? '—' }}</dd>
        <dt class="col-sm-3">Started / completed</dt>
        <dd class="col-sm-9">{{ optional($audit->started_at)->format('Y-m-d') ?? '—' }} → {{ optional($audit->completed_at)->format('Y-m-d') ?? '—' }}</dd>
        <dt class="col-sm-3">Status</dt><dd class="col-sm-9">@include('admin.quality._partials.badge', ['status' => $audit->status])</dd>
      </dl>
      @if ($audit->summary)
        <hr><h6>Summary</h6><p class="mb-0">{{ $audit->summary }}</p>
      @endif
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><h5 class="mb-0">Findings</h5></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead>
            <tr><th>Type</th><th>Severity</th><th>Clause</th><th>Description</th><th>NCR</th></tr>
          </thead>
          <tbody>
            @forelse ($audit->findings as $finding)
              <tr>
                <td>{{ $finding->finding_type }}</td>
                <td>@include('admin.quality._partials.badge', ['status' => $finding->severity ?? 'unknown'])</td>
                <td>{{ $finding->clause_reference ?? '—' }}</td>
                <td class="text-truncate" style="max-width: 360px;">{{ $finding->description }}</td>
                <td>{{ $finding->non_conformance_id ? '#'.$finding->non_conformance_id : '—' }}</td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center text-secondary py-4">No findings recorded.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
