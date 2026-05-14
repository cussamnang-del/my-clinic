<tr id="tr_object_id_{{ $row->id }}" class="gotoService" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer->id }}">
  <td>{{ $row->id }}</td>
  <td class="text-center">
    <a id="checkout" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer->id }}" href="javascript:void(0)" class="btn btn-sm btn-outline-success px-3"><strong>Checkout</strong></a>
    <div class="dropdown">
      {{-- <button class="btn btn-outline-primary btn-sm dropdown-toggle px-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
      <ul class="dropdown-menu" style="">
        <li>
          <a id="gotoService" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer->id }}" href="javascript:void(0)" class="btn btn-sm btn-outline-warning dropdown-item"><strong>Add Service</strong></a>
        </li>
        <li>
          <a id="serviceCustomer" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer_id }}" href="{{ route('admin.histories.serviceDetail',$row->customer_id) }}" target="_blank" class="btn btn-sm btn-outline-info dropdown-item"><strong>Customer Services</strong></a>
        </li>
        <li>
          <a id="checkout" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer->id }}" href="javascript:void(0)" class="btn btn-sm btn-outline-success dropdown-item"><strong>Checkout</strong></a>
        </li>
      </ul> --}}
    </div>
  </td>
  <td>{{ date('d-m-Y',strtotime($row->visit_date)) }}</td>
  <td>{{ $row->customer->name }}</td>
  <td>{{ $row->customer->sex }}</td>
  <td>{{ $row->customer->age }}</td>
  <td>{{ $row->customer->phone_no }}</td>
  <td>{{ $row->address }}</td>
  <td>
    <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
  </td>
  <td>
    @include('admin.templates.crudAction')
  </td>
</tr>
