<div class="modal fade" id="crudObjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frmCrudObject" action="{{ route('admin.'.$crudRoutePath.'.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="object_id" id="object_id">
          <input type="hidden" name="crudRoutePath" id="crudRoutePath" value="{{ $crudRoutePath }}">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group mb-2">
                <label for="document_id" class="form-control-label mb-2">{{ trans('cruds.document_life.fields.document_id') }}: <span class="text-danger">*</span></label>
                <select id="document_id" name="document_id" class="form-control single-select" data-placeholder="{{ trans('global.select') }} {{ trans('cruds.document_life.fields.document_id') }}">
                  <option value="">{{ trans('global.select') }} {{ trans('cruds.document_life.fields.document_id') }}</option>
                  @foreach ($documents as $row)
                    <option value="{{ $row->id }}">{{ $row->id }}</option>
                  @endforeach
                </select>
                <span class="text-danger error-text document_id_error"></span>
              </div>
              <div class="form-group mb-2">
                <label for="coltype" class="form-control-label mb-2">{{ trans('cruds.document_life.fields.coltype') }}: <span class="text-danger">*</span></label>
                <input id="coltype" name="coltype" class="form-control" type="text" placeholder="{{ trans('cruds.document_life.fields.coltype') }}">
                <span class="text-danger error-text coltype_error"></span>
              </div>
              <div class="form-group mb-2">
                <label for="colfield" class="form-control-label mb-2">{{ trans('cruds.document_life.fields.colfield') }}:</label>
                <input id="colfield" name="colfield" class="form-control" type="text" placeholder="{{ trans('cruds.document_life.fields.colfield') }}">
                <span class="text-danger error-text colfield_error"></span>
              </div>
              <div class="form-group mb-2">
                <label for="coldesr" class="form-control-label mb-2">{{ trans('cruds.document_life.fields.coldesr') }}:</label>
                <input id="coldesr" name="coldesr" class="form-control" type="text" placeholder="{{ trans('cruds.document_life.fields.coldesr') }}">
                <span class="text-danger error-text coldesr_error"></span>
              </div>
              <div class="form-group mb-2">
                <label for="num" class="form-control-label mb-2">{{ trans('cruds.document_life.fields.num') }}:</label>
                <input id="num" name="num" class="form-control" type="text" placeholder="{{ trans('cruds.document_life.fields.num') }}">
                <span class="text-danger error-text num_error"></span>
              </div>
              <div class="form-group mb-2">
                <div class="form-check form-switch">
                  <input id="status" name="status" class="form-check-input" type="checkbox">
                  <label class="form-check-label mt-1" for="flexSwitchCheckChecked">&nbsp;&nbsp;{{ trans('global.status') }}</label>
                </div>
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
