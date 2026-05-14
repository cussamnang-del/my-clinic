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
            <div class="col-lg-9 col-md-9 col-sm-12">
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label for="name_en" class="form-control-label mb-1">{{ trans('cruds.company_information.fields.name_en') }}: <span class="text-danger">*</span></label>
                    <input id="name_en" name="name_en" class="form-control" type="text" placeholder="{{ trans('cruds.company_information.fields.name_en') }}">
                    <span class="text-danger error-text name_en_error"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label for="name_kh" class="form-control-label mb-1">{{ trans('cruds.company_information.fields.name_kh') }}: <span class="text-danger">*</span></label>
                    <input id="name_kh" name="name_kh" class="form-control" type="text" placeholder="{{ trans('cruds.company_information.fields.name_kh') }}">
                    <span class="text-danger error-text name_kh_error"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label for="address" class="form-control-label mb-1">{{ trans('cruds.company_information.fields.address') }}: <span class="text-danger">*</span></label>
                    <input id="address" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.company_information.fields.address') }}">
                    <span class="text-danger error-text address_error"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <label for="phone1" class="form-control-label mb-1">{{ trans('cruds.company_information.fields.phone1') }}: <span class="text-danger">*</span></label>
                    <input id="phone1" name="phone1" class="form-control" type="text" placeholder="{{ trans('cruds.company_information.fields.phone1') }}">
                    <span class="text-danger error-text phone1_error"></span>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <label for="phone2" class="form-control-label mb-1">{{ trans('cruds.company_information.fields.phone2') }}: <span class="text-danger">*</span></label>
                    <input id="phone2" name="phone2" class="form-control" type="text" placeholder="{{ trans('cruds.company_information.fields.phone2') }}">
                    <span class="text-danger error-text phone2_error"></span>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <label for="phone3" class="form-control-label mb-1">{{ trans('cruds.company_information.fields.phone3') }}: <span class="text-danger">*</span></label>
                    <input id="phone3" name="phone3" class="form-control" type="text" placeholder="{{ trans('cruds.company_information.fields.phone3') }}">
                    <span class="text-danger error-text phone3_error"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="form-group">
                  <div class="form-check form-switch">
                    <input id="status" name="status" class="form-check-input" type="checkbox" checked>
                    <label class="form-check-label mt-1" for="flexSwitchCheckChecked">&nbsp;&nbsp;Status</label>
                  </div>
                </div>
              </div>
            </div><!-- col-xl-9 -->
            <div class="col-lg-3 col-md-3 col-sm-3">
              <div class="form-group text-center">
                <label for="name_en" class="form-control-label mb-1"><strong>{{ trans('cruds.company_information.fields.logo') }}</strong></label>
                <div class="img-box mb-2">
                  <input type="hidden" name="old_image" id="old_image">
                  <input type="file" name="photo" id="photo" class="d-none"/>
                  <img id="preview" class="img-thumbnail" src="{{ asset('images/image-icon.png') }}"/>
                </div>
                <div class="btn-action mt-2">
                  <a href="javascript:changeProfile()" class="btn btn-sm btn-outline-success px-4 imgupload" id="imgupload">Upload</a> |
                  <a href="javascript:removeImage()" class="btn btn-outline-danger px-4 btn-sm remove" id="remove">Remove</a>
                </div>
                <span class="text-danger error-text photo_error"></span>
              </div>
            </div><!-- col-xl-3 -->
          </div>
        </div>
        <div class="modal-footer">
          @include('admin.templates.button')
        </div>
      </form>
    </div>
  </div>
</div>
