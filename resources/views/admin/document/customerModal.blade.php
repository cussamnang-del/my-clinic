<div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <form id="frmCustomer" action="{{ route('admin.'.$crudRoutePath.'.storeCustomer') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">
            {{ trans('global.add') }} {{ trans('cruds.customer.title_singular') }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="object_id" id="object_id">
          <input type="hidden" name="crudRoutePath" id="crudRoutePath" value="{{ $crudRoutePath }}">
          <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12">
              <div class="row mb-2">
                <div class="col-lg-4 col-md-4 col-sm-6">
                  <div class="form-group">
                    <label for="name" class="form-control-label">{{ trans('cruds.customer.fields.name') }} {{ trans('cruds.customer.title_singular') }}: <span class="text-danger">*</span></label>
                    <input id="name" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }} {{ trans('cruds.customer.title_singular') }}">
                    <span class="text-danger error-text name_error"></span>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                  <div class="form-group">
                    <label for="sex" class="form-control-label">{{ trans('cruds.customer.fields.sex') }}: <span class="text-danger">*</span></label>
                    <select id="sex" name="sex" class="form-control single-select" style="width: 100%" data-placeholder="Choose {{ trans('cruds.customer.fields.sex') }}">
                      <option value="{{ trans('global.male') }}">{{ trans('global.male') }}</option>
                      <option value="{{ trans('global.female') }}">{{ trans('global.female') }}</option>
                    </select>
                    <span class="text-danger error-text sex_error"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-lg-4 col-md-4 col-sm-6">
                  <div class="form-group">
                    <label for="age" class="form-control-label">{{ trans('cruds.customer.fields.age') }}: <span class="text-danger">*</span></label>
                    <input id="age" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
                    <span class="text-danger error-text age_error"></span>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                  <div class="form-group">
                    <label for="dob" class="form-control-label">{{ trans('cruds.customer.fields.dob') }}: <span class="text-danger">*</span></label>
                    <div class="input-group mb-2">
                      <input readonly id="dob" name="dob" type="text" class="form-control" placeholder="{{ trans('cruds.customer.fields.dob') }}" aria-label="{{ trans('cruds.customer.fields.dob') }}" aria-describedby="basic-addon2"> <span class="input-group-text" id="basic-addon2"><i class="fadeIn animated bx bx-calendar-exclamation"></i></span>
                    </div>
                    <span class="text-danger error-text dob_error"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <label for="province_id" class="form-control-label">{{ trans('cruds.customer.fields.province_id') }}:</label>
                    <select id="province_id" name="province_id" class="form-control single-select"  style="width: 100%" data-placeholder="Choose Province">
                      <option value="">{{ trans('global.select') }} {{ trans('cruds.customer.fields.province_id') }}</option>
                      @foreach ($provinces as $key => $row)
                        <option value="{{ $row->id }}">{{ $row->name_en }}</option>
                      @endforeach
                    </select>
                    <span class="text-danger error-text province_id_error"></span>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <label for="district_id" class="form-control-label">{{ trans('cruds.customer.fields.district_id') }}:</label>
                    <select id="district_id" name="district_id" class="form-control single-select" disabled  style="width: 100%" data-placeholder="Choose Province">
                      <option value="">{{ trans('global.select') }} {{ trans('cruds.customer.fields.district_id') }}</option>
                    </select>
                    <span class="text-danger error-text district_id_error"></span>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <label for="commune_id" class="form-control-label">{{ trans('cruds.customer.fields.commune_id') }}:</label>
                    <select id="commune_id" name="commune_id" class="form-control single-select" disabled  style="width: 100%" data-placeholder="Choose Province">
                      <option value="">{{ trans('global.select') }} {{ trans('cruds.customer.fields.commune_id') }}</option>
                    </select>
                    <span class="text-danger error-text commune_id_error"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <label for="village_id" class="form-control-label">{{ trans('cruds.customer.fields.village_id') }}:</label>
                    <select id="village_id" name="village_id" class="form-control single-select" disabled  style="width: 100%" data-placeholder="Choose Province">
                      <option value="">{{ trans('global.select') }} {{ trans('cruds.customer.fields.village_id') }}</option>
                    </select>
                    <span class="text-danger error-text village_id_error"></span>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <label for="phone_no" class="form-control-label">{{ trans('cruds.customer.fields.phone_no') }}:</label>
                    <input id="phone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
                    <span class="text-danger error-text phone_no_error"></span>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="form-group">
                    <label for="register_date" class="form-control-label">{{ trans('cruds.customer.fields.register_date') }}: <span class="text-danger">*</span></label>
                    <div class="input-group mb-2">
                      <input id="register_date" name="register_date" type="text" class="form-control" placeholder="{{ trans('cruds.customer.fields.register_date') }}" aria-label="{{ trans('cruds.customer.fields.register_date') }}" aria-describedby="basic-addon2"> <span class="input-group-text" id="basic-addon2"><i class="fadeIn animated bx bx-calendar-exclamation"></i></span>
                    </div>
                    <span class="text-danger error-text register_date_error"></span>
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
                <div class="img-box mb-2">
                  <input type="hidden" name="old_image" id="old_image">
                  <input type="file" name="photo" id="photo" class="d-none"/>
                  <img id="preview" class="img-thumbnail" src="{{ asset('images/avatar3.png') }}"/>
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
