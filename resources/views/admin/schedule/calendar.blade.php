@extends('admin.admin_layout')

@push('select2')
  <link href="{{ assetUrl() }}/plugins/select2/css/select2.min.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" />
  <style>
    .fc-state-default{
      background: #3461ff;
      color: #f3f3f3;
    }
    .fc-state-disabled{
      background: #00c324;
      color: #ffffff;
    }
    .fc-state-active{
      background: #00c324;
      color: #ffffff;
    }
  </style>
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
    <div class="card-body" id="showCalendar">

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
  <script>
    $(document).ready(function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });
  </script>
  <script>
    $(document).ready(function () {
      moment.updateLocale('en', {
        week: {dow: 1} // Monday is the first day of the week
      })
      // page is now ready, initialize the calendar...
      events ={!! json_encode($events) !!};
      $('#showCalendar').fullCalendar({
        // put your options and callbacks here
        header: {
          'left':'prev, next, today',
          'center': 'title',
          'right' : 'month, agendaWeek, agendaDay, listWeek'
        },
        events: events,
        defaultView: 'agendaWeek',
        editable: true,
        selectable:true,
        selectHelper:true,
        select:function(start, end, jsEvent, view){
          console.log(start)
        },
        eventClick: function(calEvent, jsEvent, view) {
          console.log(calEvent)
        },
        eventResize: function(event, delta, revertFunc) {
          console.log(event.title + " was dropped on " + event.start.format());
        },
        eventDrop: function(event, delta, revertFunc) {
          console.log(event.title + " was dropped on " + event.start.format());
          revertFunc();
        }
      })
    })
  </script>
@endpush
