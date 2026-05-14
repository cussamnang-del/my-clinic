@extends('admin.admin_layout')

@push('select2')
  <link href="{{ assetUrl() }}/plugins/select2/css/select2.min.css" rel="stylesheet" crossorigin="anonymous"/>
  <link href="{{ assetUrl() }}/plugins/select2/css/select2-bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous"/>
@endpush

@push('styles')
  <link href="{{ assetUrl() }}/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" crossorigin="anonymous"/>
  <link rel="stylesheet" href="{{ assetUrl() }}/css/toggle.css" crossorigin="anonymous"/>
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/toastrjs/toastr.min.css" crossorigin="anonymous"/>
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/sweetalert2/sweetalert2.min.css" crossorigin="anonymous"/>
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/jquery-datetime/jquery.datetimepicker.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="{{ asset('assets/backend/') }}/plugins/summernote/summernote-lite.min.css">
  <style>
    input.ace-switch.ace-switch-yesno:checked::before {
      content: "{{trans('global.yes')}}";
    }
    input.ace-switch.ace-switch-yesno::before {
      content: "{{trans('global.no')}}";
    }
    input.ace-switch.ace-switch-onoff:checked::before {
      content: "{{trans('global.on')}}";
    }
    input.ace-switch.ace-switch-onoff::before {
      content: "{{trans('global.off')}}";
    }
    fieldset {
        border: solid 1px gray;
        padding-top: 5px;
        padding-right: 12px;
        padding-bottom: 10px;
        padding-left: 12px;
    }
    legend {
      float: none;
      width: inherit;
    }
		.hiddenRow {
    	padding: 0 !important;
    	margin: 0 !important;
		}
    tr:hover td{
      cursor:pointer;
      color:red;
    }
    .ui-autocomplete {
        position: fixed;
        z-index: 1511;
    }
    .ui-autocomplete-input{
      border: none;
      font-size: 16px;
      margin-bottom: 5px;
      border:1px solid #c8c6c6 !important;
      z-index:1511;
    }
  </style>
@endpush

@section('content')
  @section('breadcrumb',trans('cruds.document.title'))
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h5 class="modal-title">Document Detail for Customer</h5>
    </div>
    <div class="card-body">
      {{-- customer information --}}
      <div class="row">
        {{-- customer info --}}
        <div class="col-lg-5">
          <div class="row">
            <div class="col-lg-7">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="name" class="form-control-label mb-2 col-lg-3"><strong>{{ trans('cruds.customer.fields.name') }}:</strong> </label>
                  <div class="col-lg-9">
                    <input value="{{ $customer->name }}" readonly id="name" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
                  </div>
                </div>
                <span class="text-danger error-text name_error"></span>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="age" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.fields.age') }}:</strong> </label>
                  <div class="col-lg-8">
                    <input value="{{ $customer->age }}" readonly id="age" name="age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
                  </div>
                </div>
                <span class="text-danger error-text age_error"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="sex" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.fields.sex') }}:</strong> </label>
                  <div class="col-lg-8">
                    <input value="{{ $customer->sex }}" readonly id="sex" sex="sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="customer_id" class="form-control-label mb-2 col-lg-5"><strong>{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}:</strong> </label>
                  <div class="col-lg-7">
                    <input value="{{ $customer->id }}" readonly id="customer_id" name="customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }} {{ trans('cruds.customer.fields.id') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="phone_no" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.fields.phone_no') }}:</strong> </label>
                  <div class="col-lg-8">
                    <input value="{{ $customer->phone_no }}" readonly id="phone_no" name="phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
                  </div>
                </div>
                <span class="text-danger error-text phone_no_error"></span>
              </div>
            </div>
            {{-- <div class="col-lg-7">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="document_id" class="form-control-label mb-2 col-lg-5"><strong>{{ trans('cruds.document.title_singular') }} {{ trans('cruds.document.fields.id') }}:</strong> </label>
                  <div class="col-lg-7">
                    <input value="{{ $document->id }}" readonly id="document_id" name="document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
                  </div>
                </div>
              </div>
            </div> --}}
          </div>
          {{-- <div class="row">
            <div class="col-lg-12">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="address" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.document.fields.address') }}:</strong> </label>
                  <div class="col-lg-10">
                    <input value="{{ $document->address }}" readonly id="address" name="address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
                  </div>
                </div>
              </div>
            </div>
          </div> --}}
        </div>
        {{-- alert info --}}
        <div class="col-lg-7">
          <div class="row">
            <div class="col-lg-6">
              <div class="table-responsive">
                <table id="typeA" class="table table-striped table-bordered">
                  <thead>
                    @foreach ($typeA as $key => $row)
                      <tr>
                        <th>{!! $row->lifesign->name !!}</th>
                        <td><a id="editLifeSign" data-id="{{ $row->id }}" data-lifetype="{!! $row->lifesign->name !!}" href="javascript:void(0)">
                          {!! $row->coldesr !!}&nbsp;({{$row->coltime}})</a>
                        </td>
                        <td width="30px">
                          {{-- <a id="objectDocLifeAdd" data-id="{{ $row->id }}" data-lifetype="{!! $row->lifesign->name !!}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Add New" aria-label="Add">
                            <i class="bi bi-plus-circle-fill"></i>
                          </a> --}}
                          <a id="objectDetailA" data-bs-toggle="collapse" data-bs-target="#detailA{{ $key }}" class="accordion-toggle objectShow {{ $row->colFields->count()>0? 'text-primary':'text-secondary' }}"
                            data-id="{{ $row->id }}" href="javascript:void(0)" style="cursor: {{ $row->colFields->count()>0?'pointer;':'default;' }}"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4" class="hiddenRow">
                          @if ($row->colFields->count()>0)
                          <div class="accordian-body collapse" id="detailA{{ $key }}">
                            <div class="table-responsive">
                              <table id="more_detail" class="table table-striped table-bordered">
                                <thead class="bg-secondary text-white">
                                  <tr class="text-center">
                                    <th>{{ trans('cruds.document_life.fields.coltype') }}</th>
                                    <th>{{ trans('cruds.document_life_detail.fields.coldesr') }}</th>
                                    <th>{{ trans('cruds.document_life_detail.fields.coldate') }}</th>
                                    <th>{{ trans('global.action') }}</th>
                                  </tr>
                                </thead>
                                <tbody id="objectTypeDetail">
                                  @foreach ($row->colFields as $key => $detail)
                                    <tr id="tr_object_type_id_{{ $detail->id }}">
                                      <td>{{ $row->lifesign->name }}</td>
                                      <td>{{ $detail->coldesr }} ({{$detail->coltime}})</td>
                                      <td>{{ $detail->coldate }}</td>
                                      <td width="30px" align="center">
                                        <a id="objectDocLifeEdit" data-id="{{ $detail->id }}" data-lifeid="{{ $row->id }}" data-lifetype="{!! $row->lifesign->name !!}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit" aria-label="Edit">
                                          <i class="bi bi-pencil-square"></i>
                                        </a>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        @endif
                        </td>
                      </tr>
                    @endforeach
                  </thead>
                </table>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="table-responsive">
                <table id="typeB" class="table table-striped table-bordered">
                  <thead>
                    @foreach ($typeB as $key => $row)
                      <tr>
                        <th>{!! $row->lifesign->name !!}</th>
                        <td>
                          <a id="editLifeSign" data-id="{{ $row->id }}" data-lifetype="{!! $row->lifesign->name !!}" href="javascript:void(0)">
                            {!! $row->coldesr !!}&nbsp;({{$row->coltime}})
                          </a>
                        </td>
                        <td width="30px">
                          {{-- <a id="objectDocLifeAdd" data-id="{{ $row->id }}" data-lifetype="{!! $row->lifesign->name !!}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Add New" aria-label="Add">
                            <i class="bi bi-plus-circle-fill"></i>
                          </a> --}}
                          <a id="objectDetailB" data-bs-toggle="collapse" data-bs-target="#detailB{{ $key }}" class="accordion-toggle objectShow {{ $row->colFields->count()>0? 'text-primary':'text-secondary' }}"
                            data-id="{{ $row->id }}" href="javascript:void(0)" style="cursor: {{ $row->colFields->count()>0?'pointer;':'default;' }}"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4" class="hiddenRow">
                          @if ($row->colFields->count()>0)
                          <div class="accordian-body collapse" id="detailB{{ $key }}">
                            <div class="table-responsive">
                              <table id="more_detail" class="table table-striped table-bordered">
                                <thead class="bg-secondary text-white">
                                  <tr class="text-center">
                                    <th>{{ trans('cruds.document_life.fields.coltype') }}</th>
                                    <th>{{ trans('cruds.document_life_detail.fields.coldesr') }}</th>
                                    <th>{{ trans('cruds.document_life_detail.fields.coldate') }}</th>
                                    <th>{{ trans('global.action') }}</th>
                                  </tr>
                                </thead>
                                <tbody id="objectTypeDetail">
                                  @foreach ($row->colFields as $key => $detail)
                                    <tr id="tr_object_type_id_{{ $detail->id }}">
                                      <td>{{ $row->lifesign->name }}</td>
                                      <td>{{ $detail->coldesr }} ({{$detail->coltime}})</td>
                                      <td>{{ $detail->coldate }}</td>
                                      <td width="30px" align="center">
                                        <a id="objectDocLifeEdit" data-id="{{ $detail->id }}" data-lifeid="{{ $row->id }}" data-lifetype="{!! $row->lifesign->name !!}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit" aria-label="Edit">
                                          <i class="bi bi-pencil-square"></i>
                                        </a>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        @endif
                        </td>
                      </tr>
                    @endforeach
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- end customer information --}}
      <br>
      {{-- customer Document information --}}
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>
            {{ trans('global.list') }} {{ trans('cruds.customer.title') }}  {{ trans('cruds.document.title') }}
          </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>{{ trans('cruds.document.fields.id') }}</th>
                  <th>{{ trans('cruds.document.fields.view_detail') }}</th>
                  <th>{{ trans('cruds.document.fields.visit_date') }}</th>
                  <th>{{ trans('cruds.document.fields.customer_id') }}</th>
                  <th>{{ trans('cruds.customer.fields.sex') }}</th>
                  <th>{{ trans('cruds.customer.fields.age') }}</th>
                  <th>{{ trans('cruds.customer.fields.phone_no') }}</th>
                  <th>{{ trans('cruds.customer.fields.address') }}</th>
                  {{-- <th>{{ trans('global.status') }}</th> --}}
                  {{-- <th>{{ trans('global.action') }}</th> --}}
                </tr>
              </thead>
              <tbody id="objectDocumentList">
                @foreach ($documents as $row)
                  <tr id="tr_object_id_{{ $row->id }}" class="gotoService" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer->id }}">
                    <td>{{ $row->id }}</td>
                    <td class="text-center">
                      <a id="documentDetail" href="{{ route('admin.schedules.showDetailByDocument',[$row->id,$customer->id]) }}" target="_blank" class="btn btn-sm btn-outline-success px-3"><strong>{{ trans('cruds.document.fields.detail') }}</strong></a>
                    </td>
                    <td>{{ date('d-m-Y',strtotime($row->visit_date)) }}</td>
                    <td>{{ $row->customer->name }}</td>
                    <td>{{ $row->customer->sex }}</td>
                    <td>{{ $row->customer->age }}</td>
                    <td>{{ $row->customer->phone_no }}</td>
                    <td>{{ $row->address }}</td>
                    {{-- <td>
                      <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
                    </td> --}}
                    {{-- <td>
                      @include('admin.templates.crudAction')
                    </td> --}}
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
       {{-- customer Document in hospital information --}}
      @if (count($document_hospitals))
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>
            {{ trans('global.list') }} {{ trans('cruds.document.fields.customer_stay') }}
          </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered" style="height: 180px">
              <thead>
                <tr>
                  <th>{{ trans('cruds.document.fields.id') }}</th>
                  <th>{{ trans('cruds.document.fields.view_detail') }}</th>
                  <th>{{ trans('cruds.document.fields.visit_date') }}</th>
                  <th>{{ trans('cruds.document.fields.customer_id') }}</th>
                  <th>{{ trans('cruds.customer.fields.sex') }}</th>
                  <th>{{ trans('cruds.customer.fields.age') }}</th>
                  <th>{{ trans('cruds.customer.fields.phone_no') }}</th>
                  <th>{{ trans('cruds.customer.fields.address') }}</th>
                  {{-- <th>{{ trans('global.status') }}</th>
                  <th>{{ trans('global.action') }}</th> --}}
                </tr>
              </thead>
              <tbody id="objectDocumentHospital">
                @foreach ($document_hospitals as $row)
                <tr id="tr_object_id_{{ $row->id }}" class="gotoService" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer->id }}">
                  <td>{{ $row->id }}</td>
                  <td class="text-center">
                    <a id="documentDetail" href="{{ route('admin.schedules.showDetailByDocument',[$row->id,$customer->id]) }}" target="_blank" class="btn btn-sm btn-outline-success px-3"><strong>{{ trans('cruds.document.fields.detail') }}</strong></a>
                  </td>
                  <td>{{ date('d-m-Y',strtotime($row->visit_date)) }}</td>
                  <td>{{ $row->customer->name }}</td>
                  <td>{{ $row->customer->sex }}</td>
                  <td>{{ $row->customer->age }}</td>
                  <td>{{ $row->customer->phone_no }}</td>
                  <td>{{ $row->address }}</td>
                  {{-- <td>
                    <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
                  </td>
                  <td>
                    @include('admin.templates.crudAction')
                  </td> --}}
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    @endif
    </div>
  </div>

@endsection

@push('scripts')
  <script src="{{ assetUrl() }}/plugins/datatable/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/datatable/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/select2/js/select2.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/toastrjs/toastr.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/sweetalert2/sweetalert2.all.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/momentjs/moment.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/jquery-datetime/jquery.datetimepicker.full.min.js" crossorigin="anonymous"></script>
@endpush
