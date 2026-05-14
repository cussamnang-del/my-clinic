<tr id="tr_object_id_{{ $row->id }}">
  <td>{{ $row->id }}</td>
  <td>{{ $row->document_id }}</td>
  <td>{{ $row->coltype }}</td>
  <td>{{ $row->colfield }}</td>
  <td>{{ $row->coldesr }}</td>
  <td>{{ $row->num }}</td>
  <td>{{ date('d-M-Y',strtotime($row->created_at)) }}</td>
  <td>
    <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
  </td>
  <td>
    @include('admin.templates.crudAction')
  </td>
</tr>
