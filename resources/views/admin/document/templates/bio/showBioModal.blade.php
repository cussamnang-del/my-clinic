<div class="modal fade" id="showBioModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Laboratory Result</h5>
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
                    <input readonly id="bioname" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="customer_code" class="form-control-label mb-2 col-lg-3"><strong>{{ trans('cruds.customer.fields.customer_code') }}:</strong> </label>
                  <div class="col-lg-9">
                    <input readonly id="biocustomer_code" name="customer_code" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.customer_code') }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="age" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.age') }}:</strong> </label>
                  <div class="col-lg-10">
                    <input readonly id="bioage" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
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
                    <input readonly id="biosex" sex="sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
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
                    <input readonly id="biocustomer_id" name="customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-lg-2">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="document_id" class="form-control-label mb-2 col-lg-5"><strong>{{ trans('cruds.document.title_singular') }} {{ trans('cruds.document.fields.id') }}:</strong> </label>
                  <div class="col-lg-7">
                    <input readonly id="biodocument_id" name="document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="phone_no" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.phone_no') }}:</strong> </label>
                  <div class="col-lg-10">
                    <input readonly id="biophone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
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
                    <input readonly id="bioaddress" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- end customer information --}}
        <div class="row">
          <div class="col-xl-10 col-lg-10 text-center">
            <h2>Laboratory Result</h2>
          </div>
          <div class="col-xl-1 col-lg-1">
            <button id="btnPrintBio" type="button" class="btn btn-sm btn-outline-primary px-3 radius-30" style="float: right;">
              <i class='bx bxs-plus-square'></i>&nbsp;&nbsp;{{ trans('global.print') }}
            </button>
          </div>
          <div class="col-xl-1 col-lg-1">
            <button id="addNewBio" type="button" class="btn btn-sm btn-outline-primary px-3 radius-30" style="float: right;">
              <i class='bx bxs-plus-square'></i>&nbsp;&nbsp;{{ trans('global.check') }}
            </button>
          </div>
        </div>
        <div class="row">
          <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered objectBioList">
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('modal')
  <script>
    $('body').on('click','a#objecBio',function(e){
      e.preventDefault();
      $('#showBioModal').find('#bioname').val($('#rx_bio_name').val());
      $('#showBioModal').find('#biocustomer_code').val($('#rx_bio_customer_code').val());
      $('#showBioModal').find('#bioage').val($('#rx_bio_age').val());
      $('#showBioModal').find('#biosex').val($('#rx_bio_sex').val());
      $('#showBioModal').find('#biophone_no').val($('#rx_bio_phone_no').val());
      $('#showBioModal').find('#bioaddress').val($('#rx_bio_address').val());
      $('#showBioModal').find('#biocustomer_id').val($('#rx_bio_customer_id').val());
      $('#showBioModal').find('#biodocument_id').val($('#rx_bio_document_id').val());
      var rx_customerId = $('#rx_bio_customer_id').val();
      $.ajax({
        type : 'get',
        dataType: 'JSON',
        url: '{{ route("admin.documents.getBio") }}',
        data: {
          'customer_id' : rx_customerId,
        },
        success: function (res) {
          $('#showBioModal').find('.objectBioList').empty().append(res.bio_detail);
        },
        error: function (error) {
          console.log('Error:', error);
        }
      });
      $('#showBioModal').modal('show');
    });

    $('body').on('click','.showAnalystForm',function(e){
      var pbio_id = $(this).data('id');
      var customer_id = $(this).data('customerid');
      $.ajax({
        type : 'get',
        dataType: 'JSON',
        url: '{{ route("admin.documents.getBioAnalystForm") }}',
        data: {
          'pbio_id' : pbio_id,
          'customer_id' : customer_id,
        },
        success: function (res) {
          $('#frmAddNewBio').find('#bio_analyst_form').empty().append(res.pbio_analyst_form);
          $('#bio_date').datetimepicker({
            format: 'DD-MM-YY HH:mm:ss',
            locale: 'en',
            sideBySide: true,
            icons: {
              up: 'bx bx-chevron-up-circle',
              down: 'bx bx-chevron-down-circle',
              previous: 'bx bx-chevron-left-circle',
              next: 'bx bx-chevron-right-circle'
            }
          });
          $('#frmAddNewBio').find('#bio_date').val(today);
        },
        error: function (error) {
          console.log('Error:', error);
          $('#btnObjectSave').html(`{{ trans('global.save') }}`);
          $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
        }
      });
    });

    $('#frmAddNewBio').on('submit',function(e){
      e.preventDefault();
      var actionUrl = $(this).attr('action');
      var method = $(this).attr('method')
      var modal = $('#showBioModal');
      $('#btnObjectSave').html('Processing..');
      $('#btnObjectUpdate').html('Processing..');
      $.ajax({
        type: method,
        url: actionUrl,
        data: new FormData(this),
        dataType: 'json',
        processData:false,
        contentType:false,
        beforeSend:function(){
          $(document).find('span.error-text').text('');
        },
        success: function (res) {
          if(res.status==400){
            $.each(res.error, function(prefix, val){
              $('span.'+prefix+'_error').text(val[0]);
            });
          } else {
            $('#bio_analyst_form').empty();
            $('#addBioModal').find('#pbio_detail').empty().append(res.pbio_details);
            $('#showBioModal').find('.objectBioList').empty().append(res.bio_detail);
            // $('#frmAddNewBio').trigger("reset");
            $('#btnObjectSave').html(`{{ trans('global.save') }}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
            // $('#frmAddNewBio').find('#name').val(res.data.customer.name);
            // $('#frmAddNewBio').find('#age').val(res.data.customer.age);
            // $('#frmAddNewBio').find('#sex').val(res.data.customer.sex);
            // $('#frmAddNewBio').find('#customer_id').val(res.data.customer_id);
            // $('#frmAddNewBio').find('#document_id').val(res.data.id);
            // $('#addBioModal').modal('hide');
            toastr.success(res.success);
          }
        },
        error: function (error) {
          console.log('Error:', error);
          $('#btnObjectSave').html(`{{ trans('global.save') }}`);
          $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
        }
      });
    });
  </script>
@endpush
