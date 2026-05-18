<tr id="tr_object_id_{{ $row->id }}">
  <td>{{ $row->id }}</td>
  <td>{{ $row->itemGroup->name }}</td>
  <td>{{ $row->itemType->name }}</td>
  <td>{{ $row->item_name }}</td>
  <td>{{ $row->numset }}</td>
  <td>{{ $row->uvn }}</td>
  <td>{{ $row->item_price }}</td>
  <td>{{ date('d-M-Y',strtotime($row->created_at)) }}</td>
  <td>
    <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
  </td>
  <td>
    @include('admin.templates.crudAction')
  </td>
</tr>
