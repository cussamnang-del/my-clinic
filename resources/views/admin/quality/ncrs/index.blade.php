@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Non-conformances')
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
      <h5 class="mb-0 text-primary"><i class="bx bx-error-circle me-1"></i> Non-conformance Reports (NCR)</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
          <thead>
            <tr>
              <th>Code</th><th>Title</th><th>Source</th><th>Severity</th><th>Reported</th>
              <th>CAPA</th><th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($ncrs as $ncr)
              <tr>
                <td><a href="{{ route('admin.quality.ncrs.show', $ncr) }}">{{ $ncr->code }}</a></td>
                <td>{{ $ncr->title }}</td>
                <td>{{ $ncr->source ?? '—' }}</td>
                <td>@include('admin.quality._partials.badge', ['status' => $ncr->severity ?? 'unknown'])</td>
                <td>{{ optional($ncr->reported_at)->format('Y-m-d') ?? '—' }}</td>
                <td>{{ $ncr->capaActions->count() }}</td>
                <td>@include('admin.quality._partials.badge', ['status' => $ncr->status])</td>
              </tr>
            @empty
              <tr><td colspan="7" class="text-center text-secondary py-4">No NCRs raised yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $ncrs->links() }}
    </div>
  </div>
@endsection
