<tr id="tr_hnote_id{{ $row->id }}">
  <td></td>
  <td>{{ $row['mob'] }}</td>
  <td>{{ $row['dia'] }}</td>
  <td>{{ $row['todo'] }}</td>
  <td>{{ $row['comment'] }}</td>
  <td>
    <div class="d-flex align-items-center gap-3 fs-6">
      @can($prefix.'edit')
        <a id="editMedical" data-id="{{ $row['id'] }}" data-hospitalid="{{ $row['hospital_id'] }}" href="#" class="editMedical text-warning" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
      @endcan
      @can($prefix.'delete')
        <a id="deleteMedical" data-id="{{ $row['id'] }}" href="#" class="deleteMedical text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
      @endcan
    </div>
  </td>
</tr>
