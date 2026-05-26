@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'NCR — '.$ncr->code)
  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <h4 class="mb-3">{{ $ncr->code }} · {{ $ncr->title }}</h4>
      <dl class="row mb-0">
        <dt class="col-sm-3">Source</dt><dd class="col-sm-9">{{ $ncr->source ?? '—' }}</dd>
        <dt class="col-sm-3">Severity</dt><dd class="col-sm-9">@include('admin.quality._partials.badge', ['status' => $ncr->severity ?? 'unknown'])</dd>
        <dt class="col-sm-3">Status</dt><dd class="col-sm-9">@include('admin.quality._partials.badge', ['status' => $ncr->status])</dd>
        <dt class="col-sm-3">Reported</dt><dd class="col-sm-9">{{ optional($ncr->reported_at)->format('Y-m-d H:i') ?? '—' }} by {{ $ncr->reporter?->name ?? '—' }}</dd>
        <dt class="col-sm-3">Closed</dt><dd class="col-sm-9">{{ optional($ncr->closed_at)->format('Y-m-d H:i') ?? '—' }}</dd>
      </dl>
      @if ($ncr->description)
        <hr><h6>Description</h6><p class="mb-2">{{ $ncr->description }}</p>
      @endif
      @if ($ncr->immediate_action)
        <h6>Immediate action</h6><p class="mb-0">{{ $ncr->immediate_action }}</p>
      @endif
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><h5 class="mb-0">CAPA actions</h5></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead>
            <tr>
              <th>Type</th><th>Root cause</th><th>Action plan</th><th>Assignee</th><th>Due</th><th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($ncr->capaActions->sortBy('due_at') as $capa)
              <tr>
                <td>{{ $capa->action_type }}</td>
                <td class="text-truncate" style="max-width: 200px;">{{ $capa->root_cause ?? '—' }}</td>
                <td class="text-truncate" style="max-width: 240px;">{{ $capa->action_plan ?? '—' }}</td>
                <td>{{ $capa->assignee?->name ?? '—' }}</td>
                <td>{{ optional($capa->due_at)->format('Y-m-d') ?? '—' }}</td>
                <td>@include('admin.quality._partials.badge', ['status' => $capa->status])</td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-secondary py-4">No CAPA actions linked.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
