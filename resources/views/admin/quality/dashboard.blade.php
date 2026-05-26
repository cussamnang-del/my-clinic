@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Quality Dashboard')

  <div class="row mb-3">
    @foreach ($cards as $key => $card)
      <div class="col-12 col-md-6 col-xl-3 mb-3">
        <a href="{{ route($card['route']) }}" class="text-decoration-none">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex align-items-start justify-content-between">
                <div>
                  <p class="mb-0 text-secondary small">{{ $card['label'] }}</p>
                  <h3 class="my-1 fw-bold text-primary">{{ $card['total'] }}</h3>
                  <span class="badge {{ $card['attention'] > 0 ? 'bg-warning text-dark' : 'bg-light text-secondary' }}">
                    {{ $card['attention'] }} · {{ $card['attention_label'] }}
                  </span>
                </div>
                <div class="ms-3 text-primary fs-2"><i class="{{ $card['icon'] }}"></i></div>
              </div>
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>

  <div class="row">
    <div class="col-12 col-xl-8">
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Turn-Around Time — last 7 days</h5>
            <a href="{{ route('admin.quality.tat.index') }}" class="btn btn-sm btn-outline-primary">Open TAT dashboard</a>
          </div>
          <div class="row text-center">
            <div class="col-6 col-md-3">
              <p class="text-secondary mb-1 small">On-time %</p>
              <h4 class="mb-0 fw-bold {{ $tat['on_time_pct'] >= 90 ? 'text-success' : ($tat['on_time_pct'] >= 75 ? 'text-warning' : 'text-danger') }}">
                {{ number_format($tat['on_time_pct'], 1) }}%
              </h4>
            </div>
            <div class="col-6 col-md-3">
              <p class="text-secondary mb-1 small">Median TAT</p>
              <h4 class="mb-0 fw-bold">{{ $tat['median_minutes'] !== null ? $tat['median_minutes'].' min' : '—' }}</h4>
            </div>
            <div class="col-6 col-md-3">
              <p class="text-secondary mb-1 small">P90 TAT</p>
              <h4 class="mb-0 fw-bold">{{ $tat['p90_minutes'] !== null ? $tat['p90_minutes'].' min' : '—' }}</h4>
            </div>
            <div class="col-6 col-md-3">
              <p class="text-secondary mb-1 small">Breaches</p>
              <h4 class="mb-0 fw-bold {{ $tat['breached'] === 0 ? 'text-success' : 'text-danger' }}">
                {{ $tat['breached'] }}
              </h4>
            </div>
          </div>
          <p class="small text-secondary mt-3 mb-0">
            Target: {{ $tat['target_minutes'] }} min · Released {{ $tat['released'] }} / {{ $tat['total'] }} requests · Pending {{ $tat['pending'] }}
          </p>
        </div>
      </div>
    </div>
    <div class="col-12 col-xl-4">
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
          <h5 class="mb-3">Pending result release</h5>
          <p class="text-secondary small">Results awaiting submit / review / release with electronic signature.</p>
          <a href="{{ route('admin.quality.results.index') }}" class="btn btn-primary">Open worklist</a>
        </div>
      </div>
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <h5 class="mb-3">Quality Control</h5>
          <p class="text-secondary small">Levey-Jennings charts with Westgard 1-3s / 2-2s / R-4s evaluation.</p>
          <a href="{{ route('admin.quality.qc.index') }}" class="btn btn-outline-primary">View QC runs</a>
        </div>
      </div>
    </div>
  </div>
@endsection
