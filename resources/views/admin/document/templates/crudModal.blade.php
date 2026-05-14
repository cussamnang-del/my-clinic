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
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="row g-1">
                <div class="col-lg-10 col-md-10 col-sm-10">
                  <div class="form-group mb-2">
                    <label for="customer_id" class="form-control-label mb-2">{{ trans('cruds.document.fields.customer_id') }}: <span class="text-danger">*</span></label>
                    <select class="form-select" name="customer_id" id="customer_id" data-placeholder="Select Customer">
                      <option value="0">{{ trans('global.select') }} {{ trans('cruds.document.fields.customer_id') }}</option>
                      @foreach ($customers as $key => $customer)
                        <option value="{{ $customer->id }}">({{ $customer->id }})-{{ $customer->name }}</option>
                      @endforeach
                  </select>
                    <span class="text-danger error-text customer_id_error"></span>
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 mt-4">
                  <div class="d-flex align-items-center gap-1 fs-6 mt-3">
                    <a id="objectAddCustomer" href="#" class="btn btn-primary btn-sm objectAdd text-white" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Add Customer" aria-label="Add"><i class="bi bi-plus-circle-fill"></i></a>
                  </div>
                </div>
              </div>
              <div class="form-group mb-2">
                <label for="sex" class="form-control-label mb-2">{{ trans('cruds.customer.fields.sex') }}:</label>
                <input id="sex" sex="sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                <span class="text-danger error-text sex_error"></span>
              </div>
              <div class="form-group mb-2">
                <label for="age" class="form-control-label mb-2">{{ trans('cruds.customer.fields.age') }}:</label>
                <input id="age" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
                <span class="text-danger error-text age_error"></span>
              </div>
              <div class="form-group mb-2">
                <label for="phone_no" class="form-control-label mb-2">{{ trans('cruds.customer.fields.phone_no') }}:</label>
                <input id="phone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
                <span class="text-danger error-text phone_no_error"></span>
              </div>
              <div class="form-group mb-2">
                <label for="address" class="form-control-label mb-2">{{ trans('cruds.document.fields.address') }}:</label>
                <input id="address" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
                <span class="text-danger error-text address_error"></span>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="form-group mb-2">
                <label for="visit_date" class="form-control-label mb-2">{{ trans('cruds.document.fields.visit_date') }}: <span class="text-danger">*</span></label>
                <div class="input-group mb-2">
                  <input  id="visit_date" name="visit_date" type="text" class="form-control" placeholder="{{ trans('cruds.document.fields.visit_date') }}" aria-label="{{ trans('cruds.document.fields.visit_date') }}" aria-describedby="basic-addon2"> <span class="input-group-text" id="basic-addon2"><i class="fadeIn animated bx bx-calendar-exclamation"></i></span>
                </div>
                <span class="text-danger error-text visit_date_error"></span>
              </div>
              <div class="form-group mb-2">
                <label for="checkout_date" class="form-control-label mb-2">{{ trans('cruds.document.fields.checkout_date') }}:</label>
                <div class="input-group mb-2">
                  <input id="checkout_date" name="checkout_date" type="text" class="form-control" placeholder="{{ trans('cruds.document.fields.checkout_date') }}" aria-label="{{ trans('cruds.document.fields.checkout_date') }}" aria-describedby="basic-addon2"> <span class="input-group-text" id="basic-addon2"><i class="fadeIn animated bx bx-calendar-exclamation"></i></span>
                </div>
                <span class="text-danger error-text checkout_date_error"></span>
              </div>
              <div class="form-group mb-4">
                <div class="form-check form-switch">
                  <input id="status" name="status" class="form-check-input" type="checkbox" checked>
                  <label class="form-check-label mt-1" for="flexSwitchCheckChecked">&nbsp;&nbsp;Status</label>
                </div>
              </div>
              <div class="text-center">
                @include('admin.templates.button')
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
