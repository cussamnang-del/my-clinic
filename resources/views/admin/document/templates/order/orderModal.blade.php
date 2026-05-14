<div class="modal fade" id="orderObjectModal" tabindex="-1"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    aria-labelledby="orderObjectModal">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">{{ trans('cruds.customer.title_singular') }}​​ {{ trans('global.prescription') }}</h5>
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
                    <label for="order_name" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.name') }}:</strong> </label>
                    <div class="col-lg-10">
                      <input readonly id="order_name" name="order_name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="order_age" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.age') }}:</strong> </label>
                    <div class="col-lg-10">
                      <input readonly id="order_age" name="order_age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="order_sex" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.sex') }}:</strong> </label>
                    <div class="col-lg-10">
                      <input readonly id="order_sex" name="order_sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="order_customer_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
                    <div class="col-lg-8">
                      <input readonly id="order_customer_id" name="order_customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="order_phone_no" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.phone_no') }}:</strong> </label>
                    <div class="col-lg-10">
                      <input readonly id="order_phone_no" name="order_phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="order_document_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.document.title_singular') }} {{ trans('cruds.document.fields.id') }}:</strong> </label>
                    <div class="col-lg-8">
                      <input readonly id="order_document_id" name="order_document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="order_address" class="form-control-label mb-2 col-lg-1"><strong>{{ trans('cruds.document.fields.address') }}:</strong> </label>
                    <div class="col-lg-11">
                      <input readonly id="order_address" name="order_address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
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
        {{-- end customer information --}}
        {{-- order information --}}
        <div class="card border mt-2">
          <div class="card-body">
            <ul class="nav nav-tabs nav-primary" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" href="#medicine" role="tab" aria-selected="true">
                  <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                    </div>
                    <div class="tab-title">{{ trans('cruds.order.fields.medicine') }}</div>
                  </div>
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#injection" role="tab" aria-selected="false">
                  <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                    </div>
                    <div class="tab-title">{{ trans('cruds.order.fields.injection') }}</div>
                  </div>
                </a>
              </li>
            </ul>
            <div class="tab-content py-3">
              <div class="tab-pane fade show active" id="medicine" role="tabpanel">
                <form id="frmOrder" action="{{ route('admin.'.$crudRoutePath.'.storeObjectOrder') }}" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" name="medicine_customer_id" id="medicine_customer_id">
                  <input type="hidden" name="medicine_document_id" id="medicine_document_id">
                  <input type="hidden" name="order_id" id="order_id" value="">
                  {{-- order information --}}
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group mb-2">
                          <label for="chief_complain" class="form-control-label mb-2">{{ trans('cruds.order.fields.chief_complain') }}:</label>
                          <textarea id="chief_complain" name="chief_complain" class="form-control"  placeholder="{{ trans('cruds.order.fields.chief_complain') }}" cols="100" rows="2"></textarea>
                          <span class="text-danger error-text chief_complain_error"></span>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group mb-2">
                          <label for="past_history" class="form-control-label mb-2">{{ trans('cruds.order.fields.past_history') }}:</label>
                          <textarea id="past_history" name="past_history" class="form-control" placeholder="{{ trans('cruds.order.fields.past_history') }}" cols="100" rows="2"></textarea>
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
                          {{-- <input id="diagnosis" name="diagnosis" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.diagnosis') }}"> --}}
                          <textarea id="diagnosis" name="diagnosis" class="form-control" type="text" placeholder="{{ trans('cruds.order.fields.diagnosis') }}" cols="100" rows="3"></textarea>
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
                                <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.qty') }}</th>
                                <th style="width: 140px;">{{ trans('cruds.orderDetail.fields.unit') }}</th>
                                <th style="width: 150px;">{{ trans('cruds.orderDetail.fields.strength') }}</th>
                                <th>{{ trans('cruds.orderDetail.fields.how_to_use') }}</th>
                                <th style="width: 140px;">{{ trans('cruds.orderDetail.fields.before_after') }}</th>
                                <th style="width: 90px;">
                                </th>
                              </tr>
                            </thead>
                            <tbody id="object_order_detail">
                              <tr id="no-delete" class="mb-0">
                                <td>
                                  <div class="form-group">
                                      <input type="text" data-id="order_product_1" data-type="p_name" id="order_product_1" name="order_product"  class="order_product form-control autocomplete_order_product" placeholder="{{ trans('cruds.order.fields.medicine') }}" autocomplete="off">
                                    <input type="hidden" name="order_product_id" data-id="order_product_id_1" id="order_product_id_1">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group mb-2">
                                    <input data-id="qty_1" id="qty_1" name="qty" class="form-control order_detail canenter" type="text" placeholder="{{ trans('cruds.orderDetail.fields.qty') }}" autocomplete="off">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group mb-2">
                                    <input data-id="unit_1" id="unit_1" name="unit" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.unit') }}" autocomplete="off">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group mb-2">
                                    <input data-id="strength_1" id="strength_1" name="strength" class="form-control order_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.strength') }}" autocomplete="off">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group mb-2">
                                    <input list="how_to_uses" data-id="how_to_use_1" id="how_to_use_1" name="how_to_use"  class="how_to_use form-control" placeholder="{{ trans('cruds.orderDetail.fields.how_to_use') }}" autocomplete="off">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group mb-2">
                                    <select data-id="before_after_1" id="before_after_1" name="before_after" class="form-select form-select-md mb-3 before_after">
                                      <option value="មុនបាយ" >មុនបាយ</option>
                                      <option value="ក្រោយបាយ">ក្រោយបាយ</option>
                                    </select>
                                  </div>
                                </td>
                                <td>
                                  {{-- <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-danger btn_remove_medicine">Remove</button>
                                  </div> --}}
                                  <div class="form-group">
                                    <button id="add_more_medicine" type="button" class="btn btn-sm btn-success add_more_medicine">Add</button>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xl-12 col-lg-12">
                        <div class="table-responsive">
                          <table id="medicine_order_save" class="table table-striped table-bordered medicine_order">
                            <tbody id="object_order_detail_save">
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  {{-- end medicine information form --}}
                  <div class="float-end">
                    @include('admin.templates.button')
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="injection" role="tabpanel">
                <form id="frmInjection" action="{{ route('admin.'.$crudRoutePath.'.storeObjectInjection') }}" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" name="injection_customer_id" id="injection_customer_id">
                  <input type="hidden" name="injection_document_id" id="injection_document_id">
                  <input type="hidden" name="injection_id" id="injection_id" value="">
                  {{-- injection information form --}}
                    <div class="row">
                      <div class="col-xl-12 col-lg-12">
                        <div class="table-responsive">
                          <table id="injection_order" class="table table-striped table-bordered medicine_order">
                            <thead>
                              <tr class="text-center">
                                <th>{{ trans('cruds.order.fields.medicine') }}</th>
                                <th style="width: 100px;">{{ trans('cruds.orderDetail.fields.qty') }}</th>
                                <th style="width: 130px;">{{ trans('cruds.orderDetail.fields.unit') }}</th>
                                <th style="width: 150px;">{{ trans('cruds.orderDetail.fields.strength') }}</th>
                                <th>{{ trans('cruds.orderDetail.fields.how_to_use') }}</th>
                                <th style="width: 140px;">{{ trans('cruds.orderDetail.fields.before_after') }}</th>
                                <th style="width: 90px;">
                                </th>
                              </tr>
                            </thead>
                            <tbody id="object_injection_detail">
                              <tr id="no-delete" class="mb-0">
                                <td>
                                  <div class="form-group">
                                    <input type="text" data-id="injection_product_1" data-type="p_name" id="injection_product_1" name="injection_product"  class="injection_product form-control autocomplete_injection_product" placeholder="{{ trans('cruds.order.fields.medicine') }}" autocomplete="off">
                                    <input type="hidden" name="injection_product_id" data-id="injection_product_id_1" id="injection_product_id_1">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group mb-2">
                                    <input data-id="qty_1" id="injection_qty_1" name="injection_qty" class="form-control injection_detail canenter" type="text" placeholder="{{ trans('cruds.orderDetail.fields.qty') }}" autocomplete="off">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group mb-2">
                                    <input data-id="injection_unit_1" id="injection_unit_1" name="injection_unit" class="form-control injection_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.unit') }}" autocomplete="off">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group mb-2">
                                    <input data-id="injection_strength_1" id="injection_strength_1" name="injection_strength" class="form-control injection_detail" type="text" placeholder="{{ trans('cruds.orderDetail.fields.strength') }}" autocomplete="off">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group mb-2">
                                    <input list="how_to_uses" data-id="how_to_use_1" id="injection_how_to_use_1" name="injection_how_to_use"  class="how_to_use form-control" placeholder="{{ trans('cruds.orderDetail.fields.how_to_use') }}" autocomplete="off">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group mb-2">
                                    <select data-id="before_after_1" id="injection_before_after_1" name="injection_before_after" class="form-select form-select-md mb-3 before_after">
                                      <option value="មុនបាយ" >មុនបាយ</option>
                                      <option value="ក្រោយបាយ">ក្រោយបាយ</option>
                                    </select>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <button id="injection_add_more" type="button" class="btn btn-sm btn-success injection_add_more">Add</button>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xl-12 col-lg-12">
                        <div class="table-responsive">
                          <table id="injection_order_save" class="table table-striped table-bordered injection_order">
                            <tbody id="object_injection_detail_save">
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  {{-- end injection information form --}}
                  <div class="float-end">
                    @include('admin.templates.button')
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        {{-- end order information --}}
      </div>
    </div>
  </div>
</div>

@push('modal')
  {{-- add or remove doctor give medicine table --}}
  <script>
    $(document).ready(function(){
      var product_id;
      var rowcount =$('#object_order_detail_save tr').length+1;
      $(document).on('click','#add_more_medicine',function(e){
        e.preventDefault();
        //debugger;
        product_id =  $('#order_product_id_1').val();
        var product_code = "p-"+Math.floor(10000000 + Math.random() * 90000000);
        var product_name = $('#order_product_1').val();
        var product_unit = $('#unit_1').val();
        var product_strength = $('#strength_1').val();
        var product_qty = $('#qty_1').val();
        var product_how_to_use = $('#how_to_use_1').val();
        var product_before_after = $('#before_after_1').val();
        var actionUrl = "{{ route('admin.products.storeNew') }}";
        if(!product_id){
          $.post(actionUrl,{
            p_name : product_name,
            p_code : product_code,
            unit : product_unit,
            strength : product_strength,
            group_id:1 ,
            type_id : 1 ,
            country : "",
            description : "",
            status : 1,
          },function(res){
            product_id = res.data.id;
          });
        } else {
          console.log(product_id);
        }
        var $fieldMedicine = $(`
          <tr id="no-delete" class="mb-0">
            <td>
              <div class="form-group">
                <input type="hidden" name="idUpdate[]" id="idUpdate">
                <input readonly value="${product_name}" type="text" id="order_product_show" name="order_product_show[]"  class="form-control" autocomplete="off">
                <input readonly value="${product_id}" type="hidden" id="order_product_save" name="order_product_save[]"  class="form-control" autocomplete="off">
              </div>
            </td>
            <td style="width: 100px;">
              <div class="form-group mb-2">
                <input value="${product_qty}" id="qty_save" name="qty_save[]" class="form-control canenter" type="text" autocomplete="off">
              </div>
            </td>
            <td style="width: 150px;">
              <div class="form-group mb-2">
                <input readonly value="${product_unit}" id="unit_save" name="unit_save[]" class="form-control" type="text" autocomplete="off">
              </div>
            </td>
            <td style="width: 200px;">
              <div class="form-group mb-2">
                <input readonly value="${product_strength}" id="strength_save" name="strength_save[]" class="form-control" type="text" autocomplete="off">
              </div>
            </td>
            <td>
              <div class="form-group mb-2">
                <input value="${product_how_to_use}" id="how_to_use_save" name="how_to_use_save[]"  class="form-control" autocomplete="off">
              </div>
            </td>
            <td style="width: 135px;">
              <div class="form-group mb-2">
                <select id="before_after_save" name="before_after_save[]" class="form-select form-select-md mb-3">
                  <option value="មុនបាយ" ${product_before_after=='មុនបាយ'?'selected':''}>មុនបាយ</option>
                  <option value="ក្រោយបាយ" ${product_before_after=='ក្រោយបាយ'?'selected':''}>ក្រោយបាយ</option>
                </select>
              </div>
            </td>
            <td style="width: 75px;">
              <div class="form-group">
                <button data-id="" type="button" class="btn btn-sm btn-danger btn_remove_medicine">Remove</button>
              </div>
            </td>
          </tr>
        `);
        var $clone = $fieldMedicine.clone();
        $('#object_order_detail_save').append($clone);
        rowcount++;
        $('#order_product_id_1').val('');
        $('#order_product_1').val('');
        $('#qty_1').val('');
        $('#unit_1').val('');
        $('#strength_1').val('');
        $('#how_to_use_1').val('');
        $('#order_product_1').focus();
      });
      $(document).on('click','.btn_remove_medicine',function(e){
        e.preventDefault();
        var removeId = $(this).data('id');
        if(removeId == null || removeId==''){
          $(this).closest('tr').remove();
        } else{
          var link = "{{ route('admin.documents.removeOrder') }}";
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
              $.ajax({
                type: "POST",
                url:link,
                data:{order_id:removeId},
                success: function (data) {
                  // console.log(data)
                  $(this).closest('tr').remove();
                  toastr.success(data.success);
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });
            }
          });
        }
        rowcount--;
        return false;
      })
    });
  </script>
  {{-- add or remove doctor give injection table --}}
  <script>
    $(document).ready(function(){
      var product_id;
      var rowcount =$('#object_injection_detail_save tr').length+1;
      $(document).on('click','#injection_add_more',function(e){
        e.preventDefault();
        //debugger;
        product_id =  $('#injection_product_id_1').val();
        var product_code = "p-"+Math.floor(10000000 + Math.random() * 90000000);
        var product_name = $('#injection_product_1').val();
        var product_unit = $('#injection_unit_1').val();
        var product_strength = $('#injection_strength_1').val();
        var product_qty = $('#injection_qty_1').val();
        var product_how_to_use = $('#injection_how_to_use_1').val();
        var product_before_after = $('#injection_before_after_1').val();
        var actionUrl = "{{ route('admin.products.storeNew') }}";
        if(!product_id){
          $.post(actionUrl,{
            p_name : product_name,
            p_code : product_code,
            unit : product_unit,
            strength : product_strength,
            group_id:1 ,
            type_id : 1 ,
            country : "",
            description : "",
            status : 1,
          },function(res){
            product_id = res.data.id;
          });
        }
        var $fieldInjection = $(`
          <tr>
            <td>
              <div class="form-group">
                <input type="hidden" name="id_Injection_Update[]" id="id_Injection_Update">
                <input readonly value="${product_name}" id="injection_product_show" name="injection_product_show[]" class="form-control canenter" type="text" placeholder="{{ trans('cruds.order.fields.medicine') }}">
                <input readonly value="${product_id}" type="hidden" name="injection_product_save[]" id="injection_product_save">
              </div>
            </td>
            <td style="width: 100px;">
              <div class="form-group">
                <input value="${product_qty}" id="injection_qty_save" name="injection_qty_save[]" class="form-control canenter" type="text" placeholder="{{ trans('cruds.orderDetail.fields.qty') }}" autocomplete="off">
              </div>
            </td>
            <td style="width: 130px;">
              <div class="form-group">
                <input readonly value="${product_unit}" id="injection_unit_save" name="injection_unit_save[]" class="form-control" type="text" placeholder="{{ trans('cruds.orderDetail.fields.unit') }}" autocomplete="off">
              </div>
            </td>
            <td style="width: 150px;">
              <div class="form-group">
                <input readonly value="${product_strength}" id="injection_strength_save" name="injection_strength_save[]" class="form-control" type="text" placeholder="{{ trans('cruds.orderDetail.fields.strength') }}" autocomplete="off">
              </div>
            </td>
            <td>
              <div class="form-group mb-2">
                <input value="${product_how_to_use}" type="text" id="injection_how_to_use_save" name="injection_how_to_use_save[]"  class=" form-control" placeholder="{{ trans('cruds.orderDetail.fields.how_to_use') }}" autocomplete="off">
              </div>
            </td>
            <td style="width: 140px;">
              <div class="form-group mb-2">
                <select id="injection_before_after_save" name="injection_before_after_save[]" class="form-select form-select-md mb-3 before_after">
                  <option value="មុនបាយ" ${product_before_after=='មុនបាយ'?'selected':''}>មុនបាយ</option>
                  <option value="ក្រោយបាយ" ${product_before_after=='ក្រោយបាយ'?'selected':''}>ក្រោយបាយ</option>
                </select>
              </div>
            </td>
            <td style="width: 90px;">
              <div class="form-group">
                <button type="button" class="btn btn-sm btn-danger injection_btn_remove">Remove</button>
              </div>
            </td>
          </tr>
        `);
        var $clone = $fieldInjection.clone();
        $('#object_injection_detail').append($clone);
        rowcount++;
        $('#injection_product_1').val('');
        $('#injection_unit_1').val('');
        $('#injection_strength_1').val('');
        $('#injection_qty_1').val('');
        $('#injection_how_to_use_1').val('');
        $('#injection_product_1').focus();
        // $clone.find('.order_product').select2({
        //     dropdownParent: $('#orderObjectModal'),
        //     theme: 'bootstrap4',
        //     width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        //     placeholder: $(this).data('placeholder'),
        //     allowClear: Boolean($(this).data('allow-clear')),
        // });
      });
      $('body tbody').on('click','.injection_btn_remove',function(e){
        e.preventDefault();
        var removeId = $(this).data('id');
        if(removeId == null || removeId==''){
          $(this).closest('tr').remove();
        } else{
          var link = "{{ route('admin.documents.removeInjection') }}";
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
              $.ajax({
                type: "POST",
                url:link,
                data:{injection_id:removeId},
                success: function (data) {
                  // console.log(data)
                  $(this).closest('tr').remove();
                  toastr.success(data.success);
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });
            }
          });
        }
        rowcount--;
        return false;
      })
    });
  </script>

  <script>
    $('body').on('click','a#objectOrder',function(e){
      e.preventDefault();
      var modal = $('#orderObjectModal');
      //Reset form
      modal.find('form')[0].reset();
      // modal.find(`input`).val('');
      modal.find(`select`).val(0).trigger('change');
      modal.find(`#order_detail>tr:not(#no-delete)`).remove();
      modal.find('#order_name').val($('#rx_bio_name').val());
      modal.find('#order_age').val($('#rx_bio_age').val());
      modal.find('#order_sex').val($('#rx_bio_sex').val());
      modal.find('#order_phone_no').val($('#rx_bio_phone_no').val());
      modal.find('#order_address').val($('#rx_bio_address').val());
      modal.find('#order_customer_id').val($('#rx_bio_customer_id').val());
      modal.find('#order_document_id').val($('#rx_bio_document_id').val());
      modal.find('#before_after_1').val('មុនបាយ').trigger('change');
      modal.find('#injection_before_after_1').val('មុនបាយ').trigger('change');
      $('#frmOrder').find('#medicine_customer_id').val($('#rx_bio_customer_id').val());
      $('#frmOrder').find('#medicine_document_id').val($('#rx_bio_document_id').val());
      $('#frmInjection').find('#injection_customer_id').val($('#rx_bio_customer_id').val());
      $('#frmInjection').find('#injection_document_id').val($('#rx_bio_document_id').val());
      var order_customerId = $('#rx_bio_customer_id').val();
      var order_documentId = $('#rx_bio_document_id').val();
      $.ajax({
        type : 'get',
        dataType: 'JSON',
        url: '{{ route("admin.documents.getObjectH") }}',
        data: {
          'customer_id' : order_customerId,
          'document_id' : order_documentId,
        },
        success: function (res) {
          console.log(res)
          modal.find('#typeA').empty().append(res.typeA);
          modal.find('#typeB').empty().append(res.typeB);
          modal.find('#order_id').val(res.order_id);
          modal.find('#injection_id').val(res.injection_id);
          if(res.customer_order.length!=0){
            modal.find('#chief_complain').val(res.customer_order.chief_complain??null)
            modal.find('#past_history').val(res.customer_order.past_history??null)
            modal.find('#blood_test').val(res.customer_order.blood_test??null)
            modal.find('#orl_ent').val(res.customer_order.orl_ent??null)
            modal.find('#ultra_sound').val(res.customer_order.ultra_sound??null)
            modal.find('#ecg').val(res.customer_order.ecg??null)
            modal.find('#x_ray').val(res.customer_order.x_ray??null)
            modal.find('#et_at').val(res.customer_order.et_at??null)
            modal.find('#diagnosis').val(res.customer_order.diagnosis??null)
            modal.find('#recommendation').val(res.customer_order.recommendation??null)
          }
          if(res.customer_order_details.length!=0){
            $.each(res.customer_order_details,function(i,e){
              var $fieldMedicine = $(`
                <tr id="no-delete" class="mb-0">
                  <td>
                    <div class="form-group">
                      <input type="hidden" name="idUpdate[]" id="idUpdate" value="${e.id}">
                      <input readonly value="${e.product.p_name}" type="text" id="order_product_show_${e.id}" name="order_product_show[]"  class="form-control" autocomplete="off">
                      <input readonly value="${e.product_id}" type="hidden" id="order_product_save_${e.id}" name="order_product_save[]"  class="form-control" autocomplete="off">
                    </div>
                  </td>
                  <td style="width: 100px;">
                    <div class="form-group mb-2">
                      <input value="${e.qty}" id="qty_save_${e.id}" name="qty_save[]" class="form-control canenter" type="text" autocomplete="off">
                    </div>
                  </td>
                  <td style="width: 140px;">
                    <div class="form-group mb-2">
                      <input readonly value="${e.unit}" id="unit_save_${e.id}" name="unit_save[]" class="form-control" type="text" autocomplete="off">
                    </div>
                  </td>
                  <td style="width: 150px;">
                    <div class="form-group mb-2">
                      <input readonly value="${e.strength}" id="strength_save_${e.id}" name="strength_save[]" class="form-control" type="text" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group mb-2">
                      <input value="${e.how_to_use}" id="how_to_use_save_${e.id}" name="how_to_use_save[]"  class="form-control" autocomplete="off">
                    </div>
                  </td>
                  <td style="width: 140px;">
                    <div class="form-group mb-2">
                      <select id="before_after_save_${e.id}" name="before_after_save[]" class="form-select form-select-md mb-3 before_after">
                        <option value="មុនបាយ" ${e.before_after=='មុនបាយ'?'selected':''}>មុនបាយ</option>
                        <option value="ក្រោយបាយ"  ${e.before_after=='ក្រោយបាយ'?'selected':''}>ក្រោយបាយ</option>
                      </select>
                    </div>
                  </td>
                  <td style="width: 90px;">
                    <div class="form-group">
                      <button data-id="${e.id}" type="button" class="btn btn-sm btn-danger btn_remove_medicine">Remove</button>
                    </div>
                  </td>
                </tr>
              `);
              $('#object_order_detail_save').append($fieldMedicine);
            });
          }
          if(res.customer_injection_details.length!=0){
            $.each(res.customer_injection_details,function(i,e){
              var $fieldInjection = $(`
                <tr id="no-delete" class="mb-0">
                  <td>
                    <div class="form-group">
                      <input type="hidden" name="id_Injection_Update[]" id="id_Injection_Update_${e.id}" value="${e.id}">
                      <input readonly value="${e.product.p_name}" type="text" id="injection_product_show_${e.id}" name="injection_product_show[]"  class="form-control" autocomplete="off">
                      <input readonly value="${e.product_id}" type="hidden" id="injection_product_save_${e.id}" name="injection_product_save[]"  class="form-control" autocomplete="off">
                    </div>
                  </td>
                  <td style="width: 100px;">
                    <div class="form-group mb-2">
                      <input value="${e.qty}" id="injection_qty_save_${e.id}" name="injection_qty_save[]" class="form-control canenter" type="text" autocomplete="off">
                    </div>
                  </td>
                  <td style="width: 130px;">
                    <div class="form-group mb-2">
                      <input readonly value="${e.unit}" id="injection_unit_save_${e.id}" name="injection_unit_save[]" class="form-control" type="text" autocomplete="off">
                    </div>
                  </td>
                  <td style="width: 150px;">
                    <div class="form-group mb-2">
                      <input readonly value="${e.strength}" id="injection_strength_save_${e.id}" name="injection_strength_save[]" class="form-control" type="text" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group mb-2">
                      <input value="${e.how_to_use}" id="injection_how_to_use_save_${e.id}" name="injection_how_to_use_save[]"  class="form-control" autocomplete="off">
                    </div>
                  </td>
                  <td style="width: 140px;">
                    <div class="form-group mb-2">
                      <select id="injection_before_after_save_${e.id}" name="injection_before_after_save[]" class="form-select form-select-md mb-3 before_after">
                        <option value="មុនបាយ" ${e.before_after=='មុនបាយ'?'selected':''}>មុនបាយ</option>
                        <option value="ក្រោយបាយ"  ${e.before_after=='ក្រោយបាយ'?'selected':''}>ក្រោយបាយ</option>
                      </select>
                    </div>
                  </td>
                  <td style="width: 90px;">
                    <div class="form-group">
                      <button data-id="${e.id}" type="button" class="btn btn-sm btn-danger injection_btn_remove">Remove</button>
                    </div>
                  </td>
                </tr>
              `);
              $('#object_injection_detail_save').append($fieldInjection);
            });
          }
        },
        error: function (error) {
          console.log('Error:', error);
          $('#btnObjectSave').html(`{{ trans('global.save')}}`);
          $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
        }
      });
      modal.modal('show');
    });

    $('#frmOrder').on('submit',function(e){
      e.preventDefault();
      var actionUrl = $(this).attr('action');
      var method = $(this).attr('method')
      var modal = $('#orderObjectModal');
      $('#btnObjectSave').html('Processing..');
      $('#btnObjectUpdate').html('Processing..');
      $.ajax({
        type: method,
        url: actionUrl,
        data: new FormData(this),
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend:function(){
          $(document).find('span.error-text').text('');
        },
        success: function (res) {
          console.log(res)
          if(res.status==400){
            $.each(res.error, function(prefix, val){
              $('span.'+prefix+'_error').text(val[0]);
            });
          } else {
            toastr.success(res.success);
            modal.find('#order_id').val('');
            modal.modal('hide');
            // var url = '{{ route("admin.histories.previewReceipt", ":id") }}';
            // url = url.replace(':id', res.data.id);
            // window.open(url,'_blank');
          }
        },
        error: function (error) {
          console.log('Error:', error);
          $('#btnObjectSave').html(`{{ trans('global.save')}}`);
          $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
        }
      });
    });

    $('#frmInjection').on('submit',function(e){
      e.preventDefault();
        var actionUrl = $(this).attr('action');
      var method = $(this).attr('method')
      var modal = $('#orderObjectModal');
      $('#btnObjectSave').html('Processing..');
      $('#btnObjectUpdate').html('Processing..');
      $.ajax({
        type: method,
        url: actionUrl,
        data: new FormData(this),
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend:function(){
          $(document).find('span.error-text').text('');
        },
        success: function (res) {
          console.log(res);
          if(res.status==400){
            $.each(res.error, function(prefix, val){
              $('span.'+prefix+'_error').text(val[0]);
            });
          } else {
          //   modal.find('#print_order_id').val(res.data.id);
            toastr.success(res.success);
            modal.find('#injection_id').val('');
            modal.modal('hide');
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(formatErrorMessage(jqXHR, errorThrown));
          $('#btnObjectSave').html(`{{ trans('global.save')}}`);
          $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
        }
      });
    });
  </script>
@endpush
