{{-- customer information --}}
  <div class="row">
    <div class="col-lg-6">
      <div class="form-group mb-2">
        <div class="row">
          <label for="name" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.name') }}:</strong> </label>
          <div class="col-lg-10">
            <input readonly value="{{ $customer->name }}" id="name" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="form-group mb-2">
        <div class="row">
          <label for="customer_code" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.customer_code') }}:</strong> </label>
          <div class="col-lg-10">
            <input readonly value="{{ $customer->customer_code }}" id="customer_code" name="customer_code" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.customer_code') }}">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">
      <div class="form-group mb-2">
        <div class="row">
          <label for="age" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.age') }}:</strong> </label>
          <div class="col-lg-10">
            <input readonly value="{{ $customer->age }}" id="age" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="form-group mb-2">
        <div class="row">
          <label for="sex" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.sex') }}:</strong> </label>
          <div class="col-lg-10">
            <input readonly value="{{ $customer->sex }}" id="sex" sex="sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">
      <div class="form-group mb-2">
        <div class="row">
          <label for="customer_id" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
          <div class="col-lg-10">
            <input readonly value="{{ $customer->id }}" id="customer_id" name="customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="form-group mb-2">
        <div class="row">
          <label for="phone_no" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.customer.fields.phone_no') }}:</strong> </label>
          <div class="col-lg-10">
            <input readonly value="{{ $customer->phone_no }}" id="phone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="form-group mb-2">
        <div class="row">
          <label for="address" class="form-control-label mb-2 col-lg-1"><strong>{{ trans('cruds.document.fields.address') }}:</strong> </label>
          <div class="col-lg-11">
            <input readonly value="{{ $address }}" id="address" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
          </div>
        </div>
      </div>
    </div>
  </div>
{{-- end customer information --}}
<hr>
<div class="row mb-3">
  <div class="d-grid col-xl-4 col-lg-4 mx-auto">
    <a href="{{ route('admin.histories.detail',$customer->id) }}" class="btn btn-outline-info btn-sm">Analysis Detail by Customer</a>
  </div>
</div>
{{-- document detail --}}
  <div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>{{ trans('cruds.customer_history.fields.document_id') }}</th>
          <th>{{ trans('cruds.customer_history.fields.customer_code') }}</th>
          <th>{{ trans('cruds.customer.fields.province_id') }}</th>
          <th>{{ trans('cruds.customer.fields.district_id') }}</th>
          <th>{{ trans('cruds.customer.fields.commune_id') }}</th>
          <th>{{ trans('cruds.customer.fields.village_id') }}</th>
          <th>{{ trans('cruds.customer.fields.phone_no') }}</th>
          <th>{{ trans('cruds.customer.fields.register_date') }}</th>
          <th>{{ trans('global.action') }}</th>
        </tr>
      </thead>
      <tbody id="objectList">
        @foreach ($customer->documents as $document)
          <tr id="tr_object_id_{{ $document->id }}">
            <td>{{ $document->id }}</td>
            <td>{{ $customer->customer_code }}</td>
            <td>{{ $document->province->name_en }}</td>
            <td>{{ $document->district->name_en }}</td>
            <td>{{ $document->commune->name_en }}</td>
            <td>{{ $document->village->name_en }}</td>
            <td>{{ $customer->phone_no }}</td>
            <td>{{ date('d-M-Y',strtotime($document->register_date)) }}</td>
            <td>
              <div class="d-flex align-items-center gap-3 fs-6">
                @can($prefix.'show')
                  <a id="objectShow" target="_blank" data-id="{{ $document->id }}" href="{{ route('admin.'.$crudRoutePath.'.documentDetail',[$customer->id,$document->id]) }}" class="objectShow text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                @endcan
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
{{-- end document detail --}}
