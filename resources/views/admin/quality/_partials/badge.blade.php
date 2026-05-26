@php
  /**
   * Quality status badge — colour-coded by status string so the
   * listing pages can share one pill style.
   *
   * Variables:
   *   $status    string
   *   $variants  optional array<string, string> mapping status → CSS class
   */
  $defaultMap = [
    'draft' => 'bg-secondary',
    'in_review' => 'bg-info text-dark',
    'submitted_for_review' => 'bg-info text-dark',
    'reviewed' => 'bg-primary',
    'effective' => 'bg-success',
    'released' => 'bg-success',
    'amended' => 'bg-warning text-dark',
    'retired' => 'bg-secondary',
    'active' => 'bg-success',
    'inactive' => 'bg-secondary',
    'out_of_service' => 'bg-danger',
    'open' => 'bg-warning text-dark',
    'investigating' => 'bg-info text-dark',
    'in_progress' => 'bg-info text-dark',
    'effectiveness_check' => 'bg-primary',
    'closed' => 'bg-success',
    'planned' => 'bg-secondary',
    'completed' => 'bg-success',
    'open_overdue' => 'bg-danger',
    'mitigated' => 'bg-success',
    'accepted' => 'bg-success',
    'rejected' => 'bg-danger',
    'pending_review' => 'bg-warning text-dark',
    'expired' => 'bg-danger',
  ];
  $map = isset($variants) ? array_merge($defaultMap, $variants) : $defaultMap;
  $css = $map[$status] ?? 'bg-secondary';
@endphp
<span class="badge {{ $css }}">{{ str_replace('_', ' ', $status) }}</span>
