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
              <div class="row mb-4">
                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="form-group">
                    <label for="type_id" class="form-control-label mb-1">{{ trans('cruds.lifesign.fields.type') }}: <span class="text-danger">*</span></label>
                    <select id="type_id" name="type_id" class="form-control single-select"  style="width: 100%" data-placeholder="Choose Province">
                      <option value="0">{{ trans('global.select') }} {{ trans('cruds.lifesign.fields.type') }}</option>
                      @foreach ($lifesigns as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                      @endforeach
                    </select>
                    <span class="text-danger error-text type_id_error"></span>
                  </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="form-group">
                    <label for="name" class="form-control-label mb-1">{{ trans('cruds.lifesign.fields.name') }}: <span class="text-danger">*</span></label>
                    <input id="name" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.lifesign.fields.name') }}">
                    <span class="text-danger error-text name_error"></span>
                  </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <div class="form-check form-switch">
                      <input id="status" name="status" class="form-check-input" type="checkbox" checked>
                      <label class="form-check-label mt-1" for="flexSwitchCheckChecked">&nbsp;&nbsp;Status</label>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- col-xl-12 -->
          </div>
        </div>
        <div class="modal-footer">
          @include('admin.templates.button')
        </div>
      </form>
    </div>
  </div>
</div>
