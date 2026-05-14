<tr id="tr_object_id_{{ $row->id }}">
  <td>{{ $row->id }}</td>
  <td>
    @foreach ($row->roles as $role)
    <span class="badge bg-dark">{{ $role->title }}</span>
    @endforeach
  </td>
  <td>{{ $row->name }}</td>
  <td>{{ $row->username }}</td>
  <td>{{ $row->email }}</td>
  <td>{{ $row->phone_no }}</td>
  <td>{{ date('d-M-Y',strtotime($row->created_at)) }}</td>
  <td>
    <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
  </td>
  <td>
    @include('admin.templates.crudAction')
  </td>
</tr>
