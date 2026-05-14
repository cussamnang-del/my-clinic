<div class="modal fade" id="newHospitalTreatmentObjectModal" tabindex="-1"
      aria-hidden="true"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      aria-labelledby="newHospitalTreatmentObjectModal">
  <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
    <div class="modal-content">
      <div style="overflow: scroll">
        <form id="frmHospitalTreatment" action="{{ route('admin.'.$crudRoutePath.'.storeObjectHNote') }}" method="post">
          {{ csrf_field() }}
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Hospital Treatment Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            {{-- customer and document information --}}
            <div class="row">
              <div class="col-lg-6">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group mb-2">
                      <div class="row">
                        <label for="ht_name" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.name') }}:</strong> </label>
                        <div class="col-lg-10">
                          <input readonly id="ht_name" name="ht_name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group mb-2">
                      <div class="row">
                        <label for="ht_age" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.age') }}:</strong> </label>
                        <div class="col-lg-10">
                          <input readonly id="ht_age" name="ht_age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group mb-2">
                      <div class="row">
                        <label for="ht_sex" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.sex') }}:</strong> </label>
                        <div class="col-lg-10">
                          <input readonly id="ht_sex" name="ht_sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group mb-2">
                      <div class="row">
                        <label for="ht_customer_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
                        <div class="col-lg-8">
                          <input readonly id="ht_customer_id" name="ht_customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group mb-2">
                      <div class="row">
                        <label for="ht_phone_no" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.phone_no') }}:</strong> </label>
                        <div class="col-lg-10">
                          <input readonly id="ht_phone_no" name="ht_phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group mb-2">
                      <div class="row">
                        <label for="ht_document_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.document.title_singular') }} {{ trans('cruds.document.fields.id') }}:</strong> </label>
                        <div class="col-lg-8">
                          <input readonly id="ht_document_id" name="ht_document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group mb-2">
                      <div class="row">
                        <label for="ht_address" class="form-control-label mb-2 col-lg-1"><strong>{{ trans('cruds.document.fields.address') }}:</strong> </label>
                        <div class="col-lg-11">
                          <input readonly id="ht_address" name="ht_address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
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
                      <a id="htobjectAddTypeA" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Add New" aria-label="Add">+</a>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="table-responsive">
                      <table id="typeB" class="table table-striped table-bordered">

                      </table>
                    </div>
                    <div class="d-flex justify-content-end gap-3 fs-6 mb-3">
                      <a id="htobjectAddTypeB" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Add New" aria-label="Add">+</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- end customer and document information --}}
            {{-- hospital information form --}}
            <fieldset class="form-group p-3">
              <legend class="w-auto px-2">Hospital</legend>
              <form  action="" method="post">
                {{ csrf_field() }}
                <div class="row">
                  <div class="col-lg-5">
                    <div class="form-group mb-2">
                      <label for="room_no" class="form-control-label mb-2">{{ trans('cruds.hospital.fields.room_no') }}:</label>
                      <select id="room_no" name="room_no" class="form-control single-select">
                        @foreach ($rooms as $key => $label)
                          <option value="{{ $key}}">{{ $label }}</option>
                        @endforeach
                      </select>
                      <span class="text-danger error-text room_no_error"></span>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="form-group mb-2">
                      <label for="h_date" class="form-control-label mb-2">{{ trans('cruds.hospital.fields.h_date') }}:</label>
                      <input id="h_date" name="h_date" value="{{date('d-m-Y H:i:s')}}" class="form-control" type="text" placeholder="{{ trans('cruds.hospital.fields.h_date') }}">
                      <span class="text-danger error-text h_date_error"></span>
                    </div>
                  </div>
                  <div class="col-lg-1 mt-2">
                    <div class="form-group mt-4">
                      <div class="form-check form-switch">
                        <input id="status" name="status" class="form-check-input" type="checkbox" checked>
                        <label class="form-check-label mt-1" for="flexSwitchCheckChecked">&nbsp;&nbsp;{{ trans('global.status') }}</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-1 mt-2">
                    <div class="form-group mt-4 d-grid gap-2">
                      <button id="btnSaveHospital" type="submit" class="btn btn-sm btn-success px-3 radius-30">
                        <i class="fadeIn animated bx bx-plus-circle"></i>&nbsp;&nbsp;{{ trans('global.save') }}
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </fieldset>
            {{-- Hospital Treatment form --}}
              <div class="card mt-2">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-4">
                      <fieldset class="form-group p-3">
                        <legend class="w-auto px-2">Medical Observation</legend>
                        <div class="form-group mb-2">
                          <label for="mob" class="form-control-label mb-2">{{ trans('cruds.hnote.fields.mob') }}:</label>
                          {{-- <input id="mob" name="mob" class="form-control" type="text" placeholder="{{ trans('cruds.hnote.fields.mob') }}"> --}}
                          <textarea name="mob" id="mob" cols="100" rows="5" class="form-control mb-2" placeholder="{{ trans('cruds.hnote.fields.mob') }}"></textarea>
                          <span class="text-danger error-text mob_error"></span>
                        </div>
                        <div class="form-group mb-2">
                          <label for="dia" class="form-control-label mb-2">{{ trans('cruds.hnote.fields.dia') }}:</label>
                          <input id="dia" name="dia" class="form-control" type="text" placeholder="{{ trans('cruds.hnote.fields.dia') }}">
                          <span class="text-danger error-text dia_error"></span>
                        </div>
                      </fieldset>
                    </div>
                    <div class="col-lg-8">
                      <fieldset class="form-group p-3">
                        <legend class="w-auto px-2"><a id="addHT" class="btn btn-sm btn-outline-info" href="javascript:void(0)">Treatment</a></legend>
                        <div class="row">
                          <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered">
                              <thead class="bg-info">
                                <tr class="text-center">
                                  <th>{{ trans('cruds.ht.fields.h_time') }}</th>
                                  <th>{{ trans('cruds.ht.fields.product_id') }}</th>
                                  <th>{{ trans('cruds.ht.fields.qty') }}</th>
                                  <th>{{ trans('cruds.ht.fields.duration') }}</th>
                                  <th>{{ trans('cruds.ht.fields.how_to_use') }}</th>
                                  <th>{{ trans('global.action') }}</th>
                                </tr>
                              </thead>
                              <tbody id="objectHospitalTreatment">

                              </tbody>
                            </table>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <label for="todo" class="form-control-label col-lg-1"><strong>{{ trans('cruds.hnote.fields.todo') }}:</strong> </label>
                    <div class="col-lg-11">
                      <input id="todo" name="todo" class="form-control" type="text" placeholder="{{ trans('cruds.hnote.fields.todo') }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <label for="comment" class="form-control-label col-lg-1"><strong>{{ trans('cruds.hnote.fields.comment') }}:</strong> </label>
                    <div class="col-lg-11">
                      <input id="comment" name="comment" class="form-control" type="text" placeholder="{{ trans('cruds.hnote.fields.comment') }}">
                    </div>
                  </div>
                </div>
              </div>
            {{-- End Hospital Treatment form --}}
          </div>
          <div class="modal-footer">
            @include('admin.templates.button')
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
