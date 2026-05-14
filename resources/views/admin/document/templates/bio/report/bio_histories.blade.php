<div class="modal fade" id="bioHistoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
        <input type="hidden" name="document_id" id="document_id">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Bio Histories</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- customer information --}}
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-5">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="customer_code" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.fields.customer_code') }}:</strong> </label>
                    <div class="col-lg-8">
                      <input readonly id="biohis_customer_code" name="customer_code" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.customer_code') }}">
                    </div>
                  </div>
                  <span class="text-danger error-text customer_code_error"></span>
                </div>
              </div>
              <div class="col-lg-5">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="name" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.name') }}:</strong> </label>
                    <div class="col-lg-10">
                      <input readonly id="biohis_name" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
                    </div>
                  </div>
                  <span class="text-danger error-text name_error"></span>
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="age" class="form-control-label mb-2 col-lg-3"><strong>{{ trans('cruds.customer.fields.age') }}:</strong> </label>
                    <div class="col-lg-9">
                      <input readonly id="biohis_age" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
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
                      <input readonly id="biohis_sex" sex="sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="customer_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
                    <div class="col-lg-8">
                      <input readonly id="biohis_customer_id" name="customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
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
                      <input readonly id="biohis_phone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
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
                      <input readonly id="biohis_document_id" name="document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
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
                      <input readonly id="biohis_address" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-lg-12 d-grid mx-auto">
              <form action="{{ route('admin.documents.bio.receipt',[$document->id,$customer->id]) }}" method="get">
                @csrf
                <div class="row">
                  <div class="col-lx-8 col-lg-8 col-md-8 offset-xl-2 offset-lg-2 offset-md-2">
                    <div class="row">
                      {{-- <div class="col-lg-5">
                        <div class="form-group mb-3">
                          <label for="customer_history" class="form-control-label">{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.name') }}: <span class="text-danger">*</span></label>
                          <select id="customer_history" name="customer_history" class="form-control customer_history"  style="width: 100%" data-placeholder="Choose Customer">
                            <option value="">{{ trans('global.select') }} {{ trans('cruds.customer.fields.name') }}</option>
                            @foreach ($customers as $key => $row)
                              <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                          </select>
                          <span class="text-danger error-text customer_history_error"></span>
                        </div>
                      </div> --}}
                      <div class="col-lx-9 col-lg-9 col-md-9">
                        <div class="form-group mb-3">
                          <div class="row">
                            <label for="history_date" class="form-control-label col-xl-3 col-lg-3">{{ trans('global.filterDate') }}</span></label>
                            <div class="col-lg-9">
                              <input name="history_date" id="history_date" type="text" class="form-control" placeholder="history_date" aria-label="from_date" value="">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lx-3 col-lg-3 col-md-3">
                        <div class="form-group">
                          <button type="submit" class="btn btn-md btn-outline-success">
                            <i class="fadeIn animated bx bx-search-alt"></i> Print
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@push('modal')
  <script>
      var today_date = new Date();
      var yy = today_date.getFullYear();
      var dd = today_date.getDate().toString().padStart(2, "0");
      var mm =  (today_date.getMonth() + 1).toString().padStart(2, "0");
      var today = yy + '-' + mm + '-'+ dd;

    $('body').on('click','a#objectBioHistory',function(e){
      e.preventDefault();
      $('#bioHistoryModal').find('#biohis_customer_code').val($('#rx_bio_customer_code').val());
      $('#bioHistoryModal').find('#biohis_name').val($('#rx_bio_name').val());
      $('#bioHistoryModal').find('#biohis_age').val($('#rx_bio_age').val());
      $('#bioHistoryModal').find('#biohis_sex').val($('#rx_bio_sex').val());
      $('#bioHistoryModal').find('#biohis_phone_no').val($('#rx_bio_phone_no').val());
      $('#bioHistoryModal').find('#biohis_address').val($('#rx_bio_address').val());
      $('#bioHistoryModal').find('#biohis_customer_id').val($('#rx_bio_customer_id').val());
      $('#bioHistoryModal').find('#biohis_document_id').val($('#rx_bio_document_id').val());
      $('#bioHistoryModal').find('#biohis_history_date').datetimepicker({
        format: 'Y-m-d',
      });
      $('#bioHistoryModal').find('#history_date').val(today);
      $('#bioHistoryModal').modal('show');
    });
  </script>
@endpush
