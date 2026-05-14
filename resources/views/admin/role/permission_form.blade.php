<div class="col-lg-12 col-md-12 col-sm-12">
  <div class="form-group">
    <label for="title" class="form-control-label"><strong>{{ trans('cruds.role.fields.title') }}</strong>: <span class="text-danger">*</span></label>
    <input id="title" name="title" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.title') }}">
    <span class="text-danger error-text title_error"></span>
  </div>
</div>
<div class="form-group pt-2 ">
  <label class="form-control-label"><strong>{{ trans('cruds.role.fields.permissions') }}</strong><span class="text-danger">*</span>
    @error('permissions') <span class="text-danger text-sm">{{ $message }}</span> @enderror
  </label>
  <br>
  <div class="col-12 py-2">
    <table id="dynamic-table" class="table table-bordered table-hover">
      <thead class="table-secondary">
        <tr>
          <th width="25%">Group</th>
          <th class="center">
            <label class="pos-rel">
              <input id="selectall" name="selectall" class="form-check-input" type="checkbox" value="">
              <span class="lbl"></span>
            </label>
          </th>
          <th>Access <span class="text-danger error-text permissions_error"></span></th>
        </tr>
      </thead>
      <tbody id="object_permission">
        @if($all_permissions)
          @foreach($all_permissions as $permission)
            <tr>
              <td><strong>{{$permission[0]['group']}}</strong></td>
              <td class="center first-child">
                <label>
                  <input id="chkIds" name="chkIds" value="{{ $permission[0]['group'] }}" class="form-check-input group" type="checkbox">
                  <span class="lbl"></span>
                </label>
              </td>
              <td>
                @foreach($permission as $access)
                  <label>
                    <input id="permissions" name="permissions[]" class="form-check-input permissions" type="checkbox" value="{{ $access['id'] }}">
                    <span class="lbl pr-2">&nbsp;{{ $access['title']}} &nbsp;&nbsp;</span>
                  </label>
                @endforeach
              </td>
            </tr>
          @endforeach
        @else
          <tr><td colspan="7">No data found.</td></tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
<div class="col-12 pt-3">
  <div class="form-check">
    <input id="status" name="status" class="form-check-input" type="checkbox">
    <label class="form-check-label mt-1" for="invalidCheck">
      <strong>&nbsp;{{ trans('global.status') }}</strong>
    </label>
    <div class="invalid-feedback">You must agree before submitting.</div>
  </div>
</div>
