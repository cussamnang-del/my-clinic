<div class="modal fade" id="showRxModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-center modal-xl">
    <div class="modal-content">
      <form id="frmAddNewRx" action="{{ route('admin.'.$crudRoutePath.'.storeRx') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="document_id" id="document_id">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Rx Doctor Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- customer information --}}
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="name" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.name') }}:</strong> </label>
                      <div class="col-lg-10">
                        <input readonly id="prx_name" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
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
                        <input readonly id="prx_age" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
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
                        <input readonly id="prx_sex" sex="sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-2">
                    <div class="row">
                      <label for="customer_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
                      <div class="col-lg-8">
                        <input readonly id="prx_customer_id" name="customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
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
                        <input readonly id="prx_phone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
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
                        <input readonly id="prx_document_id" name="document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
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
                        <input readonly id="prx_address" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          {{-- end customer information --}}
          {{-- add doctor description --}}
            <div class="card border">
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-7 col-lg-7">
                    <div class="form-group mb-2">
                      <div class="row">
                        <label for="doctor_order_name" class="form-control-label mb-2 col-lg-3"><strong>{{ trans('cruds.rx.fields.doctor_order') }}:</strong> </label>
                        <div class="col-lg-8">
                          <input id="doctor_order_name" name="doctor_order_name" class="form-control doctor_order_name" type="text" placeholder="{{ trans('cruds.rx.fields.doctor_order') }}">
                        </div>
                        <div class="col-lg-1">
                          <button id="addDescription" class="btn btn-sm btn-outline-secondary">{{ trans('global.add') }}</button>
                        </div>
                        <span class="text-danger error-text name_error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-5 col-lg-5">
                    <div class="form-group">
                      <div class="row">
                        <label for="rx_date" class="form-control-label mb-2 col-lg-3"><strong>{{ trans('cruds.rx.fields.rx_date') }}:</strong> </label>
                        <div class="col-lg-9">
                          <input id="rx_date" name="rx_date" class="form-control" type="text" placeholder="{{ trans('cruds.rx.fields.rx_date') }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          {{-- add doctor description --}}
          <div class="card border">
            <div class="card-body" id="rx_detail">
            </div>
          </div>
          <div class="card border">
            <div class="card-body" id="doctorDescription">

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

@push('modal')
  <script>
    $('body').on('click','a#objectRx',function(e){
      e.preventDefault();
      $('#showRxModal').find('#prx_name').val($('#rx_bio_name').val());
      $('#showRxModal').find('#prx_age').val($('#rx_bio_age').val());
      $('#showRxModal').find('#prx_sex').val($('#rx_bio_sex').val());
      $('#showRxModal').find('#prx_phone_no').val($('#rx_bio_phone_no').val());
      $('#showRxModal').find('#prx_address').val($('#rx_bio_address').val());
      $('#showRxModal').find('#prx_customer_id').val($('#rx_bio_customer_id').val());
      $('#showRxModal').find('#prx_document_id').val($('#rx_bio_document_id').val());
      var rx_customerId = $('#rx_bio_customer_id').val();
      var rx_documentId = $('#rx_bio_document_id').val();
      $.ajax({
        type : 'get',
        dataType: 'JSON',
        url: '{{ route("admin.documents.getRxDetail") }}',
        data: {
          'customer_id' : rx_customerId,
          'rx_document_id' : rx_documentId,
        },
        success: function (res) {
          $('#showRxModal').find('#doctorDescription').empty().append(res.doctor_descriptions);
          $('#showRxModal').find('#rx_detail').empty().append(res.rx_details);
        },
        error: function (error) {
          console.log('Error:', error);
          $('#btnObjectSave').html(`{{ trans('global.save') }}`);
          $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
        }
      });
      $('#showRxModal').find('#rx_date').val(today);
      $('#showRxModal').modal('show');
    });

  </script>
@endpush
