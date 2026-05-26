@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'SOP / Document Control')
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
      <h5 class="mb-0 text-primary"><i class="bx bx-book-open me-1"></i> SOP / Document Control</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
          <thead>
            <tr>
              <th>Code</th>
              <th>Title</th>
              <th>Category</th>
              <th>Owner</th>
              <th>Current rev.</th>
              <th>Effective</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($documents as $doc)
              <tr>
                <td><a href="{{ route('admin.quality.sop.show', $doc) }}">{{ $doc->code }}</a></td>
                <td>{{ $doc->title }}</td>
                <td>{{ $doc->category ?? '—' }}</td>
                <td>{{ $doc->owner?->name ?? '—' }}</td>
                <td>{{ $doc->currentRevision?->revision_number ?? '—' }}</td>
                <td>{{ optional($doc->effective_at)->format('Y-m-d') ?? '—' }}</td>
                <td>@include('admin.quality._partials.badge', ['status' => $doc->status])</td>
              </tr>
            @empty
              <tr><td colspan="7" class="text-center text-secondary py-4">No SOP documents yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $documents->links() }}
    </div>
  </div>
@endsection
