<div class="table-responsive">
  <table id="item_type_by_group" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>{{trans('cruds.item_type.fields.name')}}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($itemTypes as $group)
        <tr id="tr_object_id_{{ $group->id}}">
          <td>
            <div class="form-group mb-4">
              <button id="{{$group->id}}" type="button" class="btn btn-sm btn-primary px-3 radius-30 btnItemType"><i class="fadeIn animated bx bx-window-close"></i>&nbsp;{{ $group->name }}</button>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
