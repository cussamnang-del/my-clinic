@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Equipment — '.$equipment->code)

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <h4 class="mb-3">{{ $equipment->code }} · {{ $equipment->name }}</h4>
      <dl class="row mb-0">
        <dt class="col-sm-3">Manufacturer / model</dt>
        <dd class="col-sm-9">{{ $equipment->manufacturer ?? '—' }} {{ $equipment->model ? '· '.$equipment->model : '' }}</dd>
        <dt class="col-sm-3">Serial</dt><dd class="col-sm-9">{{ $equipment->serial_no ?? '—' }}</dd>
        <dt class="col-sm-3">Location</dt><dd class="col-sm-9">{{ $equipment->location ?? '—' }}</dd>
        <dt class="col-sm-3">Commissioned</dt><dd class="col-sm-9">{{ optional($equipment->commissioned_at)->format('Y-m-d') ?? '—' }}</dd>
        <dt class="col-sm-3">Last calibrated</dt><dd class="col-sm-9">{{ optional($equipment->last_calibrated_at)->format('Y-m-d') ?? '—' }}</dd>
        <dt class="col-sm-3">Next due</dt>
        <dd class="col-sm-9">
          {{ optional($equipment->next_calibration_due_at)->format('Y-m-d') ?? '—' }}
          @if ($equipment->isCalibrationOverdue())
            <span class="badge bg-danger ms-2">Overdue</span>
          @endif
        </dd>
        <dt class="col-sm-3">Status</dt><dd class="col-sm-9">@include('admin.quality._partials.badge', ['status' => $equipment->status])</dd>
      </dl>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><h5 class="mb-0">Calibration history</h5></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead>
            <tr><th>Date</th><th>Result</th><th>Next due</th><th>Provider</th><th>Notes</th></tr>
          </thead>
          <tbody>
            @forelse ($equipment->calibrations->sortByDesc('calibration_date') as $cal)
              <tr>
                <td>{{ optional($cal->calibration_date)->format('Y-m-d') ?? '—' }}</td>
                <td>@include('admin.quality._partials.badge', ['status' => $cal->result ?? 'unknown'])</td>
                <td>{{ optional($cal->due_date)->format('Y-m-d') ?? '—' }}</td>
                <td>{{ $cal->performed_by_external ?? '—' }}</td>
                <td class="text-truncate" style="max-width: 320px;">{{ $cal->notes ?? '' }}</td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center text-secondary py-4">No calibration records yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
