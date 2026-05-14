<div class="row">
  <div class="col-lg-4 bg-secondary">
    <div class="table-responsive">
      <table id="doctor_description_list" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>{{trans('cruds.item_group.fields.name')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($itemGroups as $group)
            <tr id="tr_object_id_{{ $group->id}}">
              <td>
                <div class="form-group mb-4">
                  <button id="{{$group->id}}" type="button" class="btn btn-sm btn-primary px-3 radius-30 btnGroup"><i class="fadeIn animated bx bx-window-close"></i>&nbsp;{{ $group->name }}</button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-lg-4 bg-success" id="showItemTypeList">

  </div>
  <div class="col-lg-4 bg-warning" id="showItemList">

  </div>
</div>
