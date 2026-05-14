<div class="card radius-10">
  <div class="card-body">
    <h5 class="card-title">
    </h5>
    @foreach($items as $type)
      <div class="row">
        <div class="col-xl-3">
          <strong>{{$type[0]->itemType->name}}</strong>
        </div>
      </div>
      @foreach($type as $access)
        <div class="row">
          <div class="col-xl-3">
            <div class="form-group mb-4">
              <div class="form-check">
                <label>
                  <input id="bio_item_name" name="bio_item_name[]" data-id="{{ $access->id }}" class="form-check-input bio_item_name" type="checkbox" value="{{ $access['id'] }}">
                  <span class="lbl pr-2">&nbsp;{{ $access['item_name']}} &nbsp;&nbsp;</span>
                </label>
              </div>
            </div>
          </div>
          <div class="col-xl-5">
            <div class="form-group mb-2">
              <label for="bio_result" class="form-control-label mb-2">{{ trans('cruds.bio.fields.result') }}:</label>
              <input disabled id="bio_result-{{ $access->id }}" name="bio_result[]" data-id="{{ $access->id }}" class="bio_result form-control" type="text" placeholder="{{ trans('cruds.bio.fields.result') }}">
              <span class="text-danger error-text bio_result_error"></span>
            </div>
          </div>
        </div>
      @endforeach
    @endforeach
  <div class="row mt-2">
    <div class="col-xl-5">
      <div class="form-group mb-2">
        <label for="bio_date" class="form-control-label mb-2">{{ trans('cruds.bio.fields.date') }}:</label>
        <input id="bio_date" name="bio_date" class="form-control" type="text" placeholder="{{ trans('cruds.bio.fields.date') }}">
        <span class="text-danger error-text bio_date_error"></span>
      </div>
    </div>
    <div class="col-xl-5">
      <div class="form-group mb-2">
        <label for="bio_note" class="form-control-label mb-2">{{ trans('cruds.bio.fields.note') }}:</label>
        <input id="bio_note" name="bio_note" class="form-control" type="text" placeholder="{{ trans('cruds.bio.fields.note') }}">
        <span class="text-danger error-text bio_note_error"></span>
      </div>
    </div>
    <div class="col-xl-2 mt-4">
      <div class="form-check form-switch mt-2">
        <input id="status" name="status" class="form-check-input" type="checkbox">
        <label class="form-check-label mt-1" for="invalidCheck">
          <strong>&nbsp;{{ trans('global.status') }}</strong>
        </label>
      </div>
    </div>
  </div>
  </div>
</div>
