<div class="modal fade" id="pBioModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <form id="frmPBio" action="{{ route('admin.'.$crudRoutePath.'.storePBio') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="document_id" id="document_id">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">PBio Analyst Items</h5>
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
                      <input readonly id="pbiocustomer_code" name="customer_code" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.customer_code') }}">
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
                      <input readonly id="pbioname" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
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
                      <input readonly id="pbioage" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
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
                      <input readonly id="pbiosex" sex="sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-2">
                  <div class="row">
                    <label for="customer_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
                    <div class="col-lg-8">
                      <input readonly id="pbiocustomer_id" name="customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
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
                      <input readonly id="pbiophone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
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
                      <input readonly id="pbiodocument_id" name="document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
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
                      <input readonly id="pbioaddress" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          {{-- end customer information --}}
          <div class="row">
            <div class="col-xl-12 col-lg-12 text-center">
              <h2>D'ANALYSE ITEMS</h2>
            </div>
            <input type="hidden" name="item_group_id" id="item_group_id">
            <input type="hidden" name="item_type_id" id="item_type_id">
          </div>
          <div class="row">
            <div class="col-xl-12 col-lg-12">
              <div id="showpBioList">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          @include('admin.templates.button')
        </div>
      </form>

      <div id="pBioList">

      </div>

    </div>
  </div>
</div>
