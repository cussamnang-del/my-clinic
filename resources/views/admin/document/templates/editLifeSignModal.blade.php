<div class="modal fade" id="editLifeSignModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frmUpdateLifeSign" action="{{ route('admin.'.$crudRoutePath.'.updateDocumentLife') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="exist_customer_id" id="exist_customer_id">
          <input type="hidden" name="document_id" id="document_id">
          <input type="hidden" name="doclife_id" id="doclife_id">
          <input type="hidden" name="doclife_detail_id" id="doclife_detail_id">
          <input type="hidden" name="coltype" id="coltype">
          <input type="hidden" name="colfield" id="colfield">
          <input type="hidden" name="crudRoutePath" id="crudRoutePath" value="{{ $crudRoutePath }}">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group mb-2">
                <label for="type_date" class="form-control-label mb-2">{{ trans('cruds.document.fields.type_date') }}:</label>
                <input id="type_date" name="type_date" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.type_date') }}">
                <span class="text-danger error-text type_date_error"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group mb-2">
                <label for="type_desr" id="lifetype" class="form-control-label mb-2">:</label>
                <input id="type_desr" name="type_desr" class="form-control" type="text" placeholder="{{ trans('cruds.document_life.fields.coldesr') }}">
                <input type="hidden" name="type_measure" id="type_measure" value="">
                <span class="text-danger error-text type_desr_error"></span>
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
