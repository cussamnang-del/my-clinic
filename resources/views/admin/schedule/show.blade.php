@extends('admin.admin_layout')

@push('select2')
  <link href="{{ assetUrl() }}/plugins/select2/css/select2.min.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" />
@endpush

@push('styles')
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/toastrjs/toastr.min.css">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/bootstrap-datetime/css/bootstrap-datetimepicker.css">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/datepicker/css/bootstrap-datepicker.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
@endpush

@section('content')
  @section('breadcrumb',trans('cruds.schedule.title'))
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>{{ trans('global.list') }} {{ trans('cruds.schedule.title') }}
        @can($prefix.'create')
          <a id="addNewObject" href="{{route('admin.schedules.create')}}" class="btn btn-sm btn-outline-primary px-4 radius-30" style="float: right;">
            <i class='bx bxs-plus-square'></i> {{ trans('global.add') }} {{ trans('global.new') }}
          </a>
        @endcan
      </h4>
    </div>
    <div class="card-body">
      <div class="mb-2">
        <table class="table table-bordered table-striped">
          <tbody>
            <tr>
              <th width="30%">
                {{ trans('cruds.schedule.fields.id') }}
              </th>
              <td>
                {{ $schedule->id }}
              </td>
            </tr>
            <tr>
              <th>
                {{ trans('cruds.schedule.fields.title') }}
              </th>
              <td>
                {{ $schedule->title ?? '' }}
              </td>
            </tr>
            <tr>
              <th>
                {{ trans('cruds.schedule.fields.start_time') }}
              </th>
              <td>
                {{ $schedule->start_time }}
              </td>
            </tr>
            <tr>
              <th>
                {{ trans('cruds.schedule.fields.finish_time') }}
              </th>
              <td>
                {{ $schedule->finish_time }}
              </td>
            </tr>
            <tr>
              <th>
                {{ trans('cruds.schedule.fields.customer_id') }}
              </th>
              <td>
                {{ $schedule->customer->name }}
              </td>
            </tr>
            <tr>
              <th>
                {{ trans('cruds.schedule.fields.user_id') }}
              </th>
              <td>
                {{ $schedule->user->name }}
              </td>
            </tr>
            <tr>
              <th>
                {{ trans('cruds.schedule.fields.desr') }}
              </th>
              <td>
                {{ $schedule->desr }}
              </td>
            </tr>
            <tr>
              <th>
                {{ trans('cruds.schedule.fields.status') }}
              </th>
              <td>
                {{ $schedule->status }}
              </td>
            </tr>
          </tbody>
        </table>
        <div class="text-center">
          <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-warning px-3 radius-30">
            <i class="fadeIn animated bx bx-window-close"></i>&nbsp;{{ trans('global.back') }}
          </a> &nbsp;&nbsp;&nbsp;&nbsp;
          <a href="{{ route('admin.schedules.edit',$schedule->id) }}" class="btn btn-sm btn-outline-success px-3 radius-30">
            <i class="fadeIn animated bx bx-plus-circle"></i>
            &nbsp;{{ trans('global.edit') }}
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ assetUrl() }}/plugins/select2/js/select2.min.js"></script>
  <script src="{{ assetUrl() }}/plugins/toastrjs/toastr.min.js"></script>
  <script src="{{ assetUrl() }}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="{{ assetUrl() }}/plugins/momentjs/moment.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/bootstrap-datetime/js/bootstrap-datetimepicker.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/datepicker/js/bootstrap-datepicker.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/fullcalendar/fullcalendar.min.js"></script>
@endpush
