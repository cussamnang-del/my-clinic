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
@endpush

@section('content')
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>{{ trans('global.list') }} {{ trans('cruds.order.title') }}
        @can($prefix.'create')
          <button id="addNewObject" type="button" class="btn btn-sm btn-outline-primary px-4 radius-30" style="float: right;" data-bs-toggle="modal" data-bs-target="#crudObjectModal">
            <i class='bx bxs-plus-square'></i> {{ trans('global.add') }} {{ trans('global.new') }}
          </button>
        @endcan
      </h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="datatable" class="table table-striped table-bordered">
          <thead>
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
          <tbody id="objectList">
            @foreach ($orders as $row)
              <tr id="tr_object_id_{{ $row->id }}">
                <td>{{ $row->id }}</td>
                <td>{{ $row->order_type }}</td>
                <td>{{ $row->customer->name }}</td>
                <td>{{ date('d-M-Y',strtotime($row->order_date)) }}</td>
                <td>{{ $row->user->name }}</td>
                <td>{{ $row->customer->sex }}</td>
                <td>{{ $row->customer->age }}</td>
                <td>
                  <div class="d-flex align-items-center gap-3 fs-6">
                    @can($prefix.'show')
                      <a id="objectShow" data-id="{{ $row->id }}" href="{{ route('admin.'.$crudRoutePath.'.previewReceipt',$row->id) }}" target="_blank" class="objectShow text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                    @endcan
                    {{-- @can($prefix.'edit')
                      <a id="objectEdit" data-id="{{ $row->id }}" href="{{ route('admin.'.$crudRoutePath.'.edit',$row->id) }}" class="objectEdit text-warning" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                    @endcan
                    @can($prefix.'delete')
                      <a id="objectDelete" data-id="{{ $row->id }}" href="{{ route('admin.'.$crudRoutePath.'.destroy',$row->id) }}" class="objectDelete text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                    @endcan --}}
                  </div>

                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>{{ trans('cruds.order.fields.id') }}</th>
              <th>{{ trans('cruds.order.fields.customer_id') }}</th>
              <th>{{ trans('cruds.customer.fields.age') }}</th>
              <th>{{ trans('cruds.customer.fields.sex') }}</th>
              <th>{{ trans('cruds.order.fields.order_date') }}</th>
              <th>{{ trans('cruds.order.fields.user_id') }}</th>
              <th>{{ trans('global.action') }}</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  {{-- @include('admin.customer.templates.crudModal') --}}
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
      "use strict";
      $(document).ready(function() {
        var table = $('#datatable').DataTable( {
          lengthChange: false,
          buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );
        table.buttons().container()
        .appendTo( '#datatable_wrapper .col-md-6:eq(0)' );
      } );
    });
    $(function () {
      "use strict";
      $('[data-bs-toggle="tooltip"]').tooltip();

      $('.single-select').select2({
        dropdownParent: $('#crudObjectModal'),
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
      });
      $('#dob, #register_date').datetimepicker({
        format: 'YYYY/MM/DD HH:mm:ss',
        locale: 'en',
        sideBySide: true,
        icons: {
          up: 'bx bx-chevron-up-circle',
          down: 'bx bx-chevron-down-circle',
          previous: 'bx bx-chevron-left-circle',
          next: 'bx bx-chevron-right-circle'
        }
      });
    });
  </script>
  <script>
    $(document).ready(function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('#addNewObject').on('click',function(e){
        e.preventDefault();
        $('#frmCrudObject').find('#preview').attr('src',"{{ asset('images/avatar3.png') }}");
        $('#crudObjectModal').find('.modal-title').html('{{ trans('global.add') }} {{ trans('cruds.customer.title_singular') }}');
        $('#frmCrudObject').find('#object_id').val('');
        $('#frmCrudObject').find('#btnObjectSave').html('<i class="fadeIn animated bx bx-plus-circle"></i>&nbsp;{{ trans('global.save') }}');
        $('#frmCrudObject').find('#btnObjectSave').removeClass('d-none');
        $('#frmCrudObject').find('#btnObjectUpdate').addClass('d-none');
        $('#frmCrudObject').trigger('reset');
      });

      $('#frmCrudObject').on('submit',function(e){
        e.preventDefault();
        var actionUrl = $(this).attr('action');
        var method = $(this).attr('method')
        $('#btnObjectSave').html('Processing..');
        $('#btnObjectUpdate').html('Processing..');
        $.ajax({
          type: method,
          url: actionUrl,
          data: new FormData(this),
          dataType:'json',
          contentType:false,
          cache:false,
          processData:false,
          beforeSend:function(){
            $(document).find('span.error-text').text('');
          },
          success: function (res) {
            if(res.status==400){
              $.each(res.error, function(prefix, val){
                $('span.'+prefix+'_error').text(val[0]);
              });
            } else {
              var $html = $(res.html);
              if(res.type == 'store-object'){
                $('tbody#objectList').append($html);
              }else{
                $("#tr_object_id_" + res.data.id).replaceWith($html);
              }
              $('#frmCrudObject').trigger("reset");
              $('#crudObjectModal').modal('hide');
              $('#btnObjectSave').html('{{ trans('global.save') }}');
              $('#btnObjectUpdate').html('{{ trans('global.update') }}');
              toastr.success(res.success);
            }
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html('{{ trans('global.save')}}');
            $('#btnObjectUpdate').html('{{ trans('global.update') }}');
          }
        });
      });

      $('body').on('click', 'a#objectEdit', function (e) {
        e.preventDefault();
        $('#frmCrudObject').find('#btnObjectSave').addClass('d-none');
        $('#frmCrudObject').find('#btnObjectUpdate').removeClass('d-none');
        $('#frmCrudObject').find('#btnObjectUpdate').html('<i class="fadeIn animated bx bx-edit"></i>&nbsp;{{ trans('global.update') }}');
        $('#frmCrudObject').trigger('reset');
        var object_id = $(this).data('id');
        var form = $('#frmCrudObject');
        var modal = $('#crudObjectModal');
        var actionUrl = $('#crudRoutePath').val();
        modal.find('.modal-title').html('{{ trans('global.edit') }} {{ trans('cruds.customer.title_singular') }}');
        $.get( actionUrl +'/' +object_id+'/edit', function (res) {
          form.find('#object_id').val(res.data.id);
          if ($('#frmCrudObject #province_id').find("option[value='" + res.data.province_id + "']").length) {
            $('#province_id').val(res.data.province_id).trigger('change');
          }
          $('#district_id').attr('selectData',res.data.district_id);
          $('#commune_id').attr('selectData',res.data.commune_id);
          $('#village_id').attr('selectData',res.data.village_id);
          form.find('#name').val(res.data.name);
          form.find('#sex').val(res.data.sex);
          form.find('#age').val(res.data.age);
          form.find('#dob').val(res.data.dob);
          form.find('#phone_no').val(res.data.phone_no);
          form.find('#old_image').val(res.data.photo);
          form.find('#preview').attr('src',"{{ asset('uploads/customer/') }}"+'/'+res.data.photo);
          form.find('#register_date').val(res.data.register_date);
          if(res.data.status==1){
            form.find('#status').prop('checked',true);
          } else {
            form.find('#status').prop('checked',false);
          }
          modal.modal('show');
        })
      });

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

      $('#btnObjectClose').on('click',function(e){
        e.preventDefault();
        $('#frmCrudObject').find('#preview').attr('src',"{{ asset('images/avatar3.png') }}");
        $('#frmCrudObject').find('#btnObjectSave').removeClass('d-none');
        $('#frmCrudObject').find('#btnObjectUpdate').addClass('d-none');
        $('#crudObjectModal').find('.modal-title').html('{{ trans('global.add') }} {{ trans('cruds.customer.title_singular') }}');
        $('#frmCrudObject').trigger('reset');
      });

      $('body').on('change','.ace-switch',function(e){
        var object_id = $(this).data('id');
        var status = $(this).prop('checked')==true ? 1 :0 ;
        $.ajax({
          type : 'GET',
          dataType: 'JSON',
          url :'{{ route('admin.customers.changeStatus') }}',
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
