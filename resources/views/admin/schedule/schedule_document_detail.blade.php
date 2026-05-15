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
                        <th>{{ $row->lifesign->name }}</th>
                        <td><a id="editLifeSign" data-id="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)">
                          {{ $row->coldesr }}&nbsp;({{$row->coltime}})</a>
                        </td>
                        <td width="30px">
                          {{-- <a id="objectDocLifeAdd" data-id="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Add New" aria-label="Add">
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
                            {{ $row->coldesr }}&nbsp;({{$row->coltime}})
                          </a>
                        </td>
                        <td width="30px">
                          {{-- <a id="objectDocLifeAdd" data-id="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Add New" aria-label="Add">
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
            </div>
          </div>
        </div>
      </div>
      {{-- end customer information --}}
      <br>
      {{-- customer history information --}}
      <div id="customer_history_information">
        <div class="card border">
          <div class="card-body">
            <ul class="nav nav-tabs nav-primary" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" href="#primaryBio" role="tab" aria-selected="true">
                  <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="bx bx-home font-18 me-1"></i>
                    </div>
                    <div class="tab-title">BIO</div>
                  </div>
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#primaryRx" role="tab" aria-selected="false">
                  <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
                    </div>
                    <div class="tab-title">RX</div>
                  </div>
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#primaryHospital" role="tab" aria-selected="false">
                  <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="bx bx-microphone font-18 me-1"></i>
                    </div>
                    <div class="tab-title">HOSPITAL</div>
                  </div>
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#primaryHospitalTreatment" role="tab" aria-selected="false">
                  <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="bx bx-microphone font-18 me-1"></i>
                    </div>
                    <div class="tab-title">HOSPITAL TREATMENT</div>
                  </div>
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#primaryOrder" role="tab" aria-selected="false">
                  <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class="bx bx-microphone font-18 me-1"></i>
                    </div>
                    <div class="tab-title">ORDER</div>
                  </div>
                </a>
              </li>
            </ul>
            <div class="tab-content py-3">
              <div class="tab-pane fade active show" id="primaryBio" role="tabpanel">
                <div class="row">
                  <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead class="bg-primary text-white">
                        <tr>
                          <th>{{ trans('cruds.bio.fields.id') }}</th>
                          <th>{{ trans('cruds.bio.fields.item_id') }}</th>
                          <th>{{ trans('cruds.bio.fields.normal_value') }}</th>
                          <?php
                            $items = DB::table('bio_details')->select('bio_date')->distinct()->orderBy('bio_date','desc')->get();
                          ?>
                          @foreach ($items as $item)
                          <?php
                            $datas[] = $item->bio_date;
                          ?>
                            <th class="text-center">{{ date('d-m-Y',strtotime($item->bio_date)) }}</th>
                          @endforeach
                        </tr>
                      </thead>
                        <tbody>
                          <?php
                            $i=0;
                          ?>
                          @forelse ($bios as $row)
                            <tr id="tr_object_id_{{ $row->id }}">
                              <td>{{ $row->id }}</td>
                              <td>{{ $row->item->item_name }}</td>
                              <td>100g</td>
                              @foreach ($row->detail as $key => $item)
                                @foreach ($datas as $key1 => $date)
                                  @if ($key1 >= $i)
                                    @if ($item->bio_date === $date)
                                      <?php
                                        $i=$key1+1;
                                      ?>
                                      <td>
                                        @if ($item->bio_result < $row->item->min_value || $item->bio_result > $row->item->max_value)
                                          <strong>{{ $item->bio_result }}</strong>
                                        @else
                                          {{ $item->bio_result }}
                                        @endif
                                      </td>
                                      @break
                                    @else
                                      <td></td>
                                    @endif
                                  @endif
                                @endforeach

                              @endforeach
                            </tr>
                            <?php
                              $i=0;
                            ?>
                          @empty
                            <tr>
                              <td colspan="{{ $items->count()+3 }}">
                                <h4 class="text-center">No record Found</h4>
                              </td>
                            </tr>
                          @endforelse
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="primaryRx" role="tabpanel">
                <div class="row">
                  <div class="table-responsive">
                    <table id="rx_detail_list" class="table table-striped table-bordered">
                      <thead class="bg-secondary text-white">
                        <tr>
                          <th>{{ trans('cruds.rx.fields.id') }}</th>
                          <th>{{ trans('cruds.rx.fields.rx_date') }}</th>
                          <th>{{ trans('cruds.customer.title_singular') }}</th>
                          <th>{{ trans('cruds.document.title_singular') }}</th>
                          <th>{{ trans('cruds.rx.fields.doctor_description') }}</th>
                          <th>{{ trans('global.action') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($rx_details as $rx)
                          <tr id="tr_object_id_{{ $rx->id }}">
                            <td>
                              {{ $rx->id }}
                            </td>
                            <td>
                              {{ date('d-m-Y',strtotime($rx->rx_date)) }}
                            </td>
                            <td>
                              {{ $rx->customer->name }}
                            </td>
                            <td>
                              {{ $rx->document_id }}
                            </td>
                            <td>
                              {{ $rx->rx_note }}
                            </td>
                            <td>
                              <div class="d-flex align-items-center gap-3 fs-6">
                                @can($prefix.'show')
                                  <a href="javascript:void(0)" id="showRxDetail" data-id="{{ $rx->id }}" data-customer_id="{{ $rx->customer_id }}" data-document_id="{{ $rx->document_id }}" class="showRxDetail text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Rx Detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                @endcan
                              </div>
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="6">
                              <h4 class="text-center">No record Found</h4>
                            </td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="primaryHospital" role="tabpanel">
                <div class="row">
                  <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead class="bg-info">
                        <tr class="text-center">
                          <th>{{ trans('cruds.hospital.fields.id') }}</th>
                          <th>{{ trans('cruds.hospital.fields.room_no') }}</th>
                          <th>{{ trans('cruds.hospital.fields.h_date') }}</th>
                          <th>{{ trans('cruds.hospital.fields.h_note') }}</th>
                        </tr>
                      </thead>
                      <tbody id="objectHospital">
                        @forelse ($hospitals as $key => $row)
                          <tr id="tr_object_ht_id_{{ $row->id }}">
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->room->room_no }}</td>
                            <td>{{ $row->h_date }}</td>
                            <td>{{ $row->h_note }}</td>
                          </tr>
                          @empty
                            <tr>
                              <td colspan="4">
                                <h4 class="text-center">No record Found</h4>
                              </td>
                            </tr>
                          @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="primaryHospitalTreatment" role="tabpanel">
                {{-- <div class="row">
                  <div class="col-lg-8 d-grid mx-auto">
                    <div class="row">
                      <div class="col-lg-8">
                        <div class="input-group input-daterange mb-3">
                          <input name="from_date" id="from_date" type="text" class="form-control" readonly placeholder="from_date" aria-label="from_date" value="">
                          <span class="input-group-text">TO</span>
                          <input name="to_date" id="to_date" type="text" class="form-control" readonly placeholder="to_date" aria-label="to_date" value="">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <button type="button" class="btn btn-md btn-outline-success filterTreatment">
                          <i class="fadeIn animated bx bx-search-alt"></i> Search
                        </button>
                        <button type="button" class="btn btn-md btn-outline-warning clearFilter">
                          <i class="fadeIn animated bx bx-search-alt"></i> Clear
                        </button>
                      </div>
                    </div>
                  </div>
                </div> --}}
                <div class="row" id="showHospitalTreatment">
                  {{-- @include('admin.document.templates.h.ht_list') --}}
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
                                @forelse ($hnotes as $rows)
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
                                @empty
                                  <tr>
                                    <td colspan="6" align="center">No Record Found</td>
                                  </tr>
                                @endforelse
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
                                @forelse ($hospital_treatments as $key => $rows)
                                  <tr>
                                    <th style="background-color:#c4dad3">
                                      {{ date('d-M-Y',strtotime($rows[0]['ht_date'])) }}
                                    </th>
                                    <td>
                                      @forelse ($rows as $row)
                                        <tr id="tr_object_htd_id_{{ $row->id }}">
                                          <td></td>
                                          <td>{{ $row['ht_time'] }}</td>
                                          <td>
                                            <a id="objectShow" data-bs-toggle="collapse" data-bs-target="#detail{{$row['id'] }}" class="accordion-toggle objectShow {{ $row->htdetails->count()>0? 'text-primary':'text-secondary' }}" data-id="{{ $row['id'] }}" href="javascript:void(0)" style="cursor: {{ $row->htdetails->count()>0?'pointer;':'default;' }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                            {{ $row->product['p_name'] }}
                                            {{-- @if ($row->htdetails->count()>0)
                                              (
                                                @forelse ($row->htdetails as $key => $detail)
                                                  {{$detail->product['p_name']}}({{$detail['qty']}})
                                                @empty
                                                @endforelse
                                              )
                                            @endif --}}
                                          </td>
                                          <td>{{ $row['qty'] }}</td>
                                          <td>{{ $row['duration'] }}</td>
                                          <td>{{ $row['how_to_use'] }}</td>
                                          <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                              @can($prefix.'show')
                                                <a id="objectShow" data-bs-toggle="collapse" data-bs-target="#detail{{$row['id'] }}" class="accordion-toggle objectShow {{ $row->htdetails->count()>0? 'text-primary':'text-secondary' }}" data-id="{{ $row['id'] }}" href="javascript:void(0)" style="cursor: {{ $row->htdetails->count()>0?'pointer;':'default;' }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                              @endcan
                                              @can($prefix.'edit')
                                                <a id="editTreatment" data-id="{{ $row['id'] }}" data-hospitalid="{{ $row['hospital_id'] }}" data-productid="{{ $row['product_id'] }}" href="#" class="editTreatment text-warning" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                                              @endcan
                                              @can($prefix.'delete')
                                                <a id="deleteTreatment" data-id="{{ $row['id'] }}" href="{{ route('admin.'.$documentRoute.'.deleteObjectHT') }}" class="deleteTreatment text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                                              @endcan
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="4" class="hiddenRow">
                                            @include('admin.document.templates.h.more_detail')
                                          </td>
                                        </tr>
                                      @empty

                                      @endforelse
                                    </td>
                                  </tr>
                                @empty
                                  <tr>
                                    <td colspan="6" align="center">No Record Found</td>
                                  </tr>
                                @endforelse
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="primaryOrder" role="tabpanel">
                <div class="row">
                  <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead class="bg-warning">
                        <tr>
                          <th>{{ trans('cruds.order.fields.id') }}</th>
                          <th>{{ trans('cruds.order.fields.order_type') }}</th>
                          <th>{{ trans('cruds.order.fields.customer_id') }}</th>
                          <th>{{ trans('cruds.order.fields.order_date') }}</th>
                          <th>{{ trans('cruds.order.fields.user_id') }}</th>
                          <th>{{ trans('cruds.customer.fields.age') }}</th>
                          <th>{{ trans('cruds.customer.fields.sex') }}</th>
                          <th>{{ trans('global.action') }}</th>
                        </tr>
                      </thead>
                      <tbody id="objectOrder">
                        @forelse ($orders as $order)
                          <tr id="tr_object_id_{{ $order->id }}">
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_type }}</td>
                            <td>{{ $order->customer->name }}</td>
                            <td>{{ date('d-M-Y',strtotime($order->order_date)) }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->customer->sex }}</td>
                            <td>{{ $order->customer->age }}</td>
                            <td>
                              <div class="d-flex align-items-center gap-3 fs-6">
                                @can($prefix.'show')
                                  <a id="objectShow" data-id="{{ $order->id }}" href="{{ route('admin.'.$crudRoutePath.'.previewReceipt',$order->id) }}" target="_blank" class="objectShow text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Preview Report" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                @endcan
                              </div>
                            </td>
                          </tr>
                          @empty
                            <tr>
                              <td colspan="8">
                                <h4 class="text-center">No record Found</h4>
                              </td>
                            </tr>
                          @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
