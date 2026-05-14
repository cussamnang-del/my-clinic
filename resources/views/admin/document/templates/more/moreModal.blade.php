<div class="modal fade" id="moreObjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">More Controls Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
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
                        <input readonly id="more_name" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
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
                        <input readonly id="more_age" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
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
                        <input readonly id="more_sex" sex="sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="customer_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
                      <div class="col-lg-8">
                        <input readonly id="more_customer_id" name="customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
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
                        <input readonly id="more_phone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
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
                        <input readonly id="more_document_id" name="document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
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
                        <input readonly id="more_address" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
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
          {{-- Operative Protocols information --}}
          <div class="row">
            <div class="col-xl-10 col-lg-10 offset-xl-1 offset-lg-1">
              <div class="card border mt-2">
                <div class="card-body">
                  <ul class="nav nav-tabs nav-primary" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" data-bs-toggle="tab" href="#operative" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                          <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                          </div>
                          <div class="tab-title">{{ trans('cruds.operative_protocol.title') }}</div>
                        </div>
                      </a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" data-bs-toggle="tab" href="#certificate" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                          <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                          </div>
                          <div class="tab-title">{{ trans('cruds.medical_certificate.title') }}</div>
                        </div>
                      </a>
                    </li>
                    {{-- <li class="nav-item" role="presentation">
                      <a class="nav-link" data-bs-toggle="tab" href="#successmore" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                          <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                          </div>
                          <div class="tab-title">{{ trans('cruds.medical_certificate.title') }}</div>
                        </div>
                      </a>
                    </li> --}}
                  </ul>
                  <div class="tab-content py-3">
                    <div class="tab-pane fade show active" id="operative" role="tabpanel">
                      <form id="frmProtocol" action="{{ route('admin.'.$crudRoutePath.'.storeProtocol') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="protocol_customer_id" id="protocol_customer_id">
                        <input type="hidden" name="protocol_document_id" id="protocol_document_id">
                        <input type="hidden" name="protocol_object_id" id="protocol_object_id">
                        {{-- order information --}}
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-group mb-2">
                                <label for="date" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.date') }}:</label>
                                <input id="date" name="date" class="form-control" type="text" placeholder="{{ trans('cruds.operative_protocol.fields.date') }}">
                                <span class="text-danger error-text date_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group mb-2">
                                <label for="time" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.time') }}:</label>
                                <input id="time" name="time" class="form-control time" type="text" placeholder="{{ trans('cruds.operative_protocol.fields.time') }}">
                                <span class="text-danger error-text time_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="operater" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.operater') }}:</label>
                                <input id="operater" name="operater" class="form-control" type="text" placeholder="{{ trans('cruds.operative_protocol.fields.operater') }}">
                                <span class="text-danger error-text operater_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="aide" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.aide') }}:</label>
                                <input id="aide" name="aide" class="form-control" type="text" placeholder="{{ trans('cruds.operative_protocol.fields.aide') }}">
                                <span class="text-danger error-text aide_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="anesth" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.anesth') }}:</label>
                                <input id="anesth" name="anesth" class="form-control" type="text" placeholder="{{ trans('cruds.operative_protocol.fields.anesth') }}">
                                <span class="text-danger error-text anesth_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="diapre" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.diapre') }}:</label>
                                <input id="diapre" name="diapre" class="form-control" type="text" placeholder="{{ trans('cruds.operative_protocol.fields.diapre') }}">
                                <span class="text-danger error-text diapre_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="diaper" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.diaper') }}:</label>
                                <input id="diaper" name="diaper" class="form-control" type="text" placeholder="{{ trans('cruds.operative_protocol.fields.diaper') }}">
                                <span class="text-danger error-text diaper_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="indication" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.indication') }}:</label>
                                <input id="indication" name="indication" class="form-control" type="text" placeholder="{{ trans('cruds.operative_protocol.fields.indication') }}">
                                <span class="text-danger error-text indication_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group mb-2">
                                <label for="position" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.position') }}:</label>
                                <input id="position" name="position" class="form-control" type="text" placeholder="{{ trans('cruds.operative_protocol.fields.position') }}">
                                <span class="text-danger error-text position_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group mb-2">
                                <label for="note" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.note') }}:</label>
                                <textarea name="note" id="note" class="form-control" cols="30" rows="10" placeholder="{{ trans('cruds.operative_protocol.fields.note') }}"></textarea>
                                <span class="text-danger error-text note_error"></span>
                              </div>
                            </div>
                          </div>
                        {{-- end order information --}}
                        <div class="float-end">
                          @include('admin.templates.button')
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="certificate" role="tabpanel">
                      <form id="frmMedicine" action="{{ route('admin.'.$crudRoutePath.'.storeMedicine') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="medicine_customer_id" id="medicine_customer_id">
                        <input type="hidden" name="medicine_document_id" id="medicine_document_id">
                        <input type="hidden" name="medicine_object_id" id="medicine_object_id">
                        {{-- order information --}}
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-group mb-2">
                                <label for="date" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.date') }}:</label>
                                <input id="date" name="date" class="form-control" type="text" placeholder="{{ trans('cruds.operative_protocol.fields.date') }}">
                                <span class="text-danger error-text date_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group mb-2">
                                <label for="time" class="form-control-label mb-2">{{ trans('cruds.operative_protocol.fields.time') }}:</label>
                                <input id="time" name="time" class="form-control time" type="text" placeholder="{{ trans('cruds.operative_protocol.fields.time') }}">
                                <span class="text-danger error-text time_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="chief_complain" class="form-control-label mb-2">{{ trans('cruds.order.fields.chief_complain') }}:</label>
                                <input id="chief_complain" name="chief_complain" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.chief_complain') }}">
                                <span class="text-danger error-text chief_complain_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="past_history" class="form-control-label mb-2">{{ trans('cruds.order.fields.past_history') }}:</label>
                                <input id="past_history" name="past_history" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.past_history') }}">
                                <span class="text-danger error-text past_history_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="physical_examination" class="form-control-label mb-2">Physical Examination:</label>
                                <input id="physical_examination" name="physical_examination" class="form-control" type="text" placeholder="Physical Examination">
                                <span class="text-danger error-text physical_examination_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="diagnosis" class="form-control-label mb-2">{{ trans('cruds.order.fields.diagnosis') }}:</label>
                                <input id="diagnosis" name="diagnosis" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.diagnosis') }}">
                                <span class="text-danger error-text diagnosis_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group mb-2">
                                <label for="treatment_plan" class="form-control-label mb-2">Treatment Plan:</label>
                                <input id="treatment_plan" name="treatment_plan" class="form-control" type="text" placeholder="Treatment Plan">
                                <span class="text-danger error-text treatment_plan_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group mb-2">
                                <label for="physician_recommendation" class="form-control-label mb-2">Physician Recommendation:</label>
                              </div>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-lg-4">
                              <div class="form-check">
                                <input id="sick_leave" name="sick_leave" class="form-check-input" type="checkbox">
                                <label class="form-check-label mt-1" for="sick_leave">&nbsp;&nbsp;Sick Leave (if suggested by Physician)</label>
                              </div>
                            </div>
                            <div class="col-lg-1">
                              <label for="attending_physician" class="form-control-label mb-2">From</label>
                            </div>
                            <div class="col-lg-3">
                              <div class="form-group">
                                <input type="text" name="from_date" id="from_date" class="form-control">
                              </div>
                            </div>
                            <div class="col-lg-1">
                              <label for="attending_physician" class="form-control-label mb-2">To</label>
                            </div>
                            <div class="col-lg-3">
                              <div class="form-group">
                                <input type="text" name="to_date" id="to_date" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group mb-2">
                                <label for="attending_physician" class="form-control-label mb-2">Attending Physician:</label>
                                <input id="attending_physician" name="attending_physician" class="form-control" type="text" placeholder="Attending Physician">
                                <span class="text-danger error-text attending_physician_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row mb-1">
                            <div class="col-lg-1">
                              <div class="form-check">
                                <input id="is_other" name="is_other" class="form-check-input" type="checkbox">
                                <label class="form-check-label mt-1" for="is_other">&nbsp;&nbsp;Other</label>
                              </div>
                            </div>
                            <div class="col-lg-11">
                              <div class="form-group d-none" id="showhide">
                                <textarea name="medicine_note" id="medicine_note" class="form-control" cols="30" rows="10" placeholder="Other Note"></textarea>
                                <span class="text-danger error-text medicine_note_error"></span>
                              </div>
                            </div>
                          </div>
                         {{-- end order information --}}
                        <div class="float-end mt-2">
                          @include('admin.templates.button')
                        </div>
                      </form>
                    </div>
                    {{-- <div class="tab-pane fade" id="successmore" role="tabpanel">
                      <form id="frmsuccessmore" action="{{ route('admin.'.$crudRoutePath.'.storeObjectInjection') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="injection_customer_id" id="injection_customer_id">
                        <input type="hidden" name="injection_document_id" id="injection_document_id">
                        {{-- order information --}}
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-group mb-2">
                                <label for="chief_complain" class="form-control-label mb-2">{{ trans('cruds.order.fields.chief_complain') }}:</label>
                                <input id="chief_complain" name="chief_complain" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.chief_complain') }}">
                                <span class="text-danger error-text chief_complain_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group mb-2">
                                <label for="past_history" class="form-control-label mb-2">{{ trans('cruds.order.fields.past_history') }}:</label>
                                <input id="past_history" name="past_history" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.past_history') }}">
                                <span class="text-danger error-text past_history_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group mb-2">
                                <label for="blood_test" class="form-control-label mb-2">{{ trans('cruds.order.fields.blood_test') }}:</label>
                                <input id="blood_test" name="blood_test" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.blood_test') }}">
                                <span class="text-danger error-text blood_test_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-group mb-2">
                                <label for="orl_ent" class="form-control-label mb-2">{{ trans('cruds.order.fields.orl_ent') }}:</label>
                                <input id="orl_ent" name="orl_ent" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.orl_ent') }}">
                                <span class="text-danger error-text orl_ent_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group mb-2">
                                <label for="ultra_sound" class="form-control-label mb-2">{{ trans('cruds.order.fields.ultra_sound') }}:</label>
                                <input id="ultra_sound" name="ultra_sound" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.ultra_sound') }}">
                                <span class="text-danger error-text ultra_sound_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group mb-2">
                                <label for="ecg" class="form-control-label mb-2">{{ trans('cruds.order.fields.ecg') }}:</label>
                                <input id="ecg" name="ecg" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.ecg') }}">
                                <span class="text-danger error-text ecg_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="x_ray" class="form-control-label mb-2">{{ trans('cruds.order.fields.x_ray') }}:</label>
                                <input id="x_ray" name="x_ray" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.x_ray') }}">
                                <span class="text-danger error-text x_ray_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="et_at" class="form-control-label mb-2">{{ trans('cruds.order.fields.et_at') }}:</label>
                                <input id="et_at" name="et_at" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.et_at') }}">
                                <span class="text-danger error-text et_at_error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="diagnosis" class="form-control-label mb-2">{{ trans('cruds.order.fields.diagnosis') }}:</label>
                                <input id="diagnosis" name="diagnosis" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.diagnosis') }}">
                                <span class="text-danger error-text diagnosis_error"></span>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <label for="recommendation" class="form-control-label mb-2">{{ trans('cruds.order.fields.recommendation') }}:</label>
                                <input id="recommendation" name="recommendation" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.recommendation') }}">
                                <span class="text-danger error-text recommendation_error"></span>
                              </div>
                            </div>
                          </div>
                        {{-- end order information --}}
                        <div class="float-end">
                          @include('admin.templates.button')
                        </div>
                      </form>
                    </div> --}}
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- end perative Protocols information --}}
        </div>
    </div>
  </div>
