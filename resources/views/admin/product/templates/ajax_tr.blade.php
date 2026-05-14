<tr id="tr_object_id_{{ $row->id }}">
  <td>{{ $row->id }}</td>
  <td>{{ $row->p_name }}</td>
  <td>{{ $row->p_code }}</td>
  <td>{{ $row->country }}</td>
  <td>{{ $row->description }}</td>
  <td>{{ $row->unit }}</td>
  <td>{{ $row->strength }}</td>
  <td>
    <img width="40px;" height="40px;" src="{{ asset('uploads/product/'.$row->image) }}" alt="{{ $row->pname }}">
  </td>
  <td>
    <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
  </td>
  <td>
    @include('admin.templates.crudAction')
  </td>
</tr>
