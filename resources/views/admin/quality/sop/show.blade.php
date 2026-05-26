@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'SOP — '.$sop->code)
  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <h4 class="mb-3">{{ $sop->code }} · {{ $sop->title }}</h4>
      <dl class="row mb-0">
        <dt class="col-sm-3">Category</dt><dd class="col-sm-9">{{ $sop->category ?? '—' }}</dd>
        <dt class="col-sm-3">Owner</dt><dd class="col-sm-9">{{ $sop->owner?->name ?? '—' }}</dd>
        <dt class="col-sm-3">Effective</dt><dd class="col-sm-9">{{ optional($sop->effective_at)->format('Y-m-d') ?? '—' }}</dd>
        <dt class="col-sm-3">Status</dt><dd class="col-sm-9">@include('admin.quality._partials.badge', ['status' => $sop->status])</dd>
      </dl>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><h5 class="mb-0">Revisions</h5></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead>
            <tr>
              <th>Rev.</th><th>Change summary</th><th>Submitted</th><th>Approved</th><th>Effective</th><th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($sop->revisions->sortByDesc('revision_number') as $rev)
              <tr>
                <td>{{ $rev->revision_number }}</td>
                <td class="text-truncate" style="max-width: 360px;">{{ $rev->change_summary ?? '—' }}</td>
                <td>{{ optional($rev->submitted_at)->format('Y-m-d') ?? '—' }}</td>
                <td>{{ optional($rev->approved_at)->format('Y-m-d') ?? '—' }}</td>
                <td>{{ optional($rev->effective_at)->format('Y-m-d') ?? '—' }}</td>
                <td>@include('admin.quality._partials.badge', ['status' => $rev->status])</td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-secondary py-4">No revisions yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