</div>

@push('modal')
  <script>
    $('body').on('click','a#objecMore',function(e){
      e.preventDefault();
      var customer_id = $('#rx_bio_customer_id').val();
      var modal = $('#moreObjectModal');
      modal.trigger('reset');
      modal.find('#more_customer_code').val($('#rx_bio_customer_code').val());
      modal.find('#more_name').val($('#rx_bio_name').val());
      modal.find('#more_age').val($('#rx_bio_age').val());
      modal.find('#more_sex').val($('#rx_bio_sex').val());
      modal.find('#more_phone_no').val($('#rx_bio_phone_no').val());
      modal.find('#more_address').val($('#rx_bio_address').val());
      modal.find('#more_customer_id').val($('#rx_bio_customer_id').val());
      modal.find('#more_document_id').val($('#rx_bio_document_id').val());
      $.ajax({
      type : 'get',
      dataType: 'JSON',
      url: '{{ route("admin.documents.getMore") }}',
      data: {
        'customer_id' : customer_id,
      },
      success: function (res) {
        modal.find('#typeA').empty().append(res.typeA);
        modal.find('#typeB').empty().append(res.typeB);
        modal.find('.time').datetimepicker({
          format: 'HH:mm:ss',
          sideBySide: true,
          icons: {
            up: 'bx bx-chevron-up-circle',
            down: 'bx bx-chevron-down-circle',
            previous: 'bx bx-chevron-left-circle',
            next: 'bx bx-chevron-right-circle'
          }
        });
        modal.find('#date, #from_date, #to_date').datetimepicker({
          format: 'DD-MM-YYYY',
          sideBySide: true,
          icons: {
            up: 'bx bx-chevron-up-circle',
            down: 'bx bx-chevron-down-circle',
            previous: 'bx bx-chevron-left-circle',
            next: 'bx bx-chevron-right-circle'
          }
        });
        modal.find('#date, #from_date, #to_date').val(dd+'-'+mm+'-'+yy);
        $('#frmProtocol').find('#protocol_customer_id').val($('#rx_bio_customer_id').val());
        $('#frmProtocol').find('#protocol_document_id').val($('#rx_bio_document_id').val());
        $('#frmMedicine').find('#medicine_customer_id').val($('#rx_bio_customer_id').val());
        $('#frmMedicine').find('#medicine_document_id').val($('#rx_bio_document_id').val());
      },
      error: function (error) {
        console.log('Error:', error);
        $('#btnObjectSave').html(`{{ trans('global.save') }}`);
        $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
      }
      });
      modal.modal('show');
    });
  </script>
@endpush
