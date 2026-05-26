@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Result Release Worklist')

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 text-primary"><i class="bx bx-check-double me-1"></i> Result Release Worklist</h5>
    <div class="btn-group">
      <a class="btn btn-sm {{ $status === 'pending' ? 'btn-primary' : 'btn-outline-primary' }}"
         href="{{ route('admin.quality.results.index', ['status' => 'pending']) }}">Pending</a>
      <a class="btn btn-sm {{ $status === 'released' ? 'btn-primary' : 'btn-outline-primary' }}"
         href="{{ route('admin.quality.results.index', ['status' => 'released']) }}">Released</a>
      <a class="btn btn-sm {{ $status === 'amended' ? 'btn-primary' : 'btn-outline-primary' }}"
         href="{{ route('admin.quality.results.index', ['status' => 'amended']) }}">Amended</a>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
          <thead>
            <tr>
              <th>#</th><th>Customer</th><th>Test</th><th>Result</th><th>Workflow</th>
              <th>Submitted</th><th>Reviewed</th><th>Released</th><th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($results as $r)
              <tr>
                <td>#{{ $r->id }}</td>
                <td>{{ $r->customer?->name ?? '—' }}</td>
                <td>{{ $r->itemType?->name ?? '—' }}</td>
                <td><strong>{{ $r->result ?? '—' }}</strong></td>
                <td>@include('admin.quality._partials.badge', ['status' => $r->result_status ?? 'draft'])</td>
                <td>{{ optional($r->submitted_at)->format('Y-m-d H:i') ?? '—' }}</td>
                <td>{{ optional($r->reviewed_at)->format('Y-m-d H:i') ?? '—' }}</td>
                <td>{{ optional($r->released_at)->format('Y-m-d H:i') ?? '—' }}</td>
                <td><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.quality.results.show', $r) }}">Open</a></td>
              </tr>
            @empty
              <tr><td colspan="9" class="text-center text-secondary py-4">No results in this state.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $results->links() }}
    </div>
  </div>
@endsection
