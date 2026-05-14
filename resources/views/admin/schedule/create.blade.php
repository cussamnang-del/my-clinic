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
  @section('breadcrumb',trans('cruds.schedule.title'))
  <div class="card">
    <form id="frmCrudObject" action="{{ route('admin.'.$crudRoutePath.'.store') }}" method="post">
      <div class="card-header">
        <h4 class="mb-0 text-primary">
          <i class="bx bxs-user me-1 font-22 text-primary"></i>
          {{ trans('global.create') }} {{ trans('cruds.schedule.title') }}
        </h4>
      </div>
      <div class="card-body">
        {{ csrf_field() }}
        <div class="row mb-2">
          <div class="col-lg-9 col-md-9 col-sm-9">
            <div class="form-group">
              <label for="title" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.title') }}: <span class="text-danger">*</span></label>
              <input id="title" name="title" class="form-control @error('title') is-invalid @enderror" type="text" placeholder="{{ trans('cruds.schedule.fields.title') }}">
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-group">
              <label for="color" class="form-control-label mb-1" aria-label="Text input with checkbox">{{ trans('cruds.schedule.fields.color') }}: <span class="text-danger">*</span></label>
              <input id="color" name="color" type="text" class="form-control color @error('title') is-invalid @enderror" aria-label="Text input with checkbox">
              @error('color')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
              <label for="start_time" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.start_time') }}: <span class="text-danger">*</span></label>
              <input id="start_time" name="start_time" class="form-control datetime @error('start_time') is-invalid @enderror" type="text" placeholder="{{ trans('cruds.schedule.fields.start_time') }}">
              @error('start_time')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
              <label for="finish_time" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.finish_time') }}: <span class="text-danger">*</span></label>
              <input id="finish_time" name="finish_time" class="form-control datetime @error('finish_time') is-invalid @enderror" type="text" placeholder="{{ trans('cruds.schedule.fields.finish_time') }}">
              @error('finish_time')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
              <label for="customer_id" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.customer_id') }}: <span class="text-danger">*</span></label>
              <select id="customer_id" name="customer_id" class="form-control single-select @error('customer_id') is-invalid @enderror"  style="width: 100%" data-placeholder="{{ trans('global.select') }} {{ trans('cruds.schedule.fields.customer_id') }}">
                <option value="">{{ trans('global.select') }} {{ trans('cruds.schedule.fields.customer_id') }}</option>
                @foreach ($customers as $row)
                  <option value="{{ $row->id}}">{{ $row->name }}</option>
                @endforeach
              </select>
              @error('customer_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
              <label for="user_id" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.user_id') }}: <span class="text-danger">*</span></label>
              <select id="user_id" name="user_id" class="form-control single-select @error('user_id') is-invalid @enderror"  style="width: 100%" data-placeholder="{{ trans('global.select') }} {{ trans('cruds.schedule.fields.user_id') }}">
                <option value="">{{ trans('global.select') }} {{ trans('cruds.schedule.fields.user_id') }}</option>
                @foreach ($users as $row)
                  <option value="{{ $row->id}}">{{ $row->name }}</option>
                @endforeach
              </select>
              @error('user_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
              <label for="desr" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.desr') }}: </label>
              <input id="desr" name="desr" class="form-control" type="text" placeholder="{{ trans('cruds.schedule.fields.desr') }}">
            </div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
              <label for="status" class="form-control-label mb-1">{{ trans('cruds.schedule.fields.status') }}: </label>
              <select id="status" name="status" class="form-control single-select"  style="width: 100%" data-placeholder="{{ trans('global.select') }} {{ trans('cruds.schedule.fields.status') }}">
                @foreach (App\Models\Schedule::APPOINTMENT_STATUS_RADIO as $key => $label)
                  <option value="{{ $key}}">{{ $label }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-center">
        <a href="{{route('admin.schedules.index')}}" class="btn btn-sm btn-outline-warning px-3 radius-30">
          <i class="fadeIn animated bx bx-window-close"></i>&nbsp;{{ trans('global.back') }}
        </a>
        <button type="submit" class="btn btn-sm btn-outline-primary px-3 radius-30">
          <i class="fadeIn animated bx bx-plus-circle"></i>
          &nbsp;{{ trans('global.save') }}
        </button>
      </div>
    </form>
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
    $(document).ready(function(){
      $('.datetime').datetimepicker({
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
      //color picker with addon
      $('.color').colorpicker()
      moment.updateLocale('en', {
        week: {dow: 1} // Monday is the first day of the week
      })
      $('.single-select').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
      });
    });
    @if(Session::has('success'))
      toastr.success("{{ Session::get('success') }}");
    @endif
    @if(Session::has('info'))
      toastr.info("{{ Session::get('info') }}");
    @endif
    @if(Session::has('warning'))
      toastr.warning("{{ Session::get('warning') }}");
    @endif
    @if(Session::has('error'))
      toastr.error("{{ Session::get('error') }}");
    @endif
  </script>

@endpush
