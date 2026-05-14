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
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="form-group">
                <label for="item_group_id" class="form-control-label mb-1">{{ trans('cruds.item.fields.item_group_id') }}: <span class="text-danger">*</span></label>
                <select id="item_group_id" name="item_group_id" class="form-control single-select"  style="width: 100%" data-placeholder="{{ trans('global.select') }} {{ trans('cruds.item.fields.item_group_id') }}">
                  <option value="">{{ trans('global.select') }} {{ trans('cruds.item.fields.item_group_id') }}</option>
                  @foreach ($itemGroups as $row)
                    <option value="{{ $row->id}}">{{ $row->name }}</option>
                  @endforeach
                </select>
                <span class="text-danger error-text item_group_id_error"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="form-group">
                <label for="item_type_id" class="form-control-label mb-1">{{ trans('cruds.item.fields.item_type_id') }}: <span class="text-danger">*</span></label>
                <select id="item_type_id" name="item_type_id" class="form-control single-select"  style="width: 100%" data-placeholder="{{ trans('global.select') }} {{ trans('cruds.item.fields.item_type_id') }}">
                  <option value="">{{ trans('global.select') }} {{ trans('cruds.item.fields.item_type_id') }}</option>
                  @foreach ($itemTypes as $row)
                    <option value="{{ $row->id}}">{{ $row->name }}</option>
                  @endforeach
                </select>
                <span class="text-danger error-text item_type_id_error"></span>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="form-group">
                <label for="item_name" class="form-control-label mb-1">{{ trans('cruds.item.fields.item_name') }}: <span class="text-danger">*</span></label>
                <input id="item_name" name="item_name" class="form-control" type="text" placeholder="{{ trans('cruds.item.fields.item_name') }}">
                <span class="text-danger error-text item_name_error"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-4 col-md-4 col-sm-4">
              <div class="form-group">
                <label for="normal_value" class="form-control-label mb-1">{{ trans('cruds.item.fields.normal_value') }}: <span class="text-danger">*</span></label>
                <input id="normal_value" name="normal_value" class="form-control" type="text" placeholder="{{ trans('cruds.item.fields.normal_value') }}">
                <span class="text-danger error-text normal_value_error"></span>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <div class="form-group">
                <label for="min_value" class="form-control-label mb-1">{{ trans('cruds.item.fields.min_value') }}: <span class="text-danger">*</span></label>
                <input id="min_value" name="min_value" class="form-control" type="text" placeholder="{{ trans('cruds.item.fields.min_value') }}">
                <span class="text-danger error-text min_value_error"></span>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <div class="form-group">
                <label for="max_value" class="form-control-label mb-1">{{ trans('cruds.item.fields.max_value') }}: <span class="text-danger">*</span></label>
                <input id="max_value" name="max_value" class="form-control" type="text" placeholder="{{ trans('cruds.item.fields.max_value') }}">
                <span class="text-danger error-text max_value_error"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group">
                <label for="uvn" class="form-control-label mb-1">{{ trans('cruds.item.fields.uvn') }}: <span class="text-danger">*</span></label>
                <textarea id="uvn" name="uvn" placeholder="{{ trans('cruds.item.fields.uvn') }}"></textarea>
                <span class="text-danger error-text uvn_error"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-5 col-md-5 col-sm-5">
              <div class="form-group">
                <label for="numset" class="form-control-label mb-1">{{ trans('cruds.item.fields.numset') }}: <span class="text-danger">*</span></label>
                <input id="numset" name="numset" class="form-control" type="text" placeholder="{{ trans('cruds.item.fields.numset') }}">
                <span class="text-danger error-text numset_error"></span>
              </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
              <div class="form-group">
                <label for="item_price" class="form-control-label mb-1">{{ trans('cruds.item.fields.item_price') }}: <span class="text-danger">*</span></label>
                <input id="item_price" name="item_price" class="form-control" type="text" placeholder="{{ trans('cruds.item.fields.item_price') }}">
                <span class="text-danger error-text item_price_error"></span>
              </div>
            </div>
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
