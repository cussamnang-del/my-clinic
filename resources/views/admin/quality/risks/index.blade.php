@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Risk Register')
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
      <h5 class="mb-0 text-primary"><i class="bx bx-shield-quarter me-1"></i> Risk Register</h5>
      <p class="mb-0 small text-secondary">Sorted by inherent score (highest first). Rows highlighted red have an inherent score of 20+.</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
          <thead>
            <tr>
              <th>Code</th><th>Category</th><th>Description</th><th>Likelihood × Severity</th>
              <th>Inherent</th><th>Residual</th><th>Owner</th><th>Next review</th><th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($risks as $risk)
              <tr class="{{ $risk->inherent_score >= 20 ? 'table-danger' : ($risk->inherent_score >= 15 ? 'table-warning' : '') }}">
                <td><a href="{{ route('admin.quality.risks.show', $risk) }}">{{ $risk->code }}</a></td>
                <td>{{ $risk->category ?? '—' }}</td>
                <td class="text-truncate" style="max-width: 320px;">{{ $risk->description }}</td>
                <td>{{ $risk->inherent_likelihood ?? '—' }} × {{ $risk->inherent_severity ?? '—' }}</td>
                <td><strong>{{ $risk->inherent_score ?? '—' }}</strong></td>
                <td>{{ $risk->residual_score ?? '—' }}</td>
                <td>{{ $risk->owner?->name ?? '—' }}</td>
                <td>{{ optional($risk->next_review_at)->format('Y-m-d') ?? '—' }}</td>
                <td>@include('admin.quality._partials.badge', ['status' => $risk->status ?? 'open'])</td>
              </tr>
            @empty
              <tr><td colspan="9" class="text-center text-secondary py-4">Risk register is empty.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $risks->links() }}
    </div>
  </div>
@endsection
