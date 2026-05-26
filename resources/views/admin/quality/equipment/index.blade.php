@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Equipment & Calibration')
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
      <h5 class="mb-0 text-primary"><i class="bx bx-cog me-1"></i> Equipment Register</h5>
      <p class="mb-0 small text-secondary">Rows highlighted yellow are due for calibration on or before {{ $dueCutoff }}.</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
          <thead>
            <tr>
              <th>Code</th><th>Name</th><th>Manufacturer</th><th>Serial</th><th>Location</th>
              <th>Last calibrated</th><th>Next due</th><th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($equipment as $eq)
              @php
                $due = $eq->next_calibration_due_at && $eq->next_calibration_due_at->lte(now()->addDays(30));
                $overdue = $eq->isCalibrationOverdue();
              @endphp
              <tr class="{{ $overdue ? 'table-danger' : ($due ? 'table-warning' : '') }}">
                <td><a href="{{ route('admin.quality.equipment.show', $eq) }}">{{ $eq->code }}</a></td>
                <td>{{ $eq->name }}</td>
                <td>{{ $eq->manufacturer ?? '—' }}</td>
                <td>{{ $eq->serial_no ?? '—' }}</td>
                <td>{{ $eq->location ?? '—' }}</td>
                <td>{{ optional($eq->last_calibrated_at)->format('Y-m-d') ?? '—' }}</td>
                <td>{{ optional($eq->next_calibration_due_at)->format('Y-m-d') ?? '—' }}</td>
                <td>@include('admin.quality._partials.badge', ['status' => $eq->status])</td>
              </tr>
            @empty
              <tr><td colspan="8" class="text-center text-secondary py-4">No equipment registered yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $equipment->links() }}
    </div>
  </div>
@endsection
