<div class="modal fade" id="showRxNurseModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-center modal-xl">
    <div class="modal-content">
      <form id="frmAddNewRxNurse" action="{{ route('admin.'.$crudRoutePath.'.frmAddNewRxNurse') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="document_id" id="document_id">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Rx Form</h5>
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
                      <input readonly id="rx_name" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
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
                      <input readonly id="rx_age" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
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
                      <input readonly id="rx_sex" sex="sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="customer_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
                    <div class="col-lg-8">
                      <input readonly id="rx_customer_id" name="customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
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
                      <input readonly id="rx_phone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
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
                      <input readonly id="rx_document_id" name="document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
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
                      <input readonly id="rx_address" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- end customer information --}}
          <div class="card border">
            <div class="card-body" id="nurse_detail">
            </div>
          </div>
          <div class="card-border">
            <div class="card-bordy">
              <div class="card-header bg-secondary text-white">
                <h3>Rx Detail Form</h3>
              </div>
              <div class="card-body" id="nurse_form">

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

@push('modal')
  <script>
    $('body').on('click','a#objectRxNurse',function(e){
      e.preventDefault();
      $('#showRxNurseModal').find('#rx_name').val($('#rx_bio_name').val());
      $('#showRxNurseModal').find('#rx_age').val($('#rx_bio_age').val());
      $('#showRxNurseModal').find('#rx_sex').val($('#rx_bio_sex').val());
      $('#showRxNurseModal').find('#rx_phone_no').val($('#rx_bio_phone_no').val());
      $('#showRxNurseModal').find('#rx_address').val($('#rx_bio_address').val());
      $('#showRxNurseModal').find('#rx_customer_id').val($('#rx_bio_customer_id').val());
      $('#showRxNurseModal').find('#rx_document_id').val($('#rx_bio_document_id').val());
      $.get(`{{ route('admin.documents.getNurseDetail') }}`, function (res) {
        $('#showRxNurseModal').find('#nurse_detail').empty().append(res.rx_nurses);
      });
      $('#showRxNurseModal').modal('show');
    });
  </script>
@endpush
