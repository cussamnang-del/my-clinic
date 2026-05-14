@foreach ($hospital_treatments as $key => $row)
  <tr id="tr_object_ht_id_{{ $row->id }}">
    <td>{{ $row->ht_time }}</td>
    <td>{{ $row->product->p_name }}
      @if ($row->htdetails->count()>0)
        (
          @foreach ($row->htdetails as $key => $detail)
            {{$detail->product->p_name}}({{$detail->qty}}),
          @endforeach
        )
      @endif
    </td>
    <td>{{ $row->qty }}</td>
    <td>{{ $row->duration }}</td>
    <td>{{ $row->how_to_use }}</td>
    <td>
      <div class="d-flex align-items-center gap-3 fs-6">
        @can($prefix.'show')
          <a id="objectShow" data-bs-toggle="collapse" data-bs-target="#detail{{ $row->id }}" class="accordion-toggle objectShow {{ $row->htdetails->count()>0? 'text-primary':'text-secondary' }}" data-id="{{ $row->id }}" href="javascript:void(0)" style="cursor: {{ $row->htdetails->count()>0?'pointer;':'default;' }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
        @endcan
        @can($prefix.'edit')
          <a id="editTreatment" data-id="{{ $row->id }}" data-hospitalid="{{ $row->hospital_id }}" data-productid="{{ $row->product_id }}" href="{{ route('admin.'.$crudRoutePath.'.edit',$row->id) }}" class="editTreatment text-warning" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
        @endcan
        @can($prefix.'delete')
          <a id="deleteTreatment" data-id="{{ $row->id }}" href="{{ route('admin.'.$crudRoutePath.'.deleteObjectHT') }}" class="deleteTreatment text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
        @endcan
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="hiddenRow">
      @include('admin.document.templates.h.more_detail')
    </td>
  </tr>
@endforeach

