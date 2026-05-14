<div class="tab-content py-3">
  {{-- medecine --}}
  <form id="frmorDo" action="{{ route('admin.'.$crudRoutePath.'.storeObjectOrder') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="print_order_id" id="print_order_id">
    <div class="tab-pane fade show active" id="medicine" role="tabpanel">
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
      {{-- medicine information form --}}
        <div class="row">
          <div class="col-xl-12 col-lg-12">
            <div class="table-responsive">
              <table id="medicine_order" class="table table-striped table-bordered medicine_order">
                <thead>
                  <tr class="text-center">
                    <th>{{ trans('cruds.order.fields.medicine') }}</th>
                    <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.unit') }}</th>
                    <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.strength') }}</th>
                    <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.qty') }}</th>
                    <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.price') }}</th>
                    <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.total') }}</th>
                    <th>{{ trans('cruds.orderDetail.fields.how_to_use') }}</th>
                    <th style="width: 70px;">
                      <div class="form-group">
                        <button id="add_more" type="button" class="btn btn-sm btn-success">Add</button>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody id="order_detail">
                  <tr id="no-delete">
                    <td>
                      <div class="form-group">
                        <select data-id="1" id="order_product" name="order_product[]" class="form-control order_product order_detail"  style="width: 100%" data-placeholder="Select Medecine">
                          <option value="">{{ trans('global.select') }} {{ trans('cruds.order.fields.medicine') }}</option>
                          @foreach ($products as $key => $row)
                            <option value="{{ $row->id }}">{{ $row->p_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </td>
                    <td>
                      <div class="form-group mb-2">
                        <input data-id="1" id="unit" name="unit[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.unit') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group mb-2">
                        <input data-id="1" id="strength" name="strength[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.strength') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group mb-2">
                        <input data-id="1" id="qty" name="qty[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.qty') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group mb-2">
                        <input data-id="1" id="price" name="price[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.price') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group mb-2">
                        <input data-id="1" id="total" name="total[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.total') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group mb-2">
                        <input data-id="1" id="how_to_use" name="how_to_use[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.how_to_use') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <button type="button" class="btn btn-sm btn-danger btn_remove">Remove</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      {{-- end medicine information form --}}
    </div>
  </form>
  {{-- Injection --}}
  <form id="frmorDo" action="{{ route('admin.'.$crudRoutePath.'.storeObjectInjection') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="print_order_id" id="print_order_id">
    <div class="tab-pane fade" id="injection" role="tabpanel">
      {{-- injection information --}}
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
      {{-- end injection information --}}
      {{-- injection information form --}}
        <div class="row">
          <div class="col-xl-12 col-lg-12">
            <div class="table-responsive">
              <table id="medicine_order" class="table table-striped table-bordered medicine_order">
                <thead>
                  <tr class="text-center">
                    <th>{{ trans('cruds.order.fields.medicine') }}</th>
                    <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.unit') }}</th>
                    <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.strength') }}</th>
                    <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.qty') }}</th>
                    <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.price') }}</th>
                    <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.total') }}</th>
                    <th>{{ trans('cruds.orderDetail.fields.how_to_use') }}</th>
                    <th style="width: 70px;">
                      <div class="form-group">
                        <button id="injection_add_more" type="button" class="btn btn-sm btn-success">Add</button>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody id="injection_detail">
                  <tr id="no-delete">
                    <td>
                      <div class="form-group">
                        <select data-id="1" id="injection_product" name="injection_product[]" class="form-control order_product order_detail"  style="width: 100%" data-placeholder="Select Medecine">
                          <option value="">{{ trans('global.select') }} {{ trans('cruds.order.fields.medicine') }}</option>
                          @foreach ($products as $key => $row)
                            <option value="{{ $row->id }}">{{ $row->p_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input data-id="1" id="injection_unit" name="injection_unit[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.unit') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input data-id="1" id="injection_strength" name="injection_strength[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.strength') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input data-id="1" id="injection_qty" name="injection_qty[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.qty') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input data-id="1" id="injection_price" name="injection_price[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.price') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input data-id="1" id="injection_total" name="injection_total[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.total') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input data-id="1" id="injection_how_to_use" name="injection_how_to_use[]" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.how_to_use') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <button type="button" class="btn btn-sm btn-danger injection_btn_remove">Remove</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      {{-- end injection information form --}}
    </div>
  </form>
</div>
