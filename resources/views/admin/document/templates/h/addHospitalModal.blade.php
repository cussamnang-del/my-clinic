<div class="modal fade" id="addHospitalObjectModal" tabindex="-1"
      aria-hidden="true"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      aria-labelledby="addHospitalObjectModal">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <form id="frmAddHospital" action="{{ route('admin.'.$crudRoutePath.'.storeObjectH') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="h_hospital_id" id="h_hospital_id">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Hospital Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- customer information --}}
          <div class="row">
            <div class="col-lg-6">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="h_name" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.name') }}:</strong> </label>
                      <div class="col-lg-10">
                        <input readonly id="h_name" name="h_name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="h_age" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.age') }}:</strong> </label>
                      <div class="col-lg-10">
                        <input readonly id="h_age" name="h_age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="h_sex" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.sex') }}:</strong> </label>
                      <div class="col-lg-10">
                        <input readonly id="h_sex" name="h_sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="h_customer_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
                      <div class="col-lg-8">
                        <input readonly id="h_customer_id" name="h_customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="h_phone_no" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.phone_no') }}:</strong> </label>
                      <div class="col-lg-10">
                        <input readonly id="h_phone_no" name="h_phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="h_document_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.document.title_singular') }} {{ trans('cruds.document.fields.id') }}:</strong> </label>
                      <div class="col-lg-8">
                        <input readonly id="h_document_id" name="h_document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="h_address" class="form-control-label mb-2 col-lg-1"><strong>{{ trans('cruds.document.fields.address') }}:</strong> </label>
                      <div class="col-lg-11">
                        <input readonly id="h_address" name="h_address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="col-lg-6">
              <div class="row">
                <div class="col-lg-6">
                  <div class="table-responsive">
                    <table id="typeA" class="table table-striped table-bordered">

                    </table>
                  </div>
                  <div class="d-flex justify-content-end gap-3 fs-6 mb-3">
                    <a id="hobjectAddTypeA" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Add New" aria-label="Add">+</a>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="table-responsive">
                    <table id="typeB" class="table table-striped table-bordered">

                    </table>
                  </div>
                  <div class="d-flex justify-content-end gap-3 fs-6 mb-3">
                    <a id="hobjectAddTypeB" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Add New" aria-label="Add">+</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- hospital information form --}}
          <div class="card border mt-5">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <label for="room_no" class="form-control-label mb-2">{{ trans('cruds.hospital.fields.room_no') }}:</label>
                    <select id="room_no" name="room_no" class="form-control single-select" multiple>
                      @foreach ($rooms as $key => $label)
                        <option value="{{ $key}}">{{ $label }}</option>
                      @endforeach
                    </select>
                    <span class="text-danger error-text room_no_error"></span>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <label for="h_date" class="form-control-label mb-2">{{ trans('cruds.hospital.fields.h_date') }}:</label>
                    <input id="h_date" name="h_date" class="form-control" type="text" placeholder="{{ trans('cruds.hospital.fields.h_date') }}">
                    <span class="text-danger error-text h_date_error"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-9">
                  <div class="form-group mb-2">
                    <label for="h_note" class="form-control-label mb-2">{{ trans('cruds.hospital.fields.h_note') }}:</label>
                    <input id="h_note" name="h_note" class="form-control" type="text" placeholder="{{ trans('cruds.hospital.fields.h_note') }}">
                    <span class="text-danger error-text h_note_error"></span>
                  </div>
                </div>
                <div class="col-lg-3 mt-2">
                  <div class="form-group mt-4">
                    <div class="form-check form-switch">
                      <input id="status" name="status" class="form-check-input" type="checkbox" checked>
                      <label class="form-check-label mt-1" for="flexSwitchCheckChecked">&nbsp;&nbsp;{{ trans('global.status') }}</label>
                    </div>
                  </div>
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
