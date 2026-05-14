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
		.hiddenRow {
    	padding: 0 !important;
		}
  </style>
@endpush

@section('content')
  @section('breadcrumb',trans('cruds.customer_history.fields.treatment_history'))
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>{{ trans('cruds.customer_history.fields.treatment_history') }}
      </h4>
    </div>
    <div class="card-body">
      @include('admin.customer.templates.global_history_infor')
    </div>
  </div>
  {{-- @include('admin.customer.rxHistoryDetailModal') --}}
@endsection

@push('scripts')
  <script src="{{ asset('assets/backend') }}/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/select2/js/select2.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/toastrjs/toastr.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/momentjs/moment.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/bootstrap-datetime/js/bootstrap-datetimepicker.min.js"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> --}}
  <script>
    $(function() {
      $('body').on('click','a#showRxDetail',function(e){
        e.preventDefault();
        $('#showRxDetailModal').find('#name').val($('#rx_bio_name').val());
        $('#showRxDetailModal').find('#age').val($('#rx_bio_age').val());
        $('#showRxDetailModal').find('#sex').val($('#rx_bio_sex').val());
        $('#showRxDetailModal').find('#customer_id').val($('#rx_bio_customer_id').val());
        var rxId = $(this).data('id');
        var rx_customerId = $(this).data('customer_id');
        var rx_documentId = $(this).data('document_id');
        $.ajax({
          type : 'get',
          dataType: 'JSON',
          url: '{{ route("admin.histories.showtRxDetail") }}',
          data: {
            'rx_id' : rxId,
            'customer_id' : rx_customerId,
            'document_id' : rx_documentId,
          },
          success: function (res) {
            $('#rxHistoryDetailModal').find('#name').val(res.customer.name);
            $('#rxHistoryDetailModal').find('#customer_id').val(res.customer.id);
            $('#rxHistoryDetailModal').find('#customer_code').val(res.customer.customer_code);
            $('#rxHistoryDetailModal').find('#age').val(res.customer.age);
            $('#rxHistoryDetailModal').find('#phone_no').val(res.customer.phone_no);
            $('#rxHistoryDetailModal').find('#register_date').val(res.customer.register_date);
            $('#rxHistoryDetailModal').find('#history_rx_detail').empty().append(res.history_rx_detail);
          },
          error: function (error) {
            console.log('Error:', error);
          }
        });
        $('#rxHistoryDetailModal').modal('show');
      });
    });
  </script>
@endpush
