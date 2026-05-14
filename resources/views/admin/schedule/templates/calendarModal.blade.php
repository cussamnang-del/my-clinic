<div class="modal fade" id="crudObjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form id="frmCrudObject" action="{{ route('admin.'.$crudRoutePath.'.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="object_id" id="object_id">
          <input type="hidden" name="crudRoutePath" id="crudRoutePath" value="{{ $crudRoutePath }}">
          <div class="row mb-2">
            <div class="col-lg-9 col-md-9 col-sm-9">
              <div class="form-group">
                <label for="ap_title" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.ap_title') }}: <span class="text-danger">*</span></label>
                <input id="ap_title" name="ap_title" class="form-control" type="text" placeholder="{{ trans('cruds.schedule.fields.ap_title') }}">
                <span class="text-danger error-text ap_title_error"></span>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
              <div class="form-group">
                <label for="ap_color" class="form-control-label mb-1" aria-label="Text input with checkbox">{{ trans('cruds.schedule.fields.color') }}: <span class="text-danger">*</span></label>
                <input id="ap_color" name="ap_color" type="text" class="form-control ap_color" aria-label="Text input with checkbox">
                <span class="text-danger error-text ap_color_error"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="form-group">
                <label for="ap_start_date" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.ap_start_date') }}: <span class="text-danger">*</span></label>
                <input id="ap_start_date" name="ap_start_date" class="form-control datetime" type="text" placeholder="{{ trans('cruds.schedule.fields.ap_start_date') }}">
                <span class="text-danger error-text ap_start_date_error"></span>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="form-group">
                <label for="ap_end_date" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.ap_end_date') }}: <span class="text-danger">*</span></label>
                <input id="ap_end_date" name="ap_end_date" class="form-control datetime" type="text" placeholder="{{ trans('cruds.schedule.fields.ap_end_date') }}">
                <span class="text-danger error-text ap_end_date_error"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="form-group">
                <label for="customer_id" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.customer_id') }}: <span class="text-danger">*</span></label>
                <select id="customer_id" name="customer_id" class="form-control single-select"  style="width: 100%" data-placeholder="{{ trans('global.select') }} {{ trans('cruds.schedule.fields.customer_id') }}">
                  <option value="">{{ trans('global.select') }} {{ trans('cruds.schedule.fields.customer_id') }}</option>
                  @foreach ($customers as $row)
                    <option value="{{ $row->id}}">{{ $row->name }}</option>
                  @endforeach
                </select>
                <span class="text-danger error-text customer_id_error"></span>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="form-group">
                <label for="user_id" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.user_id') }}: <span class="text-danger">*</span></label>
                <select id="user_id" name="user_id" class="form-control single-select"  style="width: 100%" data-placeholder="{{ trans('global.select') }} {{ trans('cruds.schedule.fields.user_id') }}">
                  <option value="">{{ trans('global.select') }} {{ trans('cruds.schedule.fields.user_id') }}</option>
                  @foreach ($users as $row)
                    <option value="{{ $row->id}}">{{ $row->name }}</option>
                  @endforeach
                </select>
                <span class="text-danger error-text user_id_error"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group">
                <label for="desr" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.desr') }}: </label>
                <input id="desr" name="desr" class="form-control" type="text" placeholder="{{ trans('cruds.schedule.fields.desr') }}">
                <span class="text-danger error-text desr_error"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-2 col-md-2 col-sm-2">
              <div class="form-group mt-4">
                <div class="form-check form-switch">
                  <input id="status" name="status" class="form-check-input" type="checkbox" checked>
                  <label class="form-check-label mt-1" for="flexSwitchCheckChecked">&nbsp;&nbsp;Status</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          @include('admin.templates.button')
        </div>
      </form>
    </div>
  </div>
</div>
