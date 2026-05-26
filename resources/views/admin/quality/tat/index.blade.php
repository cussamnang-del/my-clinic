@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Turn-Around Time')

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 text-primary"><i class="bx bx-time me-1"></i> Turn-Around Time</h5>
    <div class="btn-group" role="group">
      <a class="btn btn-sm {{ $window === '1d' ? 'btn-primary' : 'btn-outline-primary' }}" href="{{ route('admin.quality.tat.index', ['window' => '1d']) }}">Today</a>
      <a class="btn btn-sm {{ $window === '7d' ? 'btn-primary' : 'btn-outline-primary' }}" href="{{ route('admin.quality.tat.index', ['window' => '7d']) }}">7 days</a>
      <a class="btn btn-sm {{ $window === '30d' ? 'btn-primary' : 'btn-outline-primary' }}" href="{{ route('admin.quality.tat.index', ['window' => '30d']) }}">30 days</a>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-12 col-md-3 mb-3">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <p class="text-secondary mb-1 small">On-time %</p>
          <h2 class="mb-0 fw-bold {{ $summary['on_time_pct'] >= 90 ? 'text-success' : ($summary['on_time_pct'] >= 75 ? 'text-warning' : 'text-danger') }}">
            {{ number_format($summary['on_time_pct'], 1) }}%
          </h2>
          <small class="text-secondary">Target {{ $summary['target_minutes'] }} min</small>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3 mb-3">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <p class="text-secondary mb-1 small">Median</p>
          <h2 class="mb-0 fw-bold">{{ $summary['median_minutes'] !== null ? $summary['median_minutes'].' min' : '—' }}</h2>
          <small class="text-secondary">Avg {{ $summary['avg_minutes'] !== null ? $summary['avg_minutes'].' min' : '—' }}</small>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3 mb-3">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <p class="text-secondary mb-1 small">P90</p>
          <h2 class="mb-0 fw-bold">{{ $summary['p90_minutes'] !== null ? $summary['p90_minutes'].' min' : '—' }}</h2>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3 mb-3">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <p class="text-secondary mb-1 small">Breaches</p>
          <h2 class="mb-0 fw-bold {{ $summary['breached'] === 0 ? 'text-success' : 'text-danger' }}">{{ $summary['breached'] }}</h2>
          <small class="text-secondary">{{ $summary['released'] }} released / {{ $summary['pending'] }} pending</small>
        </div>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white"><h5 class="mb-0">Per-day released TAT</h5></div>
    <div class="card-body">
      @php
        $maxAvg = collect($summary['per_day'])->pluck('avg_minutes')->filter()->max() ?: 1;
      @endphp
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead>
            <tr><th>Day</th><th>Released</th><th>Mean TAT (min)</th><th style="min-width: 240px;">Mean vs window peak</th></tr>
          </thead>
          <tbody>
            @foreach ($summary['per_day'] as $row)
              <tr>
                <td>{{ $row['day'] }}</td>
                <td>{{ $row['released'] }}</td>
                <td>{{ $row['avg_minutes'] !== null ? $row['avg_minutes'] : '—' }}</td>
                <td>
                  @if ($row['avg_minutes'] !== null)
                    @php $pct = (int) round(($row['avg_minutes'] / $maxAvg) * 100); @endphp
                    <div class="progress" style="height: 16px;">
                      <div class="progress-bar {{ $row['avg_minutes'] > $summary['target_minutes'] ? 'bg-danger' : 'bg-success' }}" style="width: {{ $pct }}%;">
                        {{ $row['avg_minutes'] }}
                      </div>
                    </div>
                  @else
                    <span class="text-secondary small">—</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
      <h5 class="mb-0">Recent target breaches</h5>
      <p class="mb-0 small text-secondary">Requests whose TAT exceeded {{ $summary['target_minutes'] }} minutes, or pending past target.</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead>
            <tr><th>Result #</th><th>Submitted</th><th>Released</th><th>Minutes</th><th>Status</th></tr>
          </thead>
          <tbody>
            @forelse ($breaches as $b)
              @php
                $minutes = $b->released_at
                  ? $b->submitted_at->diffInMinutes($b->released_at, true)
                  : $b->submitted_at->diffInMinutes(now(), true);
              @endphp
              <tr>
                <td>#{{ $b->id }}</td>
                <td>{{ $b->submitted_at?->format('Y-m-d H:i') ?? '—' }}</td>
                <td>{{ $b->released_at?->format('Y-m-d H:i') ?? 'pending' }}</td>
                <td><strong class="text-danger">{{ (int) $minutes }}</strong></td>
                <td>@include('admin.quality._partials.badge', ['status' => $b->result_status ?? 'draft'])</td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center text-secondary py-4">No breaches in window. </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
