<div class="table-responsive">
  <table id="doctor_description_list" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>{{ trans('cruds.rx_detail.fields.id') }}</th>
        <th>{{ trans('cruds.rx.fields.doctor_description') }}</th>
        <th>{{ trans('cruds.rx_detail.fields.result') }}</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $descriptions = explode(',',$nurse->rx_note);
      ?>
      @foreach ($descriptions as $key => $label)
        <tr id="tr_object_id_{{ $nurse->id }}">
          <td>
            <div class="form-check">
              <input checked id="rx_id" name="rx_id" data-id="{{ $nurse->id }}" class="form-check-input bio_item_name" type="checkbox" value="{{ $nurse->id }}">
            </div>
          </td>
          <td>
            <div class="form-group mb-2">
              <input readonly id="nuse_description-{{ $nurse->id }}" name="nuse_description[]" data-id="{{ $nurse->id }}" class="nuse_description form-control" type="text" placeholder="{{ trans('cruds.rx.fields.doctor_description') }}" value="{{ $label }}">
              <span class="text-danger error-text nuse_description_error"></span>
            </div>
          </td>
          <td>
            <div class="form-group mb-2">
              <input id="nurse_result-{{ $nurse->id }}" name="nurse_result[]" data-id="{{ $nurse->id }}" class="nurse_result form-control" type="text" placeholder="{{ trans('cruds.rx.fields.doctor_result') }}" value="">
              <span class="text-danger error-text nurse_result_error"></span>
            </div>
          </td>
        </tr>
      @endforeach
      <tr>
        <th>{{ trans('cruds.rx_detail.fields.docfile') }}</th>
        <td colspan="2">
          <div class="form-group">
            <input id="docfile" name="docfile[]" class="form-control" type="file" multiple="">
            <span class="text-danger error-text docfile_error"></span>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
