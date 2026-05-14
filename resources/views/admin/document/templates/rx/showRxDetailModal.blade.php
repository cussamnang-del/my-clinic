<div class="modal fade" id="showRxDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">Rx Detail Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- customer information --}}
          <div class="col-lg-12">
            <div class="row">
              <div class="col-xl-3 col-lg-3">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="name" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.name') }}:</strong> </label>
                    <div class="col-lg-10">
                      <input readonly id="rxd_name" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="rxd_customer_code" class="form-control-label mb-2 col-lg-3"><strong>{{ trans('cruds.customer.fields.customer_code') }}:</strong> </label>
                    <div class="col-lg-9">
                      <input readonly id="customer_code" name="customer_code" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.customer_code') }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-3">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="age" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.age') }}:</strong> </label>
                    <div class="col-lg-10">
                      <input readonly id="rxd_age" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
                    </div>
                  </div>
                  <span class="text-danger error-text age_error"></span>
                </div>
              </div>
              <div class="col-xl-2 col-lg-2">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="sex" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.sex') }}:</strong> </label>
                    <div class="col-lg-10">
                      <input readonly id="rxd_sex" sex="sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-2 col-lg-2">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="customer_id" class="form-control-label mb-2 col-lg-5"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
                    <div class="col-lg-7">
                      <input readonly id="rxd_customer_id" name="customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-lg-2">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="document_id" class="form-control-label mb-2 col-lg-5"><strong>{{ trans('cruds.document.title_singular') }} {{ trans('cruds.document.fields.id') }}:</strong> </label>
                    <div class="col-lg-7">
                      <input readonly id="rxd_document_id" name="document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-3">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="phone_no" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.phone_no') }}:</strong> </label>
                    <div class="col-lg-10">
                      <input readonly id="rxd_phone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
                    </div>
                  </div>
                  <span class="text-danger error-text phone_no_error"></span>
                </div>
              </div>
              <div class="col-xl-5 col-lg-5">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="address" class="form-control-label mb-2 col-lg-1"><strong>{{ trans('cruds.document.fields.address') }}:</strong> </label>
                    <div class="col-lg-11">
                      <input readonly id="rxd_address" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- end customer information --}}
          <div class="card border">
            <div class="card-body" id="show_rx_detail">
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

@push('modal')
  <script>
    $('body').on('click','a#showRxDetail',function(e){
      e.preventDefault();
      $('#showRxDetailModal').find('#rxd_name').val($('#rx_bio_name').val());
      $('#showRxDetailModal').find('#rxd_customer_code').val($('#rx_bio_customer_code').val());
      $('#showRxDetailModal').find('#rxd_age').val($('#rx_bio_age').val());
      $('#showRxDetailModal').find('#rxd_sex').val($('#rx_bio_sex').val());
      $('#showRxDetailModal').find('#rxd_phone_no').val($('#rx_bio_phone_no').val());
      $('#showRxDetailModal').find('#rxd_address').val($('#rx_bio_address').val());
      $('#showRxDetailModal').find('#rxd_customer_id').val($('#rx_bio_customer_id').val());
      $('#showRxDetailModal').find('#rxd_document_id').val($('#rx_bio_document_id').val());
      var rxId = $(this).data('id');
      var rx_customerId = $(this).data('customer_id');
      var rx_documentId = $(this).data('document_id');
      $.ajax({
        type : 'get',
        dataType: 'JSON',
        url: '{{ route("admin.documents.showtRxDetail") }}',
        data: {
          'rx_id' : rxId,
          'customer_id' : rx_customerId,
          'document_id' : rx_documentId,
        },
        success: function (res) {
          $('#showRxDetailModal').find('#show_rx_detail').empty().append(res.show_rx_detail);
        },
        error: function (error) {
          console.log('Error:', error);
          $('#btnObjectSave').html(`{{ trans('global.save') }}`);
          $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
        }
      });
      $('#showRxDetailModal').modal('show');
    });
    $('body').on('click','a#editRxDetail',function(e){
      e.preventDefault();
      $('#editRxNurseModal').find('#rxde_name').val($('#rx_bio_name').val());
      $('#editRxNurseModal').find('#rxde_age').val($('#rx_bio_age').val());
      $('#editRxNurseModal').find('#rxde_sex').val($('#rx_bio_sex').val());
      $('#editRxNurseModal').find('#rxde_phone_no').val($('#rx_bio_phone_no').val());
      $('#editRxNurseModal').find('#rxde_address').val($('#rx_bio_address').val());
      $('#editRxNurseModal').find('#rxde_customer_id').val($('#rx_bio_customer_id').val());
      $('#editRxNurseModal').find('#rxde_document_id').val($('#rx_bio_document_id').val());
      var rxId = $(this).data('id');
      var rx_customerId = $(this).data('customer_id');
      var rx_documentId = $(this).data('document_id');
      $.ajax({
        type : 'get',
        dataType: 'JSON',
        url: '{{ route("admin.documents.editRxDetail") }}',
        data: {
          'rx_id' : rxId,
          'customer_id' : rx_customerId,
          'document_id' : rx_documentId,
        },
        success: function (res) {
          $('#editRxNurseModal').find('#doctorDescription').empty().append(res.nurse_form);
        },
        error: function (error) {
          console.log('Error:', error);
          $('#btnObjectSave').html(`{{ trans('global.save') }}`);
          $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
        }
      });
      $('#editRxNurseModal').modal('show');
    });
  </script>
@endpush
