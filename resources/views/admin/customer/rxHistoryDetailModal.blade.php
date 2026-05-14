<div class="modal fade" id="rxHistoryDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-center modal-xl">
    <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">Rx History Detail Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="name" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.name') }}:</strong> </label>
                  <div class="col-lg-10">
                    <input readonly id="name" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
                  </div>
                </div>
                <span class="text-danger error-text name_error"></span>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="customer_id" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.id') }}:</strong> </label>
                  <div class="col-lg-10">
                    <input readonly id="customer_id" name="customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.id') }}">
                  </div>
                </div>
                <span class="text-danger error-text customer_id_error"></span>
              </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="customer_code" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.fields.customer_code') }}:</strong> </label>
                  <div class="col-lg-8">
                    <input readonly id="customer_code" name="customer_code" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.customer_code') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="age" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.age') }}:</strong> </label>
                  <div class="col-lg-10">
                    <input readonly id="age" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="phone_no" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.phone_no') }}:</strong> </label>
                  <div class="col-lg-10">
                    <input readonly id="phone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="register_date" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.fields.register_date') }}:</strong> </label>
                  <div class="col-lg-8">
                    <input readonly id="register_date" name="register_date" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.register_date') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card border">
            <div class="card-body" id="history_rx_detail">

            </div>
          </div>
        </div>
    </div>
  </div>
</div>
