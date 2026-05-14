<div class="table-responsive">
  <table id="item_name_by_type" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>{{trans('cruds.item.fields.item_name')}}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($itemLists as $itemName)
        <tr id="tr_object_id_{{ $itemName->id}}">
          <td>
            <div class="form-group mb-4">
              <div class="form-check">
                <input id="bio_item_name" name="bio_item_name[]" data-id="{{ $itemName->id }}" class="form-check-input bio_item_name" type="checkbox" value="{{ $itemName->id }}" checked>
                <label class="mt-1"><span class="lbl pr-2 label-primary">&nbsp;{{ $itemName->item_name}} &nbsp;&nbsp;</span></label>
              </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
