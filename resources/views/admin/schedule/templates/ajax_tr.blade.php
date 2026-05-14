<tr id="tr_object_id_{{ $row->id }}">
  <td>{{ $row->id }}</td>
  <td>{{ $row->ap_title }}</td>
  <td>{{ date('d-M-Y',strtotime($row->ap_start_date)) }}</td>
  <td>{{ date('d-M-Y',strtotime($row->ap_end_date)) }}</td>
  <td>{{$row->customer->name}}</td>
  <td>{{$row->user->name}}</td>
  <td>{{$row->desr  }}</td>
  <td>
    <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
  </td>
  <td>
    @include('admin.templates.crudAction')
  </td>
</tr>
