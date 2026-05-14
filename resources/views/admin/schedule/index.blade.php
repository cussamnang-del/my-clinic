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
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/bootstrap-datetime/css/bootstrap-datetimepicker.css">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/datepicker/css/bootstrap-datepicker.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
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
  @section('breadcrumb',trans('cruds.item_type.title'))
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>{{ trans('global.list') }} {{ trans('cruds.item_type.title') }}
        @can($prefix.'create')
          <a id="addNewObject" href="{{route('admin.schedules.create')}}" class="btn btn-sm btn-outline-primary px-4 radius-30" style="float: right;">
            <i class='bx bxs-plus-square'></i> {{ trans('global.add') }} {{ trans('global.new') }}
          </a>
        @endcan
      </h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="datatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>{{ trans('cruds.schedule.fields.id') }}</th>
              <th>{{ trans('cruds.schedule.fields.title') }}</th>
              <th>{{ trans('cruds.schedule.fields.start_time') }}</th>
              <th>{{ trans('cruds.schedule.fields.finish_time') }}</th>
              <th>{{ trans('cruds.schedule.fields.customer_id') }}</th>
              <th>{{ trans('cruds.schedule.fields.user_id') }}</th>
              <th>{{ trans('cruds.schedule.fields.desr') }}</th>
              <th>{{ trans('global.status') }}</th>
              <th>{{ trans('global.action') }}</th>
            </tr>
          </thead>
          <tbody id="objectList">
            @foreach ($schedules as $row)
              <tr id="tr_object_id_{{ $row->id }}">
                <td>{{ $row->id }}</td>
                <td>{{ $row->title }}</td>
                <td>{{ date('d-M-Y H:i',strtotime($row->start_time)) }}</td>
                <td>{{ date('d-M-Y H:i',strtotime($row->finish_time)) }}</td>
                <td>{{$row->customer->name}}</td>
                <td>{{$row->user->name}}</td>
                <td>{{$row->desr}}</td>
                <td>
                  {{$row->status}}
                </td>
                <td>
                  @include('admin.templates.crudAction')
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>{{ trans('cruds.schedule.fields.id') }}</th>
              <th>{{ trans('cruds.schedule.fields.title') }}</th>
              <th>{{ trans('cruds.schedule.fields.start_time') }}</th>
              <th>{{ trans('cruds.schedule.fields.finish_time') }}</th>
              <th>{{ trans('cruds.schedule.fields.customer_id') }}</th>
              <th>{{ trans('cruds.schedule.fields.user_id') }}</th>
              <th>{{ trans('cruds.schedule.fields.desr') }}</th>
              <th>{{ trans('global.status') }}</th>
              <th>{{ trans('global.action') }}</th>
            </tr>
          </tfoot>
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
  <script src="{{ assetUrl() }}/plugins/momentjs/moment.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/bootstrap-datetime/js/bootstrap-datetimepicker.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" crossorigin="anonymous"></script>
  <script>
    $(function() {
      "use strict";
      $(document).ready(function() {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        var table = $('#datatable').DataTable( {
          lengthChange: false,
          buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );
        table.buttons().container()
        .appendTo( '#datatable_wrapper .col-md-6:eq(0)' );

        $('body').on('click', '.objectDelete', function (e) {
          e.preventDefault();
          var object_id = $(this).data("id");
          var link = $(this).attr("href");
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
                type: "DELETE",
                url:link,
                success: function (data) {
                  console.log(data);
                  $("#tr_object_id_" + object_id).remove();
                  toastr.success(data.success);
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });
            }
          })
        });
      });
    });
  </script>
@endpush
