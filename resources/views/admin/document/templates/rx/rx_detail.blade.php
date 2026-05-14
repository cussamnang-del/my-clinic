<div class="table-responsive">
  <table id="rx_detail_list" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>{{ trans('cruds.rx.fields.id') }}</th>
        <th>{{ trans('cruds.rx.fields.rx_date') }}</th>
        <th>{{ trans('cruds.customer.title_singular') }}</th>
        <th>{{ trans('cruds.document.title_singular') }}</th>
        <th>{{ trans('cruds.rx.fields.doctor_description') }}</th>
        <th>{{ trans('global.action') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($rx_details as $row)
        <tr id="tr_object_id_{{ $row->id }}">
          <td>
            {{ $row->id }}
          </td>
          <td>
            {{ date('d-m-Y',strtotime($row->rx_date)) }}
          </td>
          <td>
            {{ $row->customer->name }}
          </td>
          <td>
            {{ $row->document_id }}
          </td>
          <td>
            {{ $row->rx_note }}
          </td>
          <td>
            <div class="d-flex align-items-center gap-3 fs-6">
              @can($prefix.'show')
                <a href="javascript:void(0)" id="showRxDetail" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer_id }}" data-document_id="{{ $row->document_id }}" href="{{ route('admin.'.$crudRoutePath.'.show',$row->id) }}" class="showRxDetail text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Rx Detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
              @endcan
              @can($prefix.'edit')
                <a href="javascript:void(0)" id="editRxDetail" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer_id }}" data-document_id="{{ $row->document_id }}" href="{{ route('admin.'.$crudRoutePath.'.show',$row->id) }}" class="showRxDetail text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Rx Detail" aria-label="Views"><i class="bi bi-pencil-fill"></i></a>
              @endcan
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
