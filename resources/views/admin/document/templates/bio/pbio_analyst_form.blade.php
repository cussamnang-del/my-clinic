<div class="row">
  <div class="col-lg-4">
    <div class="form-group mb-2">
      <div class="row">
        <label for="bio_hate" class="control-label col-lg-2"><b>{{ trans('cruds.bio.fields.date') }}</b></label>
        <div class="col-lg-10">
          <input id="bio_date" name="bio_date" class="bio_date form-control" type="text" placeholder="{{ trans('cruds.bio.fields.date') }}">
          <span class="text-danger error-text bio_date_error"></span>
        </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="pbio_id" id="pbio_id" value="{{ $pbio_id }}">
<div class="table-responsive">
  <table id="pbio_analyst_list" class="table table-striped table-bordered">
    <thead>
      <tr align="center">
        <th>{{ trans('cruds.bio.fields.id') }}</th>
        <th>{{ trans('cruds.bio.fields.item_id') }}</th>
        <th>{{ trans('cruds.bio.fields.result') }}</th>
        <th>{{ trans('cruds.bio.fields.note') }}</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse ($pbio_analyst_forms as $key => $bio)
        <tr id="tr_analyst_form-{{ $bio->item_id }}">
          <td>
            <div class="form-check">
              <input checked id="bio_item_id" name="bio_item_id[]" data-id="{{ $bio->item_id }}" class="form-check-input bio_id" type="checkbox" value="{{ $bio->item_id }}">
            </div>
          </td>
          <td>
            <div class="form-group mb-2">
              <input readonly id="bio_item_name-{{ $bio->item_id }}" name="bio_item_name[]" data-id="{{ $bio->item_id }}" class="bio_item_id form-control" type="text" value="{{ $bio->item->item_name }}">
              <span class="text-danger error-text bio_item_name_error"></span>
            </div>
          </td>
          <td>
            <div class="form-group mb-2">
              <input id="bio_result-{{ $bio->item_id }}" name="bio_result[]" data-id="{{ $bio->item_id }}" class="bio_result form-control" type="text" placeholder="{{ trans('cruds.bio.fields.result') }}">
              <span class="text-danger error-text bio_result_error"></span>
            </div>
          </td>
          <td>
            <div class="form-group mb-2">
              <input id="bio_note-{{ $bio->item_id }}" name="bio_note[]" data-id="{{ $bio->item_id }}" class="bio_note form-control" type="text" placeholder="{{ trans('cruds.bio.fields.note') }}">
              <span class="text-danger error-text bio_note_error"></span>
            </div>
          </td>
          <td>
            <input value="{{$bio->item_group_id}}" id="item_group_id-{{ $bio->item_group_id }}" name="item_group_id[]" data-id="{{ $bio->item_group_id }}" class="item_group_id form-control" type="hidden">
          </td>
          <td>
            <input value="{{$bio->item_type_id}}" id="item_type_id-{{ $bio->item_type_id }}" name="item_type_id[]" data-id="{{ $bio->item_type_id }}" class="item_type_id form-control" type="hidden">
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4">No record Found</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
