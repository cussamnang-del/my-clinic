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
  </style>
@endpush

@section('content')
  @section('breadcrumb',trans('cruds.item_group.title'))
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>{{ trans('global.list') }} {{ trans('cruds.item_group.title') }}
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
              <th>{{ trans('cruds.item_group.fields.id') }}</th>
              <th>{{ trans('cruds.item_group.fields.name') }}</th>
              <th>{{ trans('cruds.item_group.fields.created_at') }}</th>
              <th>{{ trans('global.status') }}</th>
              <th>{{ trans('global.action') }}</th>
            </tr>
          </thead>
          <tbody id="objectList">
            @foreach ($item_groups as $row)
              <tr id="tr_object_id_{{ $row->id }}">
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ date('d-M-Y',strtotime($row->created_at)) }}</td>
                <td>
                  <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
                </td>
                <td>
                  @include('admin.templates.crudAction')
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>{{ trans('cruds.item_group.fields.id') }}</th>
              <th>{{ trans('cruds.item_group.fields.name') }}</th>
              <th>{{ trans('cruds.item_group.fields.created_at') }}</th>
              <th>{{ trans('global.status') }}</th>
              <th>{{ trans('global.action') }}</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  @include('admin.item_group.templates.crudModal')
@endsection

@push('scripts')
  <script src="{{ asset('assets/backend') }}/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/select2/js/select2.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/toastrjs/toastr.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="{{ asset('assets/backend/') }}/plugins/summernote/summernote-lite.min.js"></script>
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
    })
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
        $('#crudObjectModal').find('.modal-title').html('{{ trans('global.add') }} {{ trans('cruds.item_group.title_singular') }}');
        $('#frmCrudObject').find('#object_id').val('');
        $('#frmCrudObject').find('#btnObjectSave').html('<i class="fadeIn animated bx bx-plus-circle"></i>&nbsp;{{ trans('global.save') }}');
        $('#frmCrudObject').find('#btnObjectSave').removeClass('d-none');
        $('#frmCrudObject').find('#btnObjectUpdate').addClass('d-none');
        $('#frmCrudObject #item_part').val('').trigger('change')
        $('#frmCrudObject #item_group').val('').trigger('change')
        $('#frmCrudObject #item_type').val('').trigger('change')
        $('#frmCrudObject .note-editable').html('');
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
          processData:false,
          dataType:'json',
          contentType:false,
          cache:false,
          beforeSend:function(){
            $(document).find('span.error-text').text('');
          },
          success: function (res) {
            console.log(res.success);
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
        modal.find('.modal-title').html('{{ trans('global.edit') }} {{ trans('cruds.item_group.title_singular') }}');
        $.get( actionUrl +'/' +object_id+'/edit', function (res) {
          form.find('#object_id').val(res.data.id);
          form.find('#name').val(res.data.name);
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
        $('#frmCrudObject').find('#btnObjectSave').removeClass('d-none');
        $('#frmCrudObject').find('#btnObjectUpdate').addClass('d-none');
        $('#crudObjectModal').find('.modal-title').html('{{ trans('global.add') }} {{ trans('cruds.customer.title_singular') }}');
        $('#frmCrudObject').trigger('reset');
      });

      $('body').on('change','.ace-switch',function(e){
        var object_id = $(this).data('id');
        var actionUrl = $('#crudRoutePath').val();
        var status = $(this).prop('checked')==true ? 1 :0 ;
        $.ajax({
          type : 'GET',
          dataType: 'JSON',
          url :'{{ route('admin.item_groups.changeStatus') }}',
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
  {{-- summernote editor --}}
  <script>
    $('#uvn').summernote({
      tabsize: 2,
      toolbar: [
        ['font', ['superscript', 'subscript','bold', 'underline', 'clear']],
      ]
    });
  </script>
@endpush

{{-- <script>
  $(document).ready(function () {
      $('table th input:checkbox').on('click' , function(){
          var that = this;
          $(this).closest('table').find('input:checkbox')
              .each(function(){
                  this.checked = that.checked;
                  $(this).closest('tr').toggleClass('selected');
              });
      });
      $('.group').on('click' , function(){
          var that = this;
          $(this).closest('tr').find('input:checkbox')
              .each(function(){
                  this.checked = that.checked;
                  $(this).closest('tr').toggleClass('selected');
              });
      });
  });
</script> --}}
