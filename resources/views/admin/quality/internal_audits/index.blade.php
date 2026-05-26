@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Internal Audits')
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
      <h5 class="mb-0 text-primary"><i class="bx bx-search me-1"></i> Internal Audits</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
          <thead>
            <tr>
              <th>Code</th><th>Scope</th><th>Lead</th>
              <th>Scheduled</th><th>Started</th><th>Completed</th>
              <th>Findings</th><th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($audits as $audit)
              <tr>
                <td><a href="{{ route('admin.quality.internal_audits.show', $audit) }}">{{ $audit->code }}</a></td>
                <td class="text-truncate" style="max-width: 280px;">{{ $audit->scope ?? '—' }}</td>
                <td>{{ $audit->leadAuditor?->name ?? '—' }}</td>
                <td>{{ optional($audit->scheduled_at)->format('Y-m-d') ?? '—' }}</td>
                <td>{{ optional($audit->started_at)->format('Y-m-d') ?? '—' }}</td>
                <td>{{ optional($audit->completed_at)->format('Y-m-d') ?? '—' }}</td>
                <td>{{ $audit->findings_count ?? $audit->findings->count() }}</td>
                <td>@include('admin.quality._partials.badge', ['status' => $audit->status])</td>
              </tr>
            @empty
              <tr><td colspan="8" class="text-center text-secondary py-4">No audits scheduled.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $audits->links() }}
    </div>
  </div>
@endsection
