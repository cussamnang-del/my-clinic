@extends('admin.admin_layout')

@section('content')
  @section('breadcrumb', 'Risk — '.$risk->code)
  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <h4 class="mb-3">{{ $risk->code }}</h4>
      <dl class="row mb-0">
        <dt class="col-sm-3">Category</dt><dd class="col-sm-9">{{ $risk->category ?? '—' }}</dd>
        <dt class="col-sm-3">Status</dt><dd class="col-sm-9">@include('admin.quality._partials.badge', ['status' => $risk->status ?? 'open'])</dd>
        <dt class="col-sm-3">Owner</dt><dd class="col-sm-9">{{ $risk->owner?->name ?? '—' }}</dd>
        <dt class="col-sm-3">Next review</dt><dd class="col-sm-9">{{ optional($risk->next_review_at)->format('Y-m-d') ?? '—' }}</dd>
        <dt class="col-sm-3">Inherent</dt>
        <dd class="col-sm-9">L={{ $risk->inherent_likelihood ?? '—' }} × S={{ $risk->inherent_severity ?? '—' }} = <strong>{{ $risk->inherent_score ?? '—' }}</strong></dd>
        <dt class="col-sm-3">Residual</dt>
        <dd class="col-sm-9">L={{ $risk->residual_likelihood ?? '—' }} × S={{ $risk->residual_severity ?? '—' }} = <strong>{{ $risk->residual_score ?? '—' }}</strong></dd>
      </dl>
      <hr>
      <h6>Description</h6><p>{{ $risk->description }}</p>
      @if ($risk->mitigation)
        <h6>Mitigation</h6><p class="mb-0">{{ $risk->mitigation }}</p>
      @endif
    </div>
  </div>
@endsection
