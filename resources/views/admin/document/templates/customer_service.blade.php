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
      <h5 class="modal-title">Service Form</h5>
    </div>
    <div class="card-body">
      <input type="hidden" name="rx_bio_name" id="rx_bio_name" value="{{ $customer->name }}">
      <input type="hidden" name="rx_bio_customer_code" id="rx_bio_customer_code" value="{{ $customer->customer_code }}">
      <input type="hidden" name="rx_bio_age" id="rx_bio_age" value="{{ $customer->age }}">
      <input type="hidden" name="rx_bio_sex" id="rx_bio_sex" value="{{ $customer->sex }}">
      <input type="hidden" name="rx_bio_customer_id" id="rx_bio_customer_id" value="{{ $customer->id }}">
      <input type="hidden" name="rx_bio_document_id" id="rx_bio_document_id" value="{{$document->id  }}">
      <input type="hidden" name="rx_bio_phone_no" id="rx_bio_phone_no" value="{{$customer->phone_no  }}">
      <input type="hidden" name="rx_bio_address" id="rx_bio_address" value="{{$customer->address  }}">

      <div class="row justify-content-evenly  ">
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
      </div>
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
                    <input readonly value="{{ $customer->name }}" readonly id="name" name="name" class="form-control" type="text" placeholder="{{ trans('cruds.customer.fields.name') }}">
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
            <div class="col-lg-7">
              <div class="form-group mb-2">
                <div class="row">
                  <label for="document_id" class="form-control-label mb-2 col-lg-5"><strong>{{ trans('cruds.document.title_singular') }} {{ trans('cruds.document.fields.id') }}:</strong> </label>
                  <div class="col-lg-7">
                    <input value="{{ $document->id }}" readonly id="document_id" name="document_id" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.id') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
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
                <a id="objectAddTypeA" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Add New" aria-label="Add">+</a>
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
                <a id="objectAddTypeB" href="#" class="btn btn-primary btn-sm text-white px-3" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Add New" aria-label="Add">+</a>
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
                <div class="row">
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
                </div>
                <div class="row" id="showHospitalTreatment">
                  @include('admin.document.templates.h.ht_list')
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
      {{-- </form> --}}
      <div id="order_receipt">
      </div>
    </div>
  </div>

{{-- all modal --}}
  @include('admin.document.templates.bio.showBioModal')
  @include('admin.document.templates.bio.addBioModal')
  @include('admin.document.templates.bio.pBioModal')
  @include('admin.document.templates.more.moreModal')
  @include('admin.document.templates.bio.report.bio_histories')
  @include('admin.document.templates.rx.showRxModal')
  @include('admin.document.templates.rx.showRxDetailModal')
  @include('admin.document.templates.rx.showRxNurseModal')
  @include('admin.document.templates.rx.editRxNurseModal')
  @include('admin.document.templates.order.orderModal')
  @include('admin.document.templates.order.printModal')
  @include('admin.document.templates.lifeSignModal')
  @include('admin.document.templates.editLifeSignModal')
  <datalist id="how_to_uses">
    @foreach ($how_to_uses as $row)
      <option value="{{$row->name}}">
    @endforeach
  </datalist>
@endsection

