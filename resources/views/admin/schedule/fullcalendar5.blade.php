@extends('admin.admin_layout')

@push('select2')
  <link href="{{ assetUrl() }}/plugins/select2/css/select2.min.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
  <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
@endpush

@push('styles')
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/toastrjs/toastr.min.css">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/bootstrap-datetime/css/bootstrap-datetimepicker.css">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/fullcalendar5/main.css">
@endpush

@section('content')
  @section('breadcrumb',trans('cruds.item.title'))
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>{{ trans('global.list') }} {{ trans('cruds.item.title') }}
        {{-- @can($prefix.'create') --}}
          <button id="addNewObject" type="button" class="btn btn-sm btn-outline-primary px-4 radius-30" style="float: right;" data-bs-toggle="modal" data-bs-target="#crudObjectModal">
            <i class='bx bxs-plus-square'></i> {{ trans('global.add') }} {{ trans('global.new') }}
          </button>
        {{-- @endcan --}}
      </h4>
    </div>
    <div class="card-body">
      <div id='showCalendar'></div>
    </div>
  </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/backend') }}/plugins/select2/js/select2.min.js"></script>
<script src="{{ asset('assets/backend') }}/plugins/toastrjs/toastr.min.js"></script>
<script src="{{ asset('assets/backend') }}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="{{ assetUrl() }}/plugins/momentjs/moment.min.js" crossorigin="anonymous"></script>
<script src="{{ assetUrl() }}/plugins/bootstrap-datetime/js/bootstrap-datetimepicker.min.js" crossorigin="anonymous"></script>
<script src="{{ assetUrl() }}/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" crossorigin="anonymous"></script>
<script src="{{ asset('assets/backend') }}/plugins/fullcalendar5/main.js"></script>
  {{-- full calendar script --}}
  <script>
    $(document).ready(function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var html = {!! json_encode($html)  !!};
      var schedules = {!!json_encode($events)!!}
      $('body').append(html)

    // initialize the calendar
    var calendar = new FullCalendar.Calendar(document.getElementById('showCalendar'), {
      headerToolbar: {
        start: 'prev,next today',
        center: 'title',
        end: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      eventTimeFormat: { // like '14:30:00'
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      },
      slotLabelFormat:{
        hour: 'numeric',
        minute: '2-digit',
        hour12: false
      },
      firstDay :1,
      firstDayOfWeek:1,
      weekNumbers: true,
      events:schedules,
      selectable: true,
      selectLongPressDelay: 200,
      editable: true,
      droppable: true,
      select: function(arg) {
          $('#crudObjectModal').find('.datetime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            locale: 'en',
            sideBySide: true,
            stepping: 15,
            icons: {
              up: 'bx bx-chevron-up-circle',
              down: 'bx bx-chevron-down-circle',
              previous: 'bx bx-chevron-left-circle',
              next: 'bx bx-chevron-right-circle'
            }
          }).on('dp.change', function(e){
            if( !e.oldDate || !e.date.isSame(e.oldDate, 'day')){
              $(this).data('DateTimePicker').hide();
            }
          });
          $('#ap_start_date').val(moment(arg.start).format('YYYY-MM-DD HH:mm'));
          $('#ap_end_date').val(moment(arg.end).format('YYYY-MM-DD HH:mm'));
          $('.single-select').select2({
            dropdownParent: $('#crudObjectModal'),
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
          });
          //color picker with addon
          $('.ap_color').colorpicker()
          $('#crudObjectModal').find('.modal-title').html('Add New Schedule');
          $('#crudObjectModal').modal('show')

          $('#frmCrudObject').on('submit',function(e){
            e.preventDefault();
            var actionUrl = $(this).attr('action');
            var ap_title = $(this).find('#ap_title').val();
            var ap_start_date = $(this).find('#ap_start_date').val();
            var ap_end_date = $(this).find('#ap_end_date').val();
            var customer_id = $(this).find('#customer_id').val();
            var user_id = $(this).find('#user_id').val();
            var desr = $(this).find('#desr').val();
            var ap_color = $(this).find('#ap_color').val();
            $.ajax({
              type: 'POST',
              url: actionUrl,
              data: { ap_title:ap_title,
                      ap_start_date:ap_start_date,
                      ap_end_date:ap_end_date,
                      customer_id:customer_id,
                      user_id:user_id,
                      desr:desr,
                      ap_color:ap_color,
                      actionType:'add',
                      allDay: 1,
                    },
              dataType:'json',
              // processData:false,
              // contentType:false,
              // cache:false,
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
                  // Add event
                  // calendar.addEvent({
                  //   eventid: response.eventid,
                  //   title: title,
                  //   description: description,
                  //   start: arg.start,
                  //   end: arg.end,
                  //   allDay: arg.allDay
                  // })
                  $('#frmCrudObject').trigger("reset");
                  $('#btnObjectSave').html('{{ trans('global.save') }}');
                  $('#btnObjectUpdate').html('{{ trans('global.update') }}');
                  $('#crudObjectModal').modal('hide');
                  toastr.success(res.success);
                }
                // calendar.refetchEvents();
              },
              error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $('#btnObjectSave').html('{{ trans('global.save')}}');
                $('#btnObjectUpdate').html('{{ trans('global.update') }}');
              }
            });
          });
          calendar.unselect()
      },
      drop: function(arg) {
        // is the "remove after drop" checkbox checked?
        if ( document.getElementById('drop-remove').checked ) {
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      },
      eventClick: function(arg) {
        console.log(arg)
      }
    });
    //
    calendar.render();
    });
  </script>

@endpush
