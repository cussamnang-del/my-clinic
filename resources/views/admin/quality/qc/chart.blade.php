@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'QC — Levey-Jennings')

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start flex-wrap">
        <div>
          <h4 class="mb-1">{{ $analyte }} · level {{ $level }} @if ($lot) · lot {{ $lot }} @endif</h4>
          <p class="text-secondary mb-0">
            Mean {{ $chart['mean'] !== null ? $chart['mean'] : '—' }} ·
            SD {{ $chart['sd'] !== null ? $chart['sd'] : '—' }} ·
            Status:
            @if ($chart['in_control'])
              <span class="badge bg-success">in control</span>
            @else
              <span class="badge bg-danger">out of control</span>
            @endif
          </p>
        </div>
        <a href="{{ route('admin.quality.qc.index', ['analyte' => $analyte, 'level' => $level, 'lot_number' => $lot]) }}"
           class="btn btn-sm btn-outline-secondary">← Back to QC results</a>
      </div>
    </div>
  </div>

  @php
    $points = $chart['points'];
    $count = count($points);
    $mean = $chart['mean'];
    $sd = $chart['sd'];

    // SVG geometry
    $width = 900;
    $height = 340;
    $padX = 40;
    $padY = 20;
    $plotW = $width - 2 * $padX;
    $plotH = $height - 2 * $padY;

    // Y-axis spans mean ± 4 SD (so 3-SD points are still visible) when stats exist.
    if ($mean !== null && $sd !== null && $sd > 0) {
      $yMin = $mean - 4 * $sd;
      $yMax = $mean + 4 * $sd;
    } else {
      $values = array_map(fn ($p) => $p['value'], $points);
      $yMin = $values ? min($values) : 0;
      $yMax = $values ? max($values) : 1;
      if ($yMin === $yMax) { $yMax = $yMin + 1; }
    }
    $yRange = $yMax - $yMin;

    $toX = function (int $i) use ($padX, $plotW, $count) {
      if ($count <= 1) { return $padX + $plotW / 2; }
      return $padX + ($i / ($count - 1)) * $plotW;
    };
    $toY = function (float $v) use ($padY, $plotH, $yMin, $yRange) {
      return $padY + (($yMax = $yMin + $yRange) - $v) / $yRange * $plotH;
    };
  @endphp

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      @if ($count === 0)
        <p class="text-center text-secondary py-5">No QC measurements for this analyte / level / lot.</p>
      @else
        <svg viewBox="0 0 {{ $width }} {{ $height }}" preserveAspectRatio="xMidYMid meet" style="width:100%; height:auto; background:#fff;">
          {{-- Reference bands --}}
          @if ($mean !== null && $sd !== null && $sd > 0)
            @php
              $bands = [
                ['offset' => 3, 'color' => '#d9534f', 'label' => '+3 SD'],
                ['offset' => 2, 'color' => '#f0ad4e', 'label' => '+2 SD'],
                ['offset' => 1, 'color' => '#5cb85c', 'label' => '+1 SD'],
                ['offset' => 0, 'color' => '#0275d8', 'label' => 'mean'],
                ['offset' => -1, 'color' => '#5cb85c', 'label' => '−1 SD'],
                ['offset' => -2, 'color' => '#f0ad4e', 'label' => '−2 SD'],
                ['offset' => -3, 'color' => '#d9534f', 'label' => '−3 SD'],
              ];
            @endphp
            @foreach ($bands as $b)
              @php $y = $toY($mean + $b['offset'] * $sd); @endphp
              <line x1="{{ $padX }}" y1="{{ $y }}" x2="{{ $width - $padX }}" y2="{{ $y }}"
                    stroke="{{ $b['color'] }}" stroke-width="{{ $b['offset'] === 0 ? 1.5 : 0.8 }}"
                    stroke-dasharray="{{ $b['offset'] === 0 ? 'none' : '4 4' }}"/>
              <text x="{{ $width - $padX + 4 }}" y="{{ $y + 4 }}" font-size="10" fill="{{ $b['color'] }}">{{ $b['label'] }}</text>
            @endforeach
          @endif

          {{-- Connector line --}}
          <polyline fill="none" stroke="#333" stroke-width="1.2" points="
            @foreach ($points as $i => $p)@php $x = $toX($i); $y = $toY($p['value']); @endphp {{ $x }},{{ $y }}@endforeach
          "/>

          {{-- Data points --}}
          @foreach ($points as $i => $p)
            @php
              $x = $toX($i);
              $y = $toY($p['value']);
              $fill = match (true) {
                in_array($p['flag'], ['1-3s', '2-2s', 'R-4s'], true) => '#d9534f',
                $p['flag'] === '1-2s' => '#f0ad4e',
                default => '#28a745',
              };
            @endphp
            <circle cx="{{ $x }}" cy="{{ $y }}" r="4" fill="{{ $fill }}" stroke="#fff" stroke-width="1">
              <title>{{ $p['measured_at'] }} — value {{ $p['value'] }} {{ $p['flag'] ? '· '.$p['flag'] : '' }}</title>
            </circle>
          @endforeach
        </svg>

        <hr>
        <div class="row text-center">
          <div class="col-3"><p class="mb-0 text-secondary small">Total runs</p><h5 class="mb-0">{{ $chart['summary']['total'] }}</h5></div>
          <div class="col-3"><p class="mb-0 text-secondary small">Accepted</p><h5 class="mb-0 text-success">{{ $chart['summary']['accepted'] }}</h5></div>
          <div class="col-3"><p class="mb-0 text-secondary small">Pending review</p><h5 class="mb-0 text-warning">{{ $chart['summary']['pending_review'] }}</h5></div>
          <div class="col-3"><p class="mb-0 text-secondary small">Rejected</p><h5 class="mb-0 text-danger">{{ $chart['summary']['rejected'] }}</h5></div>
        </div>
      @endif
    </div>
  </div>
@endsection
