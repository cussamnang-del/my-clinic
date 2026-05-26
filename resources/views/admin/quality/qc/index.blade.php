@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Quality Control')

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <form method="GET" class="row g-2 align-items-end">
        <div class="col-12 col-md-3">
          <label class="form-label small text-secondary">Analyte</label>
          <select name="analyte" class="form-select form-select-sm">
            <option value="">All</option>
            @foreach ($analytes as $a)
              <option value="{{ $a }}" @selected($filters['analyte'] === $a)>{{ $a }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-3">
          <label class="form-label small text-secondary">Level</label>
          <select name="level" class="form-select form-select-sm">
            <option value="">All</option>
            @foreach ($levels as $l)
              <option value="{{ $l }}" @selected($filters['level'] === $l)>{{ $l }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-3">
          <label class="form-label small text-secondary">Lot #</label>
          <input type="text" name="lot_number" value="{{ $filters['lot_number'] }}" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-sm btn-primary">Filter</button>
          @if ($filters['analyte'] && $filters['level'])
            <a class="btn btn-sm btn-outline-primary"
               href="{{ route('admin.quality.qc.chart', array_filter($filters)) }}">
              <i class="bx bx-line-chart"></i> Open Levey-Jennings chart
            </a>
          @endif
        </div>
      </form>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
          <thead>
            <tr>
              <th>Measured</th><th>Analyte</th><th>Level</th><th>Lot</th><th>Equipment</th>
              <th>Value</th><th>Mean ± SD</th><th>Westgard</th><th>Status</th><th>Operator</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($results as $r)
              <tr class="{{ in_array($r->westgard_flag, ['1-3s', '2-2s', 'R-4s']) ? 'table-danger' : ($r->westgard_flag === '1-2s' ? 'table-warning' : '') }}">
                <td>{{ $r->measured_at?->format('Y-m-d H:i') ?? '—' }}</td>
                <td>{{ $r->analyte }}</td>
                <td>{{ $r->level }}</td>
                <td>{{ $r->lot_number ?? '—' }}</td>
                <td>{{ $r->equipment?->code ?? '—' }}</td>
                <td><strong>{{ $r->value }}</strong> {{ $r->unit }}</td>
                <td>{{ $r->mean ?? '—' }} ± {{ $r->sd ?? '—' }}</td>
                <td>{{ $r->westgard_flag ?? '—' }}</td>
                <td>@include('admin.quality._partials.badge', ['status' => $r->status])</td>
                <td>{{ $r->operator?->name ?? '—' }}</td>
              </tr>
            @empty
              <tr><td colspan="10" class="text-center text-secondary py-4">No QC results recorded.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $results->links() }}
    </div>
  </div>
@endsection
