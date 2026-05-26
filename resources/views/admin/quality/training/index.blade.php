@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Training & Competency')
  <div class="row">
    <div class="col-12 col-xl-7">
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white">
          <h5 class="mb-0 text-primary"><i class="bx bx-medal me-1"></i> Training events</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm table-hover align-middle">
              <thead>
                <tr><th>Date</th><th>User</th><th>Competency</th><th>Type</th><th>Trainer</th></tr>
              </thead>
              <tbody>
                @forelse ($training as $rec)
                  <tr>
                    <td>{{ optional($rec->training_at)->format('Y-m-d') ?? '—' }}</td>
                    <td>{{ $rec->user?->name ?? '—' }}</td>
                    <td>{{ $rec->competency?->name ?? '—' }}</td>
                    <td>{{ $rec->training_type ?? '—' }}</td>
                    <td>{{ $rec->trainer?->name ?? '—' }}</td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="text-center text-secondary py-4">No training events recorded.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
          {{ $training->links() }}
        </div>
      </div>
    </div>
    <div class="col-12 col-xl-5">
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white">
          <h5 class="mb-0 text-primary"><i class="bx bx-check-shield me-1"></i> Latest competency assessments</h5>
          <p class="mb-0 small text-secondary">Rows highlighted yellow are due for reassessment on or before {{ $dueCutoff }}.</p>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm align-middle">
              <thead>
                <tr><th>Date</th><th>User</th><th>Competency</th><th>Result</th><th>Due</th></tr>
              </thead>
              <tbody>
                @forelse ($assessments as $a)
                  @php
                    $due = $a->reassessment_due_at && $a->reassessment_due_at->lte(now()->addDays(30));
                    $overdue = $a->isReassessmentDue();
                  @endphp
                  <tr class="{{ $overdue ? 'table-danger' : ($due ? 'table-warning' : '') }}">
                    <td>{{ optional($a->assessed_at)->format('Y-m-d') ?? '—' }}</td>
                    <td>{{ $a->user?->name ?? '—' }}</td>
                    <td>{{ $a->competency?->name ?? '—' }}</td>
                    <td>@include('admin.quality._partials.badge', ['status' => $a->result])</td>
                    <td>{{ optional($a->reassessment_due_at)->format('Y-m-d') ?? '—' }}</td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="text-center text-secondary py-4">No assessments recorded.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
