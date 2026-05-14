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
          <div class="form-group">
            <div class="row">
              <label for="search_by_customer" class="form-control-label mb-2 col-lg-4"><strong>{{ trans('cruds.customer_history.fields.search_by_customer') }}:</strong> </label>
              <div class="col-lg-8">
                <select id="search_by_customer" name="search_by_customer" class="form-control search_by_customer col-lg-8 col-xl-8" data-placeholder="{{ trans('global.select') }} {{ trans('cruds.customer_history.fields.search_by_customer') }}">
                  <option value="">{{ trans('global.select') }} {{ trans('cruds.customer_history.fields.search_by_customer') }}</option>
                  @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">({{ $customer->id }})-{{ $customer->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <span class="text-danger error-text name_error"></span>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body" id="history_detail">

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
      $('.search_by_customer').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
      });
    });

    $(document).ready(function () {
      $('#search_by_customer').change(function () {
        var $customer = $(this).val();
        $.ajax({
          url: "{{ route('admin.histories.customerDetail') }}",
          data: {
            customer_id: $customer
          },
          success: function (res) {
            console.log(res)
            $('body').find('#history_detail').empty().append(res.customer_details);
          }
        });
      });
    });
  </script>
@endpush
