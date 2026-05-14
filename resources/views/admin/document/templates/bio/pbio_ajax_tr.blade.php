<tr id="tr_pbio_info_id_{{ $row->id }}" class="pbio_info" data-id="{{ $row->id }}" data-customerid="{{ $row->customer_id }}" data-documentid="{{ $row->document_id }}">
  <td>
    {{ $row->id }}
  </td>
  <td>
    {{ $row->customer->name }}
  </td>
  <td>
    {{ $row->document_id }}
  </td>
  <td>
    @foreach ($row->details as $detail)
      {{ $detail->item->item_name }}
    @endforeach
  </td>
  <td>
    <div class="d-flex align-items-center gap-3 fs-6">
      @can($prefix.'show')
        <a id="deletePBio" data-id="{{ $row->id }}" href="{{route('admin.documents.deletePBio')}}" class="text-danger deletePBio" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete Pio" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
      @endcan
    </div>
  </td>
</tr>
