@if ($row->htdetails->count()>0)
  <div class="accordian-body collapse" id="detail{{ $row['id'] }}">
    <div class="table-responsive">
      <table id="more_detail" class="table table-striped table-bordered">
        <thead class="bg-secondary text-white">
          <tr class="text-center">
            <th>{{ trans('cruds.ht.fields.product_id') }}</th>
            <th>{{ trans('cruds.ht.fields.qty') }}</th>
            <th>{{ trans('cruds.ht.fields.how_to_use') }}</th>
            <th>{{ trans('global.action') }}</th>
          </tr>
        </thead>
        <tbody id="objectHTDetail">
          @foreach ($row->htdetails as $detail)
            <tr id="tr_object_htd_id_{{ $detail['id'] }}">
              <td>{{ $detail->product['p_name'] }}</td>
              <td>{{ $detail['qty'] }}</td>
              <td>{{ $detail['how_to_use'] }}</td>
              <td>
                @can($prefix.'delete')
                  <a id="deleteTreatmentDetail" data-id="{{ $detail['id'] }}" href="{{ route('admin.'.$documentRoute.'.deleteObjectHTD') }}" class="deleteTreatment text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                @endcan
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif
