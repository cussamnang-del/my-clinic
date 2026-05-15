@extends('admin.admin_layout')

@push('select2')
  <link href="{{ assetUrl() }}/plugins/select2/css/select2.min.css" rel="stylesheet" crossorigin="anonymous"/>
  <link href="{{ assetUrl() }}/plugins/select2/css/select2-bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous"/>
@endpush

@push('styles')
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/jquery-datetime/jquery.datetimepicker.min.css" crossorigin="anonymous" />
  <link href="{{ assetUrl() }}/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" crossorigin="anonymous"/>
  <link rel="stylesheet" href="{{ assetUrl() }}/css/toggle.css" crossorigin="anonymous"/>
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/toastrjs/toastr.min.css" crossorigin="anonymous"/>
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/sweetalert2/sweetalert2.min.css" crossorigin="anonymous"/>
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
      font-size: 20px;
      font-weight: 600;
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
    .disabled-select {
      background-color: #d5d5d5;
      opacity: 0.5;
      border-radius: 3px;
      cursor: not-allowed;
      position: absolute;
      top: 0;
      bottom: 0;
      right: 0;
      left: 0;
    }
    select[readonly].select2-hidden-accessible + .select2-container {
      pointer-events: none;
      touch-action: none;
    }
    select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
      background: #eee;
      box-shadow: none;
    }
    select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow,
    select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
      display: none;
    }
  </style>
@endpush

@section('content')
  @section('breadcrumb',trans('cruds.document.title'))
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h5 class="modal-title">Hospital Treatment Form</h5>
    </div>
    <div class="card-body">
      {{-- <div class="row justify-content-evenly  ">
        <div class="col-lg-9">
          <div class="d-flex align-items-center justify-content-between fs-6 mb-3">
            <a id="objecPBio" href="#" class="btn btn-primary btn-sm text-white" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show P.Bio" aria-label="Add">P.Bio</a>
            <a id="objecBio" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Bio Form" aria-label="Add">Bio</a>
            <a id="objecMore" href="#" class="btn btn-primary btn-sm text-white px-2" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View more" aria-label="Add">More</a>
            <a id="objectBioHistory" href="#" class="btn btn-secondary btn-sm text-white" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Bio History" aria-label="Edit">Bio History</a>
            <a id="objectRx" href="#" class="btn btn-success btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Rx Form" aria-label="Edit">P.Rx</a>
            <a id="objectRxNurse" href="#" class="btn btn-success btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Rx Nurse" aria-label="Show">Rx</a>
            <a id="objectInfo" href="#" class="btn btn-success btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit">Info</a>
            <a id="objectHP" target="_blank" href="{{ route("admin.documents.show.hospital", [$customer->id,$document->id]) }}" class="btn btn-info btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show HP Form" aria-label="Edit">HP</a>
            <a id="objectOrder" href="#" class="btn btn-info btn-sm text-white" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Prescription Form" aria-label="Edit">Prescription</a>
            <a id="objectOrderList" href="{{ route('admin.histories.showHistory') }}" class="btn btn-secondary btn-sm text-white" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit">Customer History</a>
          </div>
        </div>
      </div> --}}
      {{-- customer and document information --}}
      <div class="row">
        <div class="col-lg-5">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="ht_name" class="form-control-label mb-2 col-lg-3"><strong>{{ trans('cruds.customer.fields.name') }}:</strong> </label>
                  <div class="col-lg-9">
                    <input readonly id="ht_name" value="{{ $customer->name }}" name="ht_name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="ht_age" class="form-control-label mb-2 col-lg-3"><strong>{{ trans('cruds.customer.fields.age') }}:</strong> </label>
                  <div class="col-lg-9">
                    <input readonly id="ht_age" value="{{ $customer->age }}" name="ht_age" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.age') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="ht_sex" class="form-control-label mb-2 col-lg-3"><strong>{{ trans('cruds.customer.fields.sex') }}:</strong> </label>
                  <div class="col-lg-9">
                    <input readonly id="ht_sex" value="{{ $customer->sex }}" name="ht_sex" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.sex') }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="ht_customer_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer.title_singular') }}:</strong> </label>
                  <div class="col-lg-8">
                    <input readonly id="ht_customer_id" value="{{ $customer->id }}" name="ht_customer_id" class="form-control" type="text" placeholder="{{ trans('cruds.customer.title_singular') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="ht_phone_no" class="form-control-label mb-2 col-lg-3"><strong>{{ trans('cruds.customer.fields.phone_no') }}:</strong> </label>
                  <div class="col-lg-9">
                    <input readonly id="ht_phone_no" value="{{ $customer->phone_no }}" name="ht_phone_no" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.phone_no') }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="ht_document_id" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.document.title_singular') }} :</strong> </label>
                  <div class="col-lg-8">
                    <input readonly id="ht_document_id" value="{{ $document->id }}" name="ht_document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.title_singular') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="ht_address" class="form-control-label mb-2 col-lg-2"><strong>{{ trans('cruds.document.fields.address') }}:</strong> </label>
                  <div class="col-lg-10">
                    <input readonly id="ht_address" value="{{ $customer->address }}" name="ht_address" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.address') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>
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
                        <th>{{ $row->lifesign->name }}</th>
                        <td><a id="editLifeSign" data-id="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)">
                          {{ $row->coldesr }}&nbsp;({{$row->coltime}})</a>
                        </td>
                        <td width="30px">
                          <a id="objectDocLifeAdd" data-id="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Add New" aria-label="Add">
                            <i class="bi bi-plus-circle-fill"></i>
                          </a>
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
                                        <a id="objectDocLifeEdit" data-id="{{ $detail->id }}" data-lifeid="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit" aria-label="Edit">
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
              <div class="d-flex justify-content-end gap-3 fs-6 mb-3">
                <a id="htobjectAddTypeA" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Add New" aria-label="Add">+</a>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="table-responsive">
                <table id="typeB" class="table table-striped table-bordered">
                  <thead>
                    @foreach ($typeB as $key => $row)
                      <tr>
                        <th>{{ $row->lifesign->name }}</th>
                        <td>
                          <a id="editLifeSign" data-id="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)">
                            {{ $row->coldesr }}&nbsp;({{ $row->col_measure }})&nbsp;({{$row->coltime}})
                          </a>
                        </td>
                        <td width="30px">
                          <a id="objectDocLifeAdd" data-id="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Add New" aria-label="Add">
                            <i class="bi bi-plus-circle-fill"></i>
                          </a>
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
                                      <td>{{ $detail->coldesr }}&nbsp;({{ $row->col_measure }}) ({{$detail->coltime}})</td>
                                      <td>{{ $detail->coldate }}</td>
                                      <td width="30px" align="center">
                                        <a id="objectDocLifeEdit" data-id="{{ $detail->id }}" data-lifeid="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit" aria-label="Edit">
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
              <div class="d-flex justify-content-end gap-3 fs-6 mb-3">
                <a id="htobjectAddTypeB" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Add New" aria-label="Add">+</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- end customer and document information --}}
      {{-- hospital information form --}}
      <fieldset class="form-group p-3">
        <legend class="w-auto px-2">Hospital</legend>
        <form id="frmHospital" action="#" method="post">
          {{ csrf_field() }}
          <input value="{{ $customer->id }}" type="hidden" id="hp_customer_id" name="hp_customer_id">
          <input value="{{ $document->id }}" type="hidden" id="hp_document_id" name="hp_document_id">
          <div class="row">
            <div class="col-lg-5">
              <div class="form-group mb-2">
                <label for="room_no" class="form-control-label mb-2">{{ trans('cruds.hospital.fields.room_no') }}:</label>
                <select id="room_no" name="room_no" class="form-control single-select">
                  @foreach ($rooms as $key => $label)
                    <option value="{{ $key}}">{{ $label }}</option>
                  @endforeach
                </select>
                <span class="text-danger error-text room_no_error"></span>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="form-group mb-2">
                <label for="h_date" class="form-control-label mb-2">{{ trans('cruds.hospital.fields.h_date') }}:</label>
                <input id="h_date" name="h_date" class="form-control" type="text" placeholder="{{ trans('cruds.hospital.fields.h_date') }}">
                <span class="text-danger error-text h_date_error"></span>
              </div>
            </div>
            <div class="col-lg-1 mt-2">
              <div class="form-group mt-4">
                <div class="form-check form-switch">
                  <input id="status" name="status" class="form-check-input" type="checkbox" checked>
                  <label class="form-check-label mt-1" for="flexSwitchCheckChecked">&nbsp;&nbsp;{{ trans('global.status') }}</label>
                </div>
              </div>
            </div>
            <div class="col-lg-1 mt-2">
              <div class="form-group mt-4 d-grid gap-2">
                <button id="btnSaveHospital" type="submit" class="btn btn-sm btn-success px-3 radius-30">
                  <i class="fadeIn animated bx bx-plus-circle"></i>&nbsp;&nbsp;{{ trans('global.save') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </fieldset>
      {{-- end hospital information form --}}
      {{-- end customer and document information --}}

      {{-- Medical Observation   & Treatment --}}
      <fieldset class="form-group p-3">
        <div class="row">
          <div class="col-xl-12">
            <button id="btnMedical" class="btn btn-sm btn-primary">Medical Observation</button>
            <button id="btnTreatment" class="btn btn-sm btn-info">Treatment</button>
          </div>
        </div>
      </fieldset>

      {{-- hospital report buy date --}}
      <div class="row">
        {{-- Medical Observation Report --}}
        <div class="col-xl-5 col-lg-5">
          <fieldset class="form-group p-3">
            <legend>Medical Observation Report</legend>
            <div class="row">
              <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered">
                  <thead class="">
                    <tr class="text-center">
                      <th>{{ trans('cruds.hnote.fields.date') }}</th>
                      <th>{{ trans('cruds.hnote.fields.mob') }}</th>
                      <th>{{ trans('cruds.hnote.fields.dia') }}</th>
                      <th>{{ trans('cruds.hnote.fields.todo') }}</th>
                      <th>{{ trans('cruds.hnote.fields.comment') }}</th>
                      <th>{{ trans('global.action') }}</th>
                    </tr>
                  </thead>
                  <tbody id="objectMedicalObservation">
                    @foreach ($hnotes as $rows)
                      <tr id="hNotePrepend_{{ $rows[0]['id'] }}">
                        <th style="background-color:#c4dad3">{{ date('d-M-Y',strtotime($rows[0]['date'])) }}</th>
                          <td>
                            @foreach ($rows as $row)
                              <tr id="tr_hnote_id_{{ $row->id }}">
                                <td></td>
                                <td>{{ $row['mob'] }}</td>
                                <td>{{ $row['dia'] }}</td>
                                <td>{{ $row['todo'] }}</td>
                                <td>{{ $row['comment'] }}</td>
                                <td>
                                  <div class="d-flex align-items-center gap-3 fs-6">
                                    @can($prefix.'edit')
                                      <a id="editMedical" data-id="{{ $row->id }}" data-hospitalid="{{ $row['hospital_id'] }}" href="{{ route('admin.'.$crudRoutePath.'.editObjectHNote') }}" class="editMedical text-warning" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    @endcan
                                    @can($prefix.'delete')
                                      <a id="deleteMedical" data-id="{{ $row->id }}" href="{{ route('admin.'.$crudRoutePath.'.deleteObjectHNote') }}" class="deleteMedical text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                                    @endcan
                                  </div>
                                </td>
                              </tr>
                            @endforeach
                          </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </fieldset>
        </div>
        {{-- Treatment Report --}}
        <div class="col-xl-7 col-lg-7">
          <fieldset class="form-group p-3">
            <legend>Treatment Report</legend>
            <div class="row">
              <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered">
                  <thead class="">
                    <tr class="text-center">
                      <th>{{ trans('cruds.ht.fields.h_date') }}</th>
                      <th>{{ trans('cruds.ht.fields.h_time') }}</th>
                      <th>{{ trans('cruds.ht.fields.product_id') }}</th>
                      <th>{{ trans('cruds.ht.fields.qty') }}</th>
                      <th>{{ trans('cruds.ht.fields.duration') }}</th>
                      <th>{{ trans('cruds.ht.fields.how_to_use') }}</th>
                      <th>{{ trans('global.action') }}</th>
                    </tr>
                  </thead>
                  <tbody id="objectHospitalTreatment">
                    @foreach ($hospital_treatments as $key => $rows)
                      <tr>
                        <th style="background-color:#c4dad3">
                          {{ date('d-M-Y',strtotime($rows[0]['ht_date'])) }}
                        </th>
                        <td>
                          @foreach ($rows as $row)
                            <tr id="tr_object_htd_id_{{ $row->id }}">
                              <td></td>
                              <td>{{ $row['ht_time'] }}</td>
                              <td>
                                <a id="objectShow" data-bs-toggle="collapse" data-bs-target="#detail{{$row->id }}" class="accordion-toggle objectShow {{ $row->htdetails->count()>0? 'text-primary':'text-secondary' }}" data-id="{{ $row->id }}" href="javascript:void(0)" style="cursor: {{ $row->htdetails->count()>0?'pointer;':'default;' }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                {{ $row->product->p_name }}
                                @if ($row->htdetails->count()>0)
                                (
                                  @foreach ($row->htdetails as $key => $detail)
                                    {{$detail->product->p_name}}({{$detail->qty}})
                                  @endforeach
                                )
                               @endif
                              </td>
                              <td>{{ $row->qty }}</td>
                              <td>{{ $row->duration }}</td>
                              <td>{{ $row->how_to_use }}</td>
                              <td>
                                <div class="d-flex align-items-center gap-3 fs-6">
                                  @can($prefix.'show')
                                    <a id="objectShow" data-bs-toggle="collapse" data-bs-target="#detail{{$row->id }}" class="accordion-toggle objectShow {{ $row->htdetails->count()>0? 'text-primary':'text-secondary' }}" data-id="{{ $row->id }}" href="javascript:void(0)" style="cursor: {{ $row->htdetails->count()>0?'pointer;':'default;' }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                  @endcan
                                  @can($prefix.'edit')
                                    <a id="editTreatment" data-id="{{ $row->id }}" data-hospitalid="{{ $row->hospital_id }}" data-productid="{{ $row->product_id }}" href="#" class="editTreatment text-warning" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                                  @endcan
                                  @can($prefix.'delete')
                                    <a id="deleteTreatment" data-id="{{ $row->id }}" href="{{ route('admin.'.$crudRoutePath.'.deleteObjectHT') }}" class="deleteTreatment text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                                  @endcan
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="4" class="hiddenRow">
                                @include('admin.document.templates.h.more_detail')
                              </td>
                            </tr>
                          @endforeach
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
  @include('admin.document.templates.h.medicalModal')
  @include('admin.document.templates.h.addNewTreatmentModal')
  @include('admin.document.templates.lifeSignModal')
  @include('admin.document.templates.editLifeSignModal')
  <datalist id="how_to_uses">
    @foreach ($how_to_uses as $row)
      <option value="{{$row->name}}">
    @endforeach
  </datalist>
@endsection

@push('scripts')
  <script src="{{ assetUrl() }}/plugins/momentjs/moment.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/jquery-datetime/jquery.datetimepicker.full.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/datatable/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/datatable/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/select2/js/select2.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/toastrjs/toastr.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/sweetalert2/sweetalert2.all.min.js" crossorigin="anonymous"></script>
  <script>
    var products = {!! json_encode($products)  !!};
    $(function () {
      "use strict";
      $('#type_date, #h_date').datetimepicker({
        format: 'd-m-Y H:i:s',
        step: 5,
      });
      $('.single-select').select2({
          dropdownParent: $('#addNewTreatmentObjectModal'),
          theme: 'bootstrap4',
          width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
          placeholder: $(this).data('placeholder'),
          allowClear: Boolean($(this).data('allow-clear')),
      });
    })
  </script>
  {{-- Add remove input fields Product--}}
  <script>
    $(document).ready(function(){
      var rowcount =$('#object_more_product tr').length+1;
      $('body thead').on('click','#add_more_treatment',function(e){
        e.preventDefault();
        var $fieldMedicine = $(`
          <tr>
            <td>
              <div class="form-group">
                <select id="more_product" name="more_product[]" class="form-control single-select more_product canenter"  style="width: 100%" data-placeholder="Select Medicine">
                  <option value="0">{{ trans('global.select') }} {{ trans('cruds.ht.fields.product_id') }}</option>
                  @foreach ($products as $key => $row)
                    <option value="{{ $row->id }}">{{ $row->p_name }}</option>
                  @endforeach
                </select>
              </div>
            </td>
            <td>
              <div class="form-group">
                <input id="more_qty" name="more_qty[]" class="form-control canenter" type="text" placeholder="{{ trans('cruds.ht.fields.qty') }}">
              </div>
            </td>
            <td>
              <div class="form-group mb-2">
                <input list="how_to_uses" id="more_how_to_use" name="more_how_to_use[]"  class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.how_to_use') }}">
              </div>
            </td>
            <td class="text-center">
              <div class="form-group">
                <button type="button" id="remove_button_treatment" class="btn btn-sm btn-danger mt-2 px-2 remove_button_treatment"><i class="fadeIn animated bx bx-trash"></i>&nbsp;&nbsp;Del</button>
              </div>
            </td>
          </tr>
        `);
        var $clone = $fieldMedicine.clone();
        $('#object_more_product').append($clone);
        rowcount++;
        $clone.find('.more_product').select2({
            dropdownParent: $('#addNewTreatmentObjectModal'),
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
      });
      $('body tbody').on('click','.remove_button_treatment',function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
        rowcount--;
        return false;
      })
    });
  </script>
  {{-- crud script --}}
  <script>
    $(document).ready(function () {
      var today_date = new Date();
      var yy = today_date.getFullYear();
      var dd = today_date.getDate().toString().padStart(2, "0");
      var mm =  (today_date.getMonth() + 1).toString().padStart(2, "0");
      var hh = today_date.getHours().toString().padStart(2, "0");
      var mn = today_date.getMinutes().toString().padStart(2, "0");
      var ss = today_date.getSeconds().toString().padStart(2, "0");
      var today = dd + '-' + mm + '-'+ yy + " " + hh + ":" + mn + ":" + ss;
      function formatErrorMessage(jqXHR, exception)
      {
          if (jqXHR.status === 0) {
            return ('Not connected.\nPlease verify your network connection.');
          } else if (jqXHR.status == 404) {
              return ('The requested page not found.');
          }  else if (jqXHR.status == 401) {
              return ('Sorry!! You session has expired. Please login to continue access.');
          } else if (jqXHR.status == 500) {
              return ('Internal Server Error.');
          } else if (exception === 'parsererror') {
              return ('Requested JSON parse failed.');
          } else if (exception === 'timeout') {
              return ('Time out error.');
          } else if (exception === 'abort') {
              return ('Ajax request aborted.');
          } else {
              return ('Unknown error occured. Please try again.');
          }
      }
      // javascript on enter event on qty filed
      $(document).on('keydown','.canenter',function(e){
        if (e.keyCode == 13) {
          var $this = $(this),
          index = $this.closest('td').index();
          $this.closest('tr').next().find('td').eq(index).find('input').focus().select();
          e.preventDefault();
        }
      });

      $('body').on('click','a#htobjectAddTypeA',function(e){
        $('#lifesign_form').empty();
        $('#lifeSignModal').find('.modal-title').html('Add New ObjectA');
        $('#lifeSignModal').find('#type_id').val(1).trigger('change');
        var today = dd + '-' + mm + '-'+ yy;
        $('#lifeSignModal').find('#type_date').val(today);
        $('#lifeSignModal').modal('show');
      })
      $('body').on('click','a#htobjectAddTypeB',function(e){
        $('#lifesign_form').empty();
        $('#lifeSignModal').find('.modal-title').html('Add New ObjectB');
        $('#lifeSignModal').find('#type_id').val(2).trigger('change');
        var today = dd + '-' + mm + '-'+ yy;
        $('#lifeSignModal').find('#type_date').val(today);
        $('#lifeSignModal').modal('show');
      });
      $('body').on('change','#type_id',function(e){
        e.preventDefault();
        var type_id = $(this).val();
        if(type_id==0){
          return false;
        } else {
          $.ajax({
            type : 'GET',
            dataType: 'JSON',
            url :`{{ route('admin.documents.getLifeSign') }}`,
            data: {
              'type_id':type_id
            },
            success:function(res){
              $('#lifesign_form').empty();
              $.each(res,function(i,e){
                $html = `
                  <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3">
                      <div class="form-group mb-2">
                        <div class="form-check ">
                          <input value="${e.id}" id="type_name" name="type_name[]" class="form-check-input" type="checkbox" data-id="${e.id}">
                          <label class="form-check-label mt-1" for="flexSwitchCheckChecked">&nbsp;&nbsp;${e.name}</label>
                        </div>
                        <span class="text-danger error-text type_name_error"></span>
                      </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9">
                      <div class="form-group mb-2">
                        <label for="type_desr" class="form-control-label mb-2">${e.name} {{ trans('cruds.document_life.fields.coldesr') }}:</label>
                        <input id="type_desr" name="type_desr[]" class="form-control type_desr" type="text" placeholder="${e.name} {{ trans('cruds.document_life.fields.coldesr') }}" data-id="${e.id}" disabled>
                        <span class="text-danger error-text type_desr_error"></span>
                      </div>
                    </div>
                  </div>
                `;
                $('#lifesign_form').append($html);
              })
            },
            error:function(err){
              console.log(err);
            }
          });
        }
      });
      $('body').on('click','a#objectDocLifeAdd',function(e){
        e.preventDefault();
        $('#frmUpdateLifeSign').find('.modal-header').html('Add New Lifesign')
        var id = $(this).data('id');
        var lifeType = $(this).data('lifetype');
        var modal = $('#editLifeSignModal');
        $.ajax({
            type : 'GET',
            dataType: 'JSON',
            url :`{{ route('admin.documents.editDocumentLife') }}`,
            data: {
              'id':id,
              'lifetype':lifeType
            },
            success:function(res){
              $('#frmUpdateLifeSign').find('#lifetype').html(res.lifetype + ' '+ '{{ trans('cruds.document_life.fields.coldesr') }}' +':')
              $('#frmUpdateLifeSign').find('#exist_customer_id').val(res.docLife.customer_id);
              $('#frmUpdateLifeSign').find('#document_id').val(res.docLife.document_id);
              $('#frmUpdateLifeSign').find('#coltype').val(res.docLife.coltype);
              $('#frmUpdateLifeSign').find('#colfield').val(res.docLife.colfield);
              $('#frmUpdateLifeSign').find('#doclife_id').val(res.docLife.id);
              $('#frmUpdateLifeSign').find('#doclife_detail_id').val('');
              $('#frmUpdateLifeSign').trigger('reset');
              var today = dd + '-' + mm + '-'+ yy;
              $('#frmUpdateLifeSign').find('#type_date').val(today);
              $('#frmUpdateLifeSign').find('#type_measure').val(res.docLife.col_measure);
              modal.modal('show');
            },
            error:function(err){
              console.log(err);
            }
          });
      });
      $('body').on('click','a#objectDocLifeEdit',function(e){
        e.preventDefault();
        $('#frmUpdateLifeSign').find('.modal-header').html('Edit Lifesign')
        var id = $(this).data('id');
        var lifeid = $(this).data('lifeid');
        var lifeType = $(this).data('lifetype');
        var modal = $('#editLifeSignModal');
        $.ajax({
            type : 'GET',
            dataType: 'JSON',
            url :`{{ route('admin.documents.editDocumentLife') }}`,
            data: {
              'id':id,
              'lifeid':lifeid,
              'lifetype':lifeType
            },
            success:function(res){
              $('#frmUpdateLifeSign').trigger('reset');
              $('#frmUpdateLifeSign').find('#lifetype').html(res.lifetype + ' '+ '{{ trans('cruds.document_life.fields.coldesr') }}' +':')
              $('#frmUpdateLifeSign').find('#exist_customer_id').val(res.docLife.customer_id);
              $('#frmUpdateLifeSign').find('#document_id').val(res.docLife.document_id);
              $('#frmUpdateLifeSign').find('#coltype').val(res.docLife.coltype);
              $('#frmUpdateLifeSign').find('#colfield').val(res.docLife.colfield);
              $('#editLifeSignModal').find('#type_desr').val(res.liveDetail.coldesr);
              $('#frmUpdateLifeSign').find('#doclife_id').val(res.docLife.id);
              $('#frmUpdateLifeSign').find('#doclife_detail_id').val(res.liveDetail.id);
              var today = dd + '-' + mm + '-'+ yy;
              $('#frmUpdateLifeSign').find('#type_date').val(today);
              $('#frmUpdateLifeSign').find('#type_measure').val(res.liveDetail.col_measure);
              modal.modal('show');
            },
            error:function(err){
              console.log(err);
            }
          });
      });
      $('#btnMedical').on('click',function(e){
        e.preventDefault();
        var modal = $('#medicalModal');
        modal.find('#med_customer_id').val($('#ht_customer_id').val());
        modal.find('#med_document_id').val($('#ht_document_id').val());
        modal.find('#med_object_id').val('');
        modal.find('#med_ht_date').val(today);
        $('#frmMedicalObsercation').find('#btnObjectSave').html(`<i class="fadeIn animated bx bx-plus-circle"></i>&nbsp;{{ trans('global.save') }}`);
        $('#frmMedicalObsercation').find('#btnObjectSave').removeClass('d-none');
        $('#frmMedicalObsercation').find('#btnObjectUpdate').addClass('d-none');
        $('#frmMedicalObsercation').trigger('reset');
        modal.modal('show');
      });
      $('#btnTreatment').on('click',function(e){
        e.preventDefault();
        var modal = $('#addNewTreatmentObjectModal');
        var form = $('#frmAddHospitalTreatment');
        //Reset form
        modal.find('form')[0].reset();
        modal.find(`input[type=text]`).val('');
        modal.find(`select`).val(0).trigger('change');
        modal.find(`#object_more_product>tr:not(#no-delete)`).remove();
        modal.find('#ht_customer_id').val($('#ht_customer_id').val());
        modal.find('#ht_document_id').val($('#ht_document_id').val());
        form.find('#btnObjectSave').html(`<i class="fadeIn animated bx bx-plus-circle"></i>&nbsp;{{ trans('global.save') }}`);
        form.find('#btnObjectSave').removeClass('d-none');
        form.find('#btnObjectUpdate').addClass('d-none');
        var ht_hour = hh+":"+mn+":"+ss;
        modal.find('#ht_time').val(ht_hour);
        modal.find('.modal-title').html(`{{ trans('global.add') }} {{ trans('cruds.ht.title_singular') }}`);
        modal.modal('show');
      });
      $('#btnSaveHospital').on('click',function(e){
        e.preventDefault();
        var actionUrl = "{{route('admin.documents.storeObjectH')}}";
        var room_no = $('#room_no').val();
        var h_date = $('#h_date').val();
        var h_customer_id = $('#hp_customer_id').val();
        var h_document_id = $('#hp_document_id').val();
        var status = $('#status').val();
        $.ajax({
          type: 'POST',
          url: actionUrl,
          data: {room_no:room_no,h_date:h_date,h_customer_id:h_customer_id,h_document_id:h_document_id,status:status},
          dataType: 'json',
          beforeSend:function(){
            $(document).find('span.error-text').text('');
          },
          success: function (res) {
            // console.log(res);
            if(res.status==400){
              $.each(res.error, function(prefix, val){
                $('span.'+prefix+'_error').text(val[0]);
              });
            } else {
              $('#frmHospitalTreatment').find('#room_no').val('').trigger('change');
              toastr.success(res.success);
            }
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html(`{{ trans('global.save')}}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
          }
        });
      });

      // MedicalObsercation action
      $('#frmMedicalObsercation').on('submit',function(e){
        e.preventDefault();
        var actionUrl = $(this).attr('action');
        var method = $(this).attr('method')
        var modal = $('#medicalModal');
        $('#btnObjectSave').html('Processing..');
        $('#btnObjectUpdate').html('Processing..');
        $.ajax({
          type: method,
          url: actionUrl,
          data: new FormData(this),
          dataType: 'json',
          processData: false,
          contentType: false,
          cache: false,
          beforeSend:function(){
            $(document).find('span.error-text').text('');
          },
          success: function (res) {
            console.log(res)
            if(res.status==400){
              $.each(res.error, function(prefix, val){
                $('span.'+prefix+'_error').text(val[0]);
              });
              toastr.error(res.message);
            } else {
              if(res.type=='store-object'){
                toastr.success(res.success);
                modal.modal('hide');
                location.reload();
              } else {
                $("#tr_hnote_id_" + res.data.id).replaceWith(res.html);
                toastr.success(res.success);
                modal.modal('hide');
              }
              $('#btnObjectSave').html(`{{ trans('global.save') }}`);
              $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
            }
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html(`{{ trans('global.save')}}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
          }
        });
      });
      $('body').on('click','a#editMedical',function(e){
        e.preventDefault();
        var modal = $('#medicalModal');
        var form = $('#frmMedicalObsercation');
        modal.find('.modal-title').html(`Edit Medical Observation`);
        modal.find('#med_customer_id').val($('#ht_customer_id').val());
        modal.find('#med_document_id').val($('#ht_document_id').val());
        form.find('#btnObjectSave').addClass('d-none');
        form.find('#btnObjectUpdate').removeClass('d-none');
        form.find('#btnObjectUpdate').html(`<i class="fadeIn animated bx bx-edit"></i>&nbsp;{{ trans('global.update') }}`);
        var id = $(this).data('id');
        var hospital_id = $(this).data('hospitalid');
        $.ajax({
            type : 'GET',
            dataType: 'JSON',
            url :`{{ route('admin.documents.editObjectHNote') }}`,
            data: {
              'id':id,
              'hospital_id':hospital_id,
            },
            success:function(res){
              console.log(res)
              modal.trigger('reset');
              modal.find('#med_ht_date').val(res.hnote.date);
              modal.find('#med_object_id').val(res.hnote.id);
              modal.find('#mob').val(res.hnote.mob);
              modal.find('#dia').val(res.hnote.dia);
              modal.find('#todo').val(res.hnote.todo);
              modal.find('#comment').val(res.hnote.comment);
              modal.modal('show');
            },
            error:function(err){
              console.log(err);
            }
          });
      });
      $('body').on('click','a#deleteMedical',function(e){
        e.preventDefault();
        var $hnote_id = $(this).data('id');
        var link = $(this).attr('href');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              type: "POST",
              url:link,
              data : {
                'hnote_id':$hnote_id
              },
              success: function (res) {
                console.log(res)
                $("#tr_hnote_id_" + $hnote_id ).remove();
                toastr.success(res.success);
              },
              error: function (res) {
                console.log('Error:', res);
              }
            });
          }
        })
      });

      // HospitalTreatment Action
      $('#frmAddHospitalTreatment').on('submit',function(e){
        e.preventDefault();
        var actionUrl = $(this).attr('action');
        var method = $(this).attr('method')
        var modal = $('#addNewTreatmentObjectModal');
        $('#btnObjectSave').html('Processing..');
        $('#btnObjectUpdate').html('Processing..');
        $.ajax({
          type: method,
          url: actionUrl,
          data: new FormData(this),
          dataType: 'json',
          processData: false,
          contentType: false,
          cache: false,
          beforeSend:function(){
            $(document).find('span.error-text').text('');
          },
          success: function (res) {
            console.log(res)
            if(res.status==400){
              $.each(res.error, function(prefix, val){
                $('span.'+prefix+'_error').text(val[0]);
              });
            } else {
              modal.modal('hide');
              toastr.success(res.success);
              location.reload();
            }
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html(`{{ trans('global.save')}}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
          }
        });
      });
      $('body').on('click','a#editTreatment',function(e){
        e.preventDefault();
        var $htd_id = $(this).data('id');
        var $htd_hospital_id = $(this).data('hospitalid');
        var $htd_product_id = $(this).data('productid');
        var modal = $('#addNewTreatmentObjectModal');
        var form = $('#frmAddHospitalTreatment');
        modal.find('#ht_customer_id').val($('#ht_customer_id').val());
        modal.find('#ht_document_id').val($('#ht_document_id').val());
        modal.find('#htd_hospital_id').val($htd_id);
        modal.find('#htd_hospital_treatment_id').val($htd_hospital_id);
        modal.find('#htd_hospital_treatment_product_id').val($htd_product_id);
        modal.find('.modal-title').html(`{{ trans('global.edit') }} {{ trans('cruds.ht.title_singular') }}`);
        form.find('#btnObjectSave').addClass('d-none');
        form.find('#btnObjectUpdate').removeClass('d-none');
        form.find('#btnObjectUpdate').html(`<i class="fadeIn animated bx bx-edit"></i>&nbsp;{{ trans('global.update') }}`);
        $.ajax({
          type : 'get',
          dataType: 'JSON',
          url: '{{ route("admin.documents.editObjectHT") }}',
          data: {
            'hospital_treatment_id' : $htd_id,
          },
          success: function (res) {
            $('#frmAddHospitalTreatment').find('#ht_time').val(res.hospital_treatments.ht_time)
            $('#frmAddHospitalTreatment').find('#duration').val(res.hospital_treatments.duration)
            $('#frmAddHospitalTreatment').find('#qty').val(res.hospital_treatments.qty)
            if ($('#frmAddHospitalTreatment #product_id').find("option[value='" + res.hospital_treatments.product_id + "']").length) {
              $('#frmAddHospitalTreatment #product_id').val(res.hospital_treatments.product_id).trigger('change');
            }
            $('.single-select').select2({
                dropdownParent: $('#addNewTreatmentObjectModal'),
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
            });
            $('#frmAddHospitalTreatment').find('#ht_how_to_use').val(res.hospital_treatments.how_to_use)
            if(res.product_details.length>0){
              $('#frmAddHospitalTreatment').find('#object_more_product').empty();
              $.each(res.product_details,function(i,e){
                var htmlOptions = '';
                $.each(products,(j,product)=>{
                  htmlOptions+= ` <option value="${ product.id }" ${ product.id == e.product_id?'selected': null }>${ product.p_name}</option>`;
                });
                // var htmlData = `
                //   <div class="mb-2" id="${i == 0 ? 'no-delete':null}">
                //     <div class="row">
                //       <div class="col-lg-6">
                //         <div class="form-group">
                //           <label for="more_product" class="form-control-label mb-2">{{ trans('cruds.ht.fields.product_id') }}:</label>
                //           <select id="more_product" name="more_product[]" class="form-control more_product"  style="width: 100%" data-placeholder="Select Medicine">
                //             <option value="0">{{ trans('global.select') }} {{ trans('cruds.ht.fields.product_id') }}</option>
                //             ${htmlOptions}
                //           </select>
                //           <span class="text-danger error-text more_product_error"></span>
                //         </div>
                //       </div>
                //       <div class="col-lg-2">
                //         <div class="form-group mb-2">
                //           <label for="more_qty" class="form-control-label mb-2">{{ trans('cruds.ht.fields.qty') }}:</label>
                //           <input id="more_qty" name="more_qty[]" value="${e.qty}" class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.qty') }}">
                //           <span class="text-danger error-text more_qty_error"></span>
                //         </div>
                //       </div>
                //       <div class="col-lg-2">
                //         <div class="form-group mb-2">
                //           <label for="more_how_to_use" class="form-control-label mb-2">{{ trans('cruds.ht.fields.how_to_use') }}:</label>
                //           <input list="how_to_uses" id="more_how_to_use" name="more_how_to_use[]" value="${e.how_to_use}"  class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.how_to_use') }}">
                //           <span class="text-danger error-text more_how_to_use_error"></span>
                //         </div>
                //       </div>
                //       <div class="col-lg-2 mt-4">
                //         <label for="">&nbsp;</label>
                //         ${
                //           i == 0 ? `<button type="button" class="btn btn-sm btn-success mt-2 add_more_treatment"><i class="fadeIn animated bx bx-plus-medical"></i>Add</button>`
                //           : `<button type="button" class="btn btn-sm btn-danger mt-1 remove_button_treatment" disabled><i class="fadeIn animated bx bx-trash"></i>Remove</button>`
                //         }
                //       </div>
                //     </div>
                //   </div>
                // `;
                var editData = `
                  <tr id="${i == 0 ? 'no-delete':null}">
                    <td>
                      <div class="form-group">
                        <select id="more_product" name="more_product[]" class="form-control single-select more_product canenter"  style="width: 100%" data-placeholder="Select Medicine">
                          <option value="0">{{ trans('global.select') }} {{ trans('cruds.ht.fields.product_id') }}</option>
                          ${htmlOptions}
                        </select>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input value="${e.qty}" id="more_qty" name="more_qty[]" class="form-control canenter" type="text" placeholder="{{ trans('cruds.ht.fields.qty') }}">
                      </div>
                    </td>
                    <td>
                      <div class="form-group mb-2">
                        <input value="${e.how_to_use}" list="how_to_uses" id="more_how_to_use" name="more_how_to_use[]"  class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.how_to_use') }}">
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="form-group">
                        <button disabled type="button" id="remove_button_treatment" class="btn btn-sm btn-danger mt-2 px-2 remove_button_treatment"><i class="fadeIn animated bx bx-trash"></i>&nbsp;&nbsp;Del</button>
                      </div>
                    </td>
                  </tr>
                `;
                $('#frmAddHospitalTreatment').find('#object_more_product').append(editData);
              });
              $('.more_product').select2( {
                dropdownParent: $('#addNewTreatmentObjectModal'),
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
                readonly:true
              });
              $('.more_product').attr("readonly", "readonly");
            } else {
              var htmlData = `
                <tr id="no-delete">
                  <td>
                    <div class="form-group">
                      <select id="more_product" name="more_product[]" class="form-control single-select more_product canenter" style="width: 100%" data-placeholder="Select Medicine">
                        <option value="0">{{ trans('global.select') }} {{ trans('cruds.ht.fields.product_id') }}</option>
                        @foreach ($products as $key => $row)
                          <option value="{{ $row->id }}">{{ $row->p_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input id="more_qty" name="more_qty[]" class="form-control canenter" type="text" placeholder="{{ trans('cruds.ht.fields.qty') }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group mb-2">
                      <input list="how_to_uses" id="more_how_to_use" name="more_how_to_use[]"  class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.how_to_use') }}">
                    </div>
                  </td>
                  <td class="text-center">
                    <div class="form-group">
                      <button type="button" id="remove_button_treatment" class="btn btn-sm btn-danger mt-2 px-2 remove_button_treatment"><i class="fadeIn animated bx bx-trash"></i>&nbsp;&nbsp;Del</button>
                    </div>
                  </td>
                </tr>
              `;
              $('#frmAddHospitalTreatment').find('#object_more_product').empty().append(htmlData);
              $('.more_product').select2({
                dropdownParent: $('#addNewTreatmentObjectModal'),
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
              });
            }
            modal.modal('show');
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html(`{{ trans('global.save')}}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
          }
        });
      });
      $('body').on('click','a#deleteTreatment',function(e){
        e.preventDefault();
        var $ht_id = $(this).data('id');
        var link = $(this).attr('href');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              type: "POST",
              url:link,
              data : {
                'ht_id':$ht_id
              },
              success: function (data) {
                $("#tr_object_ht_id_" + $ht_id ).remove();
                toastr.success(data.success);
              },
              error: function (data) {
                console.log('Error:', data);
              }
            });
          }
        })
      });
      $('body').on('click','a#deleteTreatmentDetail',function(e){
        e.preventDefault();
        var $htd_id = $(this).data('id');
        var link = $(this).attr('href');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              type: "POST",
              url:link,
              data : {
                'htd_id':$htd_id
              },
              success: function (data) {
                $("#tr_object_htd_id_" + $htd_id ).remove();
                toastr.success(data.success);
              },
              error: function (data) {
                console.log('Error:', data);
              }
            });
          }
        })
      })
    });
  </script>

@endpush
