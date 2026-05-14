<tr id="tr_object_id_{{ $row->id }}">
  <td>{{ $row->id }}</td>
  <td><strong>{{ $row->title }}</strong></td>
  <td>
    @foreach ($row->permissions as $p)
      <span class="badge rounded-pill bg-secondary">{{ $p->title }}</span>
    @endforeach
  </td>
  <td>{{ date('d-M-Y',strtotime($row->created_at)) }}</td>
  <td>
    <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
  </td>
  <td>
    @include('admin.templates.crudAction')
  </td>
</tr>
