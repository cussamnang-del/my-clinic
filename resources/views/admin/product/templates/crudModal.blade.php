<div class="modal fade" id="crudObjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
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
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="row mb-3">
                <div class="col-lg-3 col-md-3 col-sm-3">
                  <div class="form-group">
                    <label for="p_name" class="form-control-label mb-1">{{ trans('cruds.product.fields.p_name') }}: <span class="text-danger">*</span></label>
                    <input id="p_name" name="p_name" class="form-control" type="text" placeholder="{{ trans('cruds.product.fields.p_name') }}">
                    <span class="text-danger error-text p_name_error"></span>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                  <div class="form-group">
                    <label for="p_code" class="form-control-label mb-1">{{ trans('cruds.product.fields.p_code') }}: <span class="text-danger">*</span></label>
                    <input id="p_code" name="p_code" class="form-control" type="text" placeholder="{{ trans('cruds.product.fields.p_code') }}">
                    <span class="text-danger error-text p_code_error"></span>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                  <div class="form-group">
                    <label for="unit" class="form-control-label mb-1">{{ trans('cruds.product.fields.unit') }}: <span class="text-danger">*</span></label>
                    <input id="unit" name="unit" class="form-control" type="text" placeholder="{{ trans('cruds.product.fields.unit') }}">
                    <span class="text-danger error-text unit_error"></span>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                  <div class="form-group">
                    <label for="strength" class="form-control-label mb-1">{{ trans('cruds.product.fields.strength') }}: <span class="text-danger">*</span></label>
                    <input id="strength" name="strength" class="form-control" type="text" placeholder="{{ trans('cruds.product.fields.strength') }}">
                    <span class="text-danger error-text strength_error"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="form-group">
                    <label for="group_id" class="form-control-label mb-1">{{ trans('cruds.product.fields.group_id') }}: <span class="text-danger">*</span></label>
                    <input disabled id="group_id" name="group_id" class="form-control" type="group_id" placeholder="{{ trans('cruds.product.fields.group_id') }}">
                    <span class="text-danger error-text group_id_error"></span>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="form-group">
                    <label for="type_id" class="form-control-label mb-1">{{ trans('cruds.product.fields.type_id') }}: <span class="text-danger">*</span></label>
                    <input disabled id="type_id" name="type_id" class="form-control" type="text" placeholder="{{ trans('cruds.product.fields.type_id') }}">
                    <span class="text-danger error-text type_id_error"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="form-group">
                    <label for="country" class="form-control-label mb-1">{{ trans('cruds.product.fields.country') }}: <span class="text-danger">*</span></label>
                    <input id="country" name="country" class="form-control" type="text" placeholder="{{ trans('cruds.product.fields.country') }}">
                    <span class="text-danger error-text country_error"></span>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="form-group">
                    <label for="description" class="form-control-label mb-1">{{ trans('cruds.product.fields.description') }}: <span class="text-danger">*</span></label>
                    <input id="description" name="description" class="form-control" type="text" placeholder="{{ trans('cruds.product.fields.description') }}">
                    <span class="text-danger error-text description_error"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-lg-3 col-md-3 col-sm-4">
                  <div class="form-group">
                    <div class="form-check form-switch">
                      <input id="status" name="status" class="form-check-input" type="checkbox" checked>
                      <label class="form-check-label mt-1" for="flexSwitchCheckChecked"><strong>&nbsp;&nbsp;{{ trans('global.status') }}</strong></label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-8">
                  <div class="form-group">
                    <input type="hidden" name="old_image" id="old_image">
                    <label for="image" class="form-control-label mb-1">{{ trans('cruds.product.fields.image') }}: <span class="text-danger">*</span></label>
                    <input id="image" name="image" class="form-control" type="file" multiple="">
                    <span class="text-danger error-text image_error"></span>
                  </div>
                </div>
              </div>
            </div><!-- col-xl-12 -->
          </div>
        </div>
        <div class="modal-footer">
          @include('admin.templates.button')
        </div>
      </form>
    </div>
  </div>
</div>
