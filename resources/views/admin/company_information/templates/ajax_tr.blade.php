<tr id="tr_object_id_{{ $row->id }}">
  <td>{{ $row->id }}</td>
  <td>{{ $row->name_en }}</td>
  <td>{{ $row->name_kh }}</td>
  <td>{{ $row->addess }}</td>
  <td>{{ $row->phone1 }}</td>
  <td>{{ $row->phone2 }}</td>
  <td>{{ $row->phone3 }}</td>
  <td>{{ date('d-M-Y',strtotime($row->created_at)) }}</td>
  <td>
    <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
  </td>
  <td>
    @include('admin.templates.crudAction')
  </td>
</tr>
