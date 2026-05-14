<div class="d-flex align-items-center gap-3 fs-6">
  {{-- @can($prefix.'show')
    <a id="objectShow" data-id="{{ $row->id }}" href="{{ route('admin.'.$crudRoutePath.'.show',$row->id) }}" class="objectShow text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
  @endcan --}}
  @can($prefix.'edit')
    <a id="objectEdit" data-id="{{ $row->id }}" href="{{ route('admin.'.$crudRoutePath.'.edit',$row->id) }}" class="objectEdit text-warning" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
  @endcan
  @can($prefix.'delete')
    <a id="objectDelete" data-id="{{ $row->id }}" href="{{ route('admin.'.$crudRoutePath.'.destroy',$row->id) }}" class="objectDelete text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
  @endcan
</div>
