@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Reagent Lots')
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
      <h5 class="mb-0 text-primary"><i class="bx bx-flask me-1"></i> Reagent Lots</h5>
      <p class="mb-0 small text-secondary">Rows highlighted yellow expire on or before {{ $expiryCutoff }}.</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
          <thead>
            <tr>
              <th>Item</th><th>Lot</th><th>Manufacturer</th><th>Received</th><th>Opened</th><th>Expires</th><th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($lots as $lot)
              @php
                $expiringSoon = $lot->expires_at && $lot->expires_at->lte(now()->addDays(30));
                $expired = $lot->expires_at && $lot->expires_at->lt(now()->startOfDay());
              @endphp
              <tr class="{{ $expired ? 'table-danger' : ($expiringSoon ? 'table-warning' : '') }}">
                <td>{{ $lot->item?->name ?? '—' }}</td>
                <td>{{ $lot->lot_number }}</td>
                <td>{{ $lot->manufacturer ?? '—' }}</td>
                <td>{{ optional($lot->received_at)->format('Y-m-d') ?? '—' }}</td>
                <td>{{ optional($lot->opened_at)->format('Y-m-d') ?? '—' }}</td>
                <td>
                  {{ optional($lot->expires_at)->format('Y-m-d') ?? '—' }}
                  @if ($expired) <span class="badge bg-danger ms-1">Expired</span> @endif
                </td>
                <td>@include('admin.quality._partials.badge', ['status' => $lot->status ?? 'unknown'])</td>
              </tr>
            @empty
              <tr><td colspan="7" class="text-center text-secondary py-4">No reagent lots recorded yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $lots->links() }}
    </div>
  </div>
@endsection
