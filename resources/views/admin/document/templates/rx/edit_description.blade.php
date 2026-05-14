<div class="table-responsive">
  <table id="doctor_description_list" class="table table-striped table-bordered doctor_description_list">
    <thead>
      <tr>
        <th>{{ trans('cruds.rx.fields.rx_check') }}</th>
        <th>{{ trans('cruds.rx.fields.doctor_description') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($doctorDescriptions as $key => $row)
        <tr id="tr_object_id_{{ $row->id }}">
          <td>
            <div class="form-check">
              <input id="doctor_order" name="doctor_order[]" data-id="{{ $row->id }}" class="form-check-input bio_item_name" type="checkbox" value="{{ $row->id }}"
              @foreach ($nurses as $item)
                {{ $row->description_name===$item->description ? 'checked' : '' }}
              @endforeach
              >
            </div>
          </td>
          <td>
            <div class="form-group mb-2">
              <input id="doctor_description-{{ $row->id }}" name="doctor_description[]" data-id="{{ $row->id }}" class="doctor_description form-control" type="text" placeholder="{{ trans('cruds.rx.fields.doctor_description') }}" value="{{ $row->description_name }}">
              <span class="text-danger error-text doctor_description_error"></span>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