@push('scripts')
  <script src="{{assetUrl()}}/plugins/datatable/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="{{assetUrl()}}/plugins/datatable/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
  <script src="{{assetUrl()}}/plugins/select2/js/select2.min.js" crossorigin="anonymous"></script>
  <script src="{{assetUrl()}}/plugins/toastrjs/toastr.min.js" crossorigin="anonymous"></script>
  <script src="{{assetUrl()}}/plugins/sweetalert2/sweetalert2.all.min.js" crossorigin="anonymous"></script>
  <script src="{{assetUrl()}}/plugins/momentjs/moment.min.js" crossorigin="anonymous"></script>
  <script src="{{assetUrl()}}/plugins/jquery-datetime/jquery.datetimepicker.full.min.js" crossorigin="anonymous"></script>
  <script src="{{asset('assets/backend/')}}/plugins/summernote/summernote-lite.min.js"></script>
  <script>
    var products = {!! json_encode($products)  !!};
    $(function(){
      "use strict";
      $('#from_date').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
        this.setOptions({
          maxDate:$('#to_date').val()?$('#to_date').val():false
        })
        },
        timepicker:false
      });
      $('#to_date').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
        this.setOptions({
          minDate:$('#from_date').val()?$('#from_date').val():false
        })
        },
        timepicker:false
      });
      $('.single-select').select2({
          dropdownParent: $('#customerModal'),
          theme: 'bootstrap4',
          width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
          placeholder: $(this).data('placeholder'),
          allowClear: Boolean($(this).data('allow-clear')),
      });
      $('.type-select').select2({
        dropdownParent: $('#lifeSignModal'),
        theme: 'bootstrap4',
        // theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
      });
      // $('.order_product').select2({
      //   dropdownParent: $('#orderObjectModal'),
      //   theme: 'bootstrap4',
      //   width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      //   placeholder: $(this).data('placeholder'),
      //   allowClear: Boolean($(this).data('allow-clear')),
      // });
      $('#customer_history').select2({
        dropdownParent: $('#bioHistoryModal'),
        theme: 'bootstrap4',
        // theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
      });
      $('.product_id,.more_product').select2({
        dropdownParent: $('#addNewTreatmentObjectModal'),
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
      });
      $('#type_date, #rx_date').datetimepicker({
        format: 'd-m-Y H:i:s',
      });
    });
    $(function(){
      $('body').on('change','#is_other',function(){
        if($(this).prop('checked')==true){
          $('#showhide').removeClass('d-none');
        } else {
          $('#showhide').addClass('d-none');
        }
      });
    });
  </script>

  <script>
    $('#medicine_note, #note').summernote({
      height: 200,
      focus: true,
      tabsize: 2,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol','paragraph']],
        ['height', ['height']]
      ]
    });
    $('#medicine_note, #note').summernote('lineHeight', 2);
  </script>

  {{-- Add remove input fields Hospital Treatment--}}
  <script>
    $(document).ready(function(){
      var maxField = 10; //Input fields increment limitation
      // var addButton = $('.add_button'); //Add button selector
      var wrapper = $('.field_wrapper'); //Input field wrapper
      var $fieldHTML = $(`
        <div class="mb-2">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="more_product" class="form-control-label mb-2">{{ trans('cruds.ht.fields.product_id') }}: <span class="text-danger">*</span></label>
                <select id="more_product" name="more_product[]" class="form-control more_product"  style="width: 100%" data-placeholder="Select Medicine">
                  <option value="">{{ trans('global.select') }} {{ trans('cruds.ht.fields.product_id') }}</option>
                  @foreach ($products as $key => $row)
                    <option value="{{ $row->id }}">{{ $row->p_name }}</option>
                  @endforeach
                </select>
                <span class="text-danger error-text more_product_error"></span>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="form-group mb-2">
                <label for="more_qty" class="form-control-label mb-2">{{ trans('cruds.ht.fields.qty') }}:</label>
                <input id="more_qty" name="more_qty[]" class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.qty') }}">
                <span class="text-danger error-text more_qty_error"></span>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="form-group mb-2">
                <label for="more_how_to_use" class="form-control-label mb-2">{{ trans('cruds.ht.fields.how_to_use') }}:</label>
                <input list="how_to_uses" id="more_how_to_use" name="more_how_to_use[]"  class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.how_to_use') }}">
                <span class="text-danger error-text more_how_to_use_error"></span>
              </div>
            </div>
            <div class="col-lg-2 mt-4">
              <label for="">&nbsp;</label>
              <button type="button" class="btn btn-sm btn-danger mt-2 remove_button_treatment"><i class="fadeIn animated bx bx-trash"></i> Remove</button>
            </div>
          </div>
        </div>
      `);
      var loopcount = 1; //Initial field counter is 1

      //Once add button is clicked
      $('body').on('click','.add_more_treatment',function(){
        var $clone = $fieldHTML.clone();
        //Check maximum number of input fields
        if(loopcount < maxField){
          $(wrapper).append($clone); //Add field html
          loopcount++; //Increment field counter
        }

        $clone.find('.more_product').select2({
          dropdownParent: $('#addNewTreatmentObjectModal'),
          theme: 'bootstrap4',
          width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
          placeholder: $(this).data('placeholder'),
          allowClear: Boolean($(this).data('allow-clear')),
        });
      });

      //Once remove button is clicked
      $(wrapper).on('click', '.remove_button_treatment', function(e){
        e.preventDefault();
        $(this).parent().parent('div').remove(); //Remove field html
        loopcount--; //Decrement field counter
      });
    });
  </script>

  {{-- search html in table using jquery --}}
  <script>
    $(document).ready(function(){
      $('.doctor_order_name').keyup(function(){
        search_table($(this).val());
      });
      function search_table(value){
        $('.doctor_description_list tbody tr').each(function(){
          var found = 'false';
          $(this).each(function(){
          if($(this).find("td:eq(1) input[type='text']").val().toLowerCase().indexOf(value.toLowerCase()) >= 0)
          {
            found = 'true';
          }
          });
          if(found == 'true')
          {
            $(this).show();
          }
          else
          {
            $(this).hide();
          }
        });
      }
    });
  </script>

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
      // autocomplete textbox how to use
        // $(document).on('keyup','#how_to_use',function(){
        //   var parent = $(this).parents('tr');
        //   var query = $(this).val();
        //   if(query != '')
        //   {
        //     $.ajax({
        //       url:"{{ route('admin.documents.search_how_to_use') }}",
        //       method:"POST",
        //       data:{query:query},
        //       success:function(res){
        //         parent.find('#search_how_to_use').fadeIn();
        //         parent.find('#search_how_to_use').html(res);
        //       }
        //     });
        //   }
        // });
        // $(document).on('click', 'li', function(){
        //   $(this).parents('tr').find('#how_to_use').val($(this).text());
        //   $(this).parents('tr').find('#search_how_to_use').fadeOut();
        // });
      // javascript on enter event on qty filed
      $(document).on('keydown','.canenter',function(e){
        if (e.keyCode == 13) {
          var $this = $(this),
          index = $this.closest('td').index();
          $this.closest('tr').next().find('td').eq(index).find('input').focus().select();
          e.preventDefault();
        }
      });

      //jquery ui autocomplete script
      $(document).on('focus','.autocomplete_order_product',function(){
        type = $(this).data('type');
        if(type =='p_name')autoType='p_name';
        $(this).autocomplete({
          minLength: 0,
          source: function( request, response ) {
            $.ajax({
                url: "{{ route('admin.documents.searchProduct') }}",
                dataType: "json",
                data: {
                  term : request.term,
                },
                success: function(res) {
                  var resutl = $.map(res, function (item) {
                    return {
                      label: item[autoType],
                      value: item[autoType],
                      data : item
                    }
                  });
                  response(resutl)
                }
            });
          },
          select: function( event, ui ) {
              var data = ui.item.data;
              id_arr = $(this).attr('id');
              id = id_arr.split("_");
              elementId = id[id.length-1];
              // console.log(id_arr);
              // console.log(id);
              // console.log(elementId);
              $('#order_product_id_'+elementId).val(data.id);
              $('#unit_'+elementId).val(data.unit);
              $('#strength_'+elementId).val(data.strength);
          }
        });
      });
      $(document).on('focus','.autocomplete_injection_product',function(){
        type = $(this).data('type');
        if(type =='p_name')autoType='p_name';
        $(this).autocomplete({
          minLength: 0,
          source: function( request, response ) {
            $.ajax({
                url: "{{ route('admin.documents.searchProduct') }}",
                dataType: "json",
                data: {
                  term : request.term,
                },
                success: function(res) {
                  var resutl = $.map(res, function (item) {
                    return {
                      label: item[autoType],
                      value: item[autoType],
                      data : item
                    }
                  });
                  response(resutl)
                }
            });
          },
          select: function( event, ui ) {
              var data = ui.item.data;
              id_arr = $(this).attr('id');
              id = id_arr.split("_");
              elementId = id[id.length-1];
              $('#injection_product_id_'+elementId).val(data.id);
              $('#injection_unit_'+elementId).val(data.unit);
              $('#injection_strength_'+elementId).val(data.strength);
          }
        });
      });

      $(document).on('click','.filterTreatment',function(e){
        e.preventDefault();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(from_date != '' &&  to_date != ''){
          filterTreatment(from_date, to_date);
        } else {
          filterTreatment()
        }
      });
      function filterTreatment(from_date = '', to_date = ''){
        $.post("{{route('admin.documents.filterTreatment')}}",{from_date:from_date,to_date:to_date},function(res){
          $(document).find('#showHospitalTreatment').empty().append(res.hts);
        });
      }
      $(document).on('click','.clearFilter',function(e){
        $('#from_date').val('');
        $('#to_date').val('');
        $(document).find('#showHospitalTreatment').empty();
        filterTreatment()
      });

      $("#moreObjectModal").on('hide.bs.modal', function(){
        location.reload();
      });

      $("#addHospitalObjectModal").on('hide.bs.modal', function(){
        location.reload();
      });
      $("#orderObjectModal").on('hide.bs.modal', function(){
        location.reload();
      });
      $("#newHospitalTreatmentObjectModal").on('hide.bs.modal', function(){
        location.reload();
      });

       $('body').on('click','a#objecPBio',function(e){
        e.preventDefault();
        $('#pBioModal').find('#pbiocustomer_code').val($('#rx_bio_customer_code').val());
        $('#pBioModal').find('#pbioname').val($('#rx_bio_name').val());
        $('#pBioModal').find('#pbioage').val($('#rx_bio_age').val());
        $('#pBioModal').find('#pbiosex').val($('#rx_bio_sex').val());
        $('#pBioModal').find('#pbiophone_no').val($('#rx_bio_phone_no').val());
        $('#pBioModal').find('#pbioaddress').val($('#rx_bio_address').val());
        $('#pBioModal').find('#pbiocustomer_id').val($('#rx_bio_customer_id').val());
        $('#pBioModal').find('#pbiodocument_id').val($('#rx_bio_document_id').val());
        var customer_id = $('#rx_bio_customer_id').val();
        $.ajax({
          type : 'get',
          dataType: 'JSON',
          url: '{{ route("admin.documents.getPBio") }}',
          data: {customer_id:customer_id},
          success: function (res) {
            $('#pBioModal').find('#showpBioList').empty().append(res.items);
            $('#pBioModal').find('#pBioList').empty().append(res.pbio_infos);
          },
          error: function (error) {
            console.log('Error:', error);
          }
        });
        $('#pBioModal').modal('show');
      });

      $('#frmPBio').on('submit',function(e){
        e.preventDefault();
        var actionUrl = $(this).attr('action');
        var method = $(this).attr('method')
        var modal = $('#pBioModal');
        $('#btnObjectSave').html('Processing..');
        $('#btnObjectUpdate').html('Processing..');
        $.ajax({
          type: method,
          url: actionUrl,
          data: new FormData(this),
          dataType:'json',
          processData:false,
          contentType:false,
          beforeSend:function(){
            $(document).find('span.error-text').text('');
          },
          success: function (res) {
            if(res.status==400){
              $.each(res.error, function(prefix, val){
                $('span.'+prefix+'_error').text(val[0]);
              });
            } else {
              // modal.modal('hide');
              $('#pBioModal').find('#show_pbio_info').append(res.html);
              $(document).find('#showItemTypeList').empty();
              $(document).find('#showItemList').empty();
              toastr.success(res.success);
            }
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html(`{{ trans('global.save') }}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
          }
        });
      });

      $('body').delegate('#deletePBio','click',function(e){
        e.preventDefault();
        var $pbio_id = $(this).data('id');
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
                'pbio_id':$pbio_id
              },
              success: function (data) {
                console.log(data)
                $("#tr_pbio_info_id_" + $pbio_id ).remove();
                toastr.success(data.success);
              },
              error: function (data) {
                console.log('Error:', data);
              }
            });
          }
        })
      });

      $('#frmProtocol').on('submit',function(e){
        e.preventDefault();
        var actionUrl = $(this).attr('action');
        var method = $(this).attr('method')
        var modal = $('#moreObjectModal');
        $('#btnObjectSave').html('Processing..');
        $('#btnObjectUpdate').html('Processing..');
        $.ajax({
          type: method,
          url: actionUrl,
          data: new FormData(this),
          dataType:'json',
          processData:false,
          contentType:false,
          beforeSend:function(){
            $(document).find('span.error-text').text('');
          },
          success: function (res) {
            if(res.status==400){
              $.each(res.error, function(prefix, val){
                $('span.'+prefix+'_error').text(val[0]);
              });
            } else {
              var url = '{{ route("admin.documents.receiptProtocol", ":id") }}';
              url = url.replace(':id', res.data.id);
              window.open(url,'_blank');
              modal.modal('hide');
              toastr.success(res.success);
            }
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html(`{{ trans('global.save') }}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
          }
        });
      });

      $('#frmMedicine').on('submit',function(e){
        e.preventDefault();
        var actionUrl = $(this).attr('action');
        var method = $(this).attr('method')
        var modal = $('#moreObjectModal');
        $('#btnObjectSave').html('Processing..');
        $('#btnObjectUpdate').html('Processing..');
        $.ajax({
          type: method,
          url: actionUrl,
          data: new FormData(this),
          dataType:'json',
          processData:false,
          contentType:false,
          beforeSend:function(){
            $(document).find('span.error-text').text('');
          },
          success: function (res) {
            if(res.status==400){
              $.each(res.error, function(prefix, val){
                $('span.'+prefix+'_error').text(val[0]);
              });
            } else {
              var url = '{{ route("admin.documents.receiptMedicine", ":id") }}';
              url = url.replace(':id', res.data.id);
              window.open(url,'_blank');
              modal.modal('hide');
              toastr.success(res.success);
            }
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html(`{{ trans('global.save') }}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
          }
        });
      });

      $("body").delegate( "#deleteObject", "click", function(e) {
        e.preventDefault();
        var fileId = $(this).data('id');
        var fileRxid = $(this).data('rx_id');
        var actionUrl = `{{ route('admin.documents.deleteFile') }}`;
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
              type: 'POST',
              url: actionUrl,
              data: {
                'id':fileId,
                'rx_id':fileRxid,
              },
              dataType: 'json',
              beforeSend:function(){
                $(document).find('span.error-text').text('');
              },
              success: function (res) {
                if(res.status==400){
                  $.each(res.error, function(prefix, val){
                    $('span.'+prefix+'_error').text(val[0]);
                  });
                } else {
                  $('#editRxNurseModal').find('#doctorDescription').empty().append(res.nurse_form);
                  toastr.success(res.success);
                }
              },
              error: function (error) {
                console.log('Error:', error);
              }
            });
          }
        })
      });

      $('body').on('click','#addDescription',function(e){
        e.preventDefault();
        var doctor_order_name = $('.doctor_order_name').val();
        $.ajax({
          type : 'POST',
          dataType: 'JSON',
          url :`{{ route('admin.documents.storeDoctorOrder') }}`,
          data: {
            'doctor_order_name':doctor_order_name
          },
          success:function(res){
            if(res.status==400){
              $.each(res.error, function(prefix, val){
                $('span.'+prefix+'_error').text(val[0]);
              });
            } else {
              toastr.success(res.success);
              $('#doctorDescription').empty().append(res.doctor_descriptions);
            }
          },
          error:function(err){
            console.log(err);
          }
        })
      });

      $('#frmAddNewRx').on('submit',function(e){
        e.preventDefault();
        var actionUrl = $(this).attr('action');
        var method = $(this).attr('method')
        var modal = $('#showBioModal');
        $('#btnObjectSave').html('Processing..');
        $('#btnObjectUpdate').html('Processing..');
        $.ajax({
          type: method,
          url: actionUrl,
          data: new FormData(this),
          dataType: 'json',
          processData:false,
          dataType:'json',
          contentType:false,
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
              $('#showRxModal').modal('hide');
            }
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html(`{{ trans('global.save')}}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
          }
        });
      });

      $('body').on('click','a#showDetailForm',function(e){
        e.preventDefault();
        var bioId = $(this).data('id');
        var bio_customerId = $(this).data('customerid');
        var bio_documentId = $(this).data('documentid');
        $.ajax({
          type : 'get',
          dataType: 'JSON',
          url: '{{ route("admin.documents.getRx") }}',
          data: {
            'bio_id' : bioId,
            'customer_id' : bio_customerId,
            'document_id' : bio_documentId,
          },
          success: function (res) {
            $('#showRxNurseModal').find('#nurse_form').empty().append(res.nurse_form);
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html(`{{ trans('global.save')}}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
          }
        });
      });

      $('#frmAddNewRxNurse').on('submit',function(e){
        e.preventDefault();
        var actionUrl = $(this).attr('action');
        var method = $(this).attr('method')
        var modal = $('#showRxNurseModal');
        $('#btnObjectSave').html('Processing..');
        $('#btnObjectUpdate').html('Processing..');
        $.ajax({
          type: method,
          url: actionUrl,
          data: new FormData(this),
          dataType: 'json',
          processData:false,
          dataType:'json',
          contentType:false,
          beforeSend:function(){
            $(document).find('span.error-text').text('');
          },
          success: function (res) {
            if(res.status==400){
              $.each(res.error, function(prefix, val){
                $('span.'+prefix+'_error').text(val[0]);
              });
            } else {
              console.log(res);
              $('#showRxNurseModal').find('#nurse_detail').empty().append(res.rx_nurses);
              $('#showRxNurseModal').modal('hide');
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

      $('#frmeditRxNurse').on('submit',function(e){
        e.preventDefault();
        var actionUrl = $(this).attr('action');
        var method = $(this).attr('method')
        var modal = $('#showRxNurseModal');
        $('#btnObjectSave').html('Processing..');
        $('#btnObjectUpdate').html('Processing..');
        $.ajax({
          type: method,
          url: actionUrl,
          data: new FormData(this),
          dataType: 'json',
          processData:false,
          dataType:'json',
          contentType:false,
          beforeSend:function(){
            $(document).find('span.error-text').text('');
          },
          success: function (res) {
            if(res.status==400){
              $.each(res.error, function(prefix, val){
                $('span.'+prefix+'_error').text(val[0]);
              });
            } else {
              $('#editRxNurseModal').modal('hide');
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

      $('body').on('change','#bio_item_name',function(e){
        var id= $(this).val();
        if($(this).prop('checked')==true){
          $('.bio_result[data-id="' + id + '"]').attr('disabled', false)
          $('.bio_result[data-id="' + id + '"]').val(null)
        } else {
          $('.bio_result[data-id="' + id + '"]').attr('disabled', true)
          $('.bio_result[data-id="' + id + '"]').val(null)
        }
      });

      $('body').on('change','#doctor_order',function(e){
        var id= $(this).val();
        if($(this).prop('checked')==true){
          $('.doctor_description[data-id="' + id + '"]').attr('disabled', false)
        } else {
          $('.doctor_description[data-id="' + id + '"]').attr('disabled', true)
        }
      });

      $('body').on('click','.btnGroup',function(e){
        e.preventDefault();
        var item_group_id = $(this).attr('id');
        $('#item_group_id').val(item_group_id);
        $.ajax({
          type : 'get',
          dataType: 'JSON',
          url: '{{ route("admin.documents.getGroupType") }}',
          data: {
            'item_group_id' : item_group_id,
          },
          success: function (res) {
            $('#pBioModal').find('#showItemTypeList').empty().append(res.items);
          },
          error: function (error) {
            console.log('Error:', error);
          }
        });
      })

      $(document).on('click','.btnItemType',function(e){
        var item_type_id = $(this).attr('id');
        $('#item_type_id').val(item_type_id);
        $.ajax({
          type : 'get',
          dataType: 'JSON',
          url: '{{ route("admin.documents.getItemTypeByName") }}',
          data: {
            'item_type_id' : item_type_id,
          },
          success: function (res) {
            $('#pBioModal').find('#showItemList').empty().append(res.items);
          },
          error: function (error) {
            console.log('Error:', error);
          }
        });
      })

      $(document).on('click','#btnPrintBio',function(e){
        e.preventDefault();
        var customerID = $('#customer_id').val();
        var documentID = $('#document_id').val();
        var url = `{{ route("admin.documents.bio.receipt", [":document_id",":customer_id"]) }}`;
        url = url.replace(':document_id',documentID)
        url = url.replace(':customer_id', customerID);
        window.open(url,'_blank');
      });

      $(document).on('change','#order_product', function (){
        var product_id = $(this).val();
        var parent = $(this).parents('tr');
        if(product_id==null){
          return false;
        } else {
          $.get("{{route('admin.documents.getProductByID')}}",{product_id:product_id},function(res){
            parent.find('#unit').val(res.product.unit);
            parent.find('#strength').val(res.product.strength);
            parent.find('#qty').focus();
          });
        }
      });

      $(document).on('change','#injection_product', function (){
        var product_id = $(this).val();
        var parent = $(this).parents('tr');
        if(product_id==null){
          return false;
        } else {
          $.get("{{route('admin.documents.getProductByID')}}",{product_id:product_id},function(res){
            parent.find('#injection_unit').val(res.product.unit);
            parent.find('#injection_strength').val(res.product.strength);
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

    });
  </script>

@endpush
