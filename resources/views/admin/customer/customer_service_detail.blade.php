@extends('admin.admin_layout')

@push('select2')
  <link href="{{ asset('assets/backend') }}/plugins/select2/css/select2.min.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush

@push('styles')
  <link href="{{ asset('assets/backend') }}/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/backend') }}/css/toggle.css">
  <link rel="stylesheet" href="{{ asset('assets/backend') }}/plugins/toastrjs/toastr.min.css">
  <link rel="stylesheet" href="{{ asset('assets/backend') }}/plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="{{ asset('assets/backend') }}/plugins/bootstrap-datetime/css/bootstrap-datetimepicker.css">
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
  </style>
@endpush

@section('content')
  @section('breadcrumb',trans('cruds.customer_history.title'))
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-xl-6 col-lg-6">
          <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>{{ trans('cruds.customer_history.title_singular') }}</h4>
        </div>
        <div class="col-xl-6 col-lg-6">

        </div>
      </div>
      </div>
    </div>
    <div class="card-body" id="customer_service_detail">
      <div class="table-responsive">
        <table id="datatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>{{ trans('cruds.document.fields.id') }}</th>
              <th>{{ trans('cruds.document.title_singular') }}</th>
              <th>{{ trans('cruds.document.fields.user_id') }}</th>
              <th>{{ trans('cruds.documentDetail.fields.service_name') }}</th>
              <th>{{ trans('global.status') }}</th>
            </tr>
          </thead>
          <tbody id="service_detail_list">
            @foreach ($documents as $document)
              @foreach ($document->details as $detail)
                <tr id="tr_object_id_{{ $detail->id }}">
                  <td>{{ $detail->id }}</td>
                  <td>{{ $detail->document_id }}</td>
                  <td>{{ $detail->user->name }}</td>
                  <td>{{ $detail->service_name }}</td>
                  <td>
                    <input id="status" name="status" data-id="{{ $detail->id }}" {{ $detail->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
                  </td>
                </tr>
              @endforeach
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('assets/backend') }}/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/select2/js/select2.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/toastrjs/toastr.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/momentjs/moment.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/bootstrap-datetime/js/bootstrap-datetimepicker.min.js"></script>
  <script>
    $(function () {
      "use strict";
      $('[data-bs-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function () {
      $('body').on('change','.ace-switch',function(e){
        var object_id = $(this).data('id');
        var status = $(this).prop('checked')==true ? 1 :0 ;
        $.ajax({
          type : 'GET',
          dataType: 'JSON',
          url :`{{ route('admin.histories.changeStatus') }}`,
          data: {
            'status':status,
            'object_id':object_id
          },
          success:function(res){
            toastr.success(res.success);
          },
          error:function(err){
            console.log(err);
          }
        })
      });
    });
  </script>
@endpush
