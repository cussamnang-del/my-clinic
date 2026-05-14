<div class="modal fade" id="medicalModal" tabindex="-1"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    aria-labelledby="medicalModal">
  <div class="modal-dialog modal-xl modal-center">
    <div class="modal-content">
      <form id="frmMedicalObsercation" action="{{ route('admin.'.$crudRoutePath.'.storeObjectHNote') }}" method="post">
        {{ csrf_field() }}
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">Add Medical Observation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="med_customer_id" name="med_customer_id">
          <input type="hidden" id="med_document_id" name="med_document_id">
          <input type="hidden" id="med_object_id" name="med_object_id">
          <input type="hidden" id="med_ht_date" name="med_ht_date">
          <div class="card">
            <div class="card-body">
              <div class="col-lg-12">
                <fieldset class="form-group p-3">
                  <div class="form-group mb-2">
                    <label for="mob" class="form-control-label mb-2">{{ trans('cruds.hnote.fields.mob') }}:</label>
                    <textarea name="mob" id="mob" cols="100" rows="4" class="form-control mb-2" placeholder="{{ trans('cruds.hnote.fields.mob') }}"></textarea>
                    <span class="text-danger error-text mob_error"></span>
                  </div>
                  <div class="form-group mb-2">
                    <label for="dia" class="form-control-label mb-2">{{ trans('cruds.hnote.fields.dia') }}:</label>
                    <input id="dia" name="dia" class="form-control" type="text" placeholder="{{ trans('cruds.hnote.fields.dia') }}">
                    <span class="text-danger error-text dia_error"></span>
                  </div>
                  <div class="row mt-3">
                    <label for="todo" class="form-control-label col-lg-2"><strong>{{ trans('cruds.hnote.fields.todo') }}:</strong> </label>
                    <div class="col-lg-10">
                      <input id="todo" name="todo" class="form-control" type="text" placeholder="{{ trans('cruds.hnote.fields.todo') }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <label for="comment" class="form-control-label col-lg-2"><strong>{{ trans('cruds.hnote.fields.comment') }}:</strong> </label>
                    <div class="col-lg-10">
                      <textarea name="comment" id="comment" cols="100" rows="3" class="form-control mb-2" placeholder="{{ trans('cruds.hnote.fields.comment') }}"></textarea>
                      <span class="text-danger error-text comment_error"></span>
                    </div>
                  </div>
                </fieldset>
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
