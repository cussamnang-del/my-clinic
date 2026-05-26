@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Result #'.$biodetail->id)

  @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $msg)
          <li>{{ $msg }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h4 class="mb-1">Result #{{ $biodetail->id }}</h4>
          <p class="mb-1 text-secondary">
            Customer {{ $biodetail->customer?->name ?? '—' }} ·
            Test {{ $biodetail->itemType?->name ?? '—' }}
          </p>
        </div>
        @include('admin.quality._partials.badge', ['status' => $biodetail->result_status ?? 'draft'])
      </div>

      <hr>
      <dl class="row mb-0">
        <dt class="col-sm-3">Value</dt><dd class="col-sm-9"><strong>{{ $biodetail->result ?? '—' }}</strong></dd>
        <dt class="col-sm-3">Flag</dt><dd class="col-sm-9">{{ $biodetail->result_flag ?? '—' }}</dd>
        <dt class="col-sm-3">Note</dt><dd class="col-sm-9">{{ $biodetail->note ?? '—' }}</dd>
        <dt class="col-sm-3">Submitted</dt><dd class="col-sm-9">{{ optional($biodetail->submitted_at)->format('Y-m-d H:i') ?? '—' }}</dd>
        <dt class="col-sm-3">Reviewed</dt><dd class="col-sm-9">{{ optional($biodetail->reviewed_at)->format('Y-m-d H:i') ?? '—' }}</dd>
        <dt class="col-sm-3">Released</dt><dd class="col-sm-9">{{ optional($biodetail->released_at)->format('Y-m-d H:i') ?? '—' }}</dd>
        @if ($biodetail->amendment_reason)
          <dt class="col-sm-3">Amendment reason</dt><dd class="col-sm-9">{{ $biodetail->amendment_reason }}</dd>
        @endif
      </dl>
    </div>
  </div>

  @php
    $state = $biodetail->result_status ?? 'draft';
    $nextAction = match ($state) {
      'draft' => 'submit',
      'submitted_for_review' => 'review',
      'reviewed' => 'release',
      default => null,
    };
    $nextLabel = match ($nextAction) {
      'submit' => 'Submit for review',
      'review' => 'Mark as reviewed',
      'release' => 'Release result',
      default => null,
    };
  @endphp

  @if ($nextAction)
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-header bg-white">
        <h5 class="mb-0">Next transition: {{ $nextLabel }}</h5>
        <p class="mb-0 small text-secondary">Enter your account password as the electronic signature. ISO 15189 §7.3.7.4 / 21 CFR Part 11.</p>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.results.'.$nextAction, $biodetail) }}">
          @csrf
          <div class="row g-2 align-items-end">
            <div class="col-12 col-md-6">
              <label class="form-label small text-secondary">Password (signature)</label>
              <input type="password" name="signature_password" class="form-control" required autocomplete="current-password">
            </div>
            <div class="col-12 col-md-3">
              <button type="submit" class="btn btn-primary w-100">{{ $nextLabel }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  @endif

  @if (in_array($state, ['released', 'amended'], true))
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="mb-0">Amend result</h5>
        <p class="mb-0 small text-secondary">Creates a new amendment row linked back to this one; the original record stays immutable. Requires password (signature) and a non-trivial reason.</p>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.results.amend', $biodetail) }}">
          @csrf
          <div class="row g-2">
            <div class="col-12 col-md-4">
              <label class="form-label small text-secondary">Corrected value</label>
              <input type="text" name="result" class="form-control" required maxlength="255">
            </div>
            <div class="col-12 col-md-8">
              <label class="form-label small text-secondary">Reason (≥5 chars)</label>
              <input type="text" name="reason" class="form-control" required minlength="5" maxlength="512">
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label small text-secondary">Password (signature)</label>
              <input type="password" name="signature_password" class="form-control" required autocomplete="current-password">
            </div>
            <div class="col-12 col-md-3 d-flex align-items-end">
              <button type="submit" class="btn btn-warning w-100">Amend</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  @endif
@endsection
