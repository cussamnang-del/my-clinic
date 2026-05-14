<div class="modal fade" id="addSeriveObjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <form id="frmAddService" action="{{ route('admin.'.$crudRoutePath.'.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="rx_bio_name" id="rx_bio_name">
        <input type="hidden" name="rx_bio_customer_code" id="rx_bio_customer_code">
        <input type="hidden" name="rx_bio_age" id="rx_bio_age">
        <input type="hidden" name="rx_bio_sex" id="rx_bio_sex">
        <input type="hidden" name="rx_bio_customer_id" id="rx_bio_customer_id">
        <input type="hidden" name="rx_bio_document_id" id="rx_bio_document_id">
        <input type="hidden" name="rx_bio_phone_no" id="rx_bio_phone_no">
        <input type="hidden" name="rx_bio_address" id="rx_bio_address">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Service Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-evenly">
            <div class="col-lg-6">
              <div class="d-flex align-items-center justify-content-between fs-6 mb-3">
                <a id="objecBio" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Bio Form" aria-label="Add">Bio</a>
                <a id="objecPBio" href="#" class="btn btn-primary btn-sm text-white" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show P.Bio" aria-label="Add">P.Bio</a>
                <a id="objecMore" href="#" class="btn btn-primary btn-sm text-white px-2" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View more" aria-label="Add">More</a>
                <a id="objectRx" href="#" class="btn btn-success btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Rx Form" aria-label="Edit">Rx</a>
                <a id="objectRxNurse" href="#" class="btn btn-success btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Rx Nurse" aria-label="Show">RxNurse</a>
                <a id="objectPRx" href="#" class="btn btn-success btn-sm text-white" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show P.Rx" aria-label="Edit">P.Rx</a>
                <a id="objectInfo" href="#" class="btn btn-success btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit">Info</a>
                <a id="objectH" href="#" class="btn btn-info btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show H Form" aria-label="Edit">H</a>
                <a id="objectHT" href="#" class="btn btn-info btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show HT Form" aria-label="Edit">HT</a>
                <a id="objectOrdo" href="#" class="btn btn-info btn-sm text-white" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Order Form" aria-label="Edit">Order</a>
                <a id="objectOrdoList" href="{{ route('admin.histories.showHistory') }}" class="btn btn-secondary btn-sm text-white" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit">Customer History</a>
              </div>
            </div>
          </div>
          {{-- customer information --}}
          <div class="row">
            {{-- customer info --}}
            <div class="col-lg-5">
              <div class="row">
                <div class="col-lg-6">
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
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="age" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.age') }}:</strong> </label>
                      <div class="col-lg-10">
                        <input readonly id="age" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
                      </div>
                    </div>
                    <span class="text-danger error-text age_error"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="sex" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.sex') }}:</strong> </label>
                      <div class="col-lg-10">
                        <input readonly id="sex" sex="sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="customer_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
                      <div class="col-lg-8">
                        <input readonly id="customer_id" name="customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="phone_no" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.phone_no') }}:</strong> </label>
                      <div class="col-lg-10">
                        <input readonly id="phone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
                      </div>
                    </div>
                    <span class="text-danger error-text phone_no_error"></span>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="document_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.document.title_singular') }} {{ trans('cruds.document.fields.id') }}:</strong> </label>
                      <div class="col-lg-8">
                        <input readonly id="document_id" name="document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="address" class="form-control-label mb-2 col-lg-1"><strong>{{ trans('cruds.document.fields.address') }}:</strong> </label>
                      <div class="col-lg-11">
                        <input readonly id="address" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- alert info --}}
            <div class="col-lg-7">
              <div class="row">
                <div class="col-lg-6">
                  <div class="table-responsive">
                    <table id="typeA" class="table table-striped table-bordered">
                    </table>
                  </div>
                  <div class="d-flex justify-content-end gap-3 fs-6 mb-3">
                    <a id="objectAddTypeA" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Add New" aria-label="Add">+</a>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="table-responsive">
                    <table id="typeB" class="table table-striped table-bordered">
                    </table>
                  </div>
                  <div class="d-flex justify-content-end gap-3 fs-6 mb-3">
                    <a id="objectAddTypeB" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Add New" aria-label="Add">+</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- end customer information --}}
          <br>
          {{-- customer history information --}}
          <div id="customer_history_information">
          </div>
        </div>
      </form>
      <div id="order_receipt">
      </div>
    </div>
  </div>
</div>
