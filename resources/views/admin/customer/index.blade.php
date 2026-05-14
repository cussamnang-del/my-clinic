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
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/jquery-datetime/jquery.datetimepicker.min.css" crossorigin="anonymous" />
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
  @section('breadcrumb',trans('cruds.customer.title'))
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>{{ trans('global.list') }} {{ trans('cruds.customer.title') }}
        @can($prefix.'create')
          <button id="addNewObject" type="button" class="btn btn-sm btn-outline-primary px-4 radius-30 float-end" data-bs-toggle="modal" data-bs-target="#crudObjectModal">
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
              <th>{{ trans('cruds.customer.fields.id') }}</th>
              <th>{{ trans('cruds.customer.fields.name') }}</th>
              <th>{{ trans('cruds.customer.fields.sex') }}</th>
              <th>{{ trans('cruds.customer.fields.age') }}</th>
              <th>{{ trans('cruds.customer.fields.dob') }}</th>
              <th>{{ trans('cruds.customer.fields.phone_no') }}</th>
              <th>{{ trans('cruds.customer.fields.register_date') }}</th>
              <th>{{ trans('cruds.customer.fields.address') }}</th>
              <th>{{ trans('global.status') }}</th>
              <th>{{ trans('global.action') }}</th>
            </tr>
          </thead>
          <tbody id="objectList">
            @foreach ($customers as $row)
              <tr id="tr_object_id_{{ $row->id }}">
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->sex }}</td>
                <td>{{ $row->age }}</td>
                <td>{{ date('d-M-Y',strtotime($row->dob)) }}</td>
                <td>{{ $row->phone_no }}</td>
                <td>{{ date('d-M-Y',strtotime($row->register_date)) }}</td>
                <td>{{ $row->address }}</td>
                <td>
                  <input id="status" name="status" data-id="{{ $row->id }}" {{ $row->status?'checked':'' }} title="Status" type="checkbox" class="ace-switch input-lg ace-switch-yesno bgc-green-d2 text-grey-m2" />
                </td>
                <td>
                  @include('admin.templates.crudAction')
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @include('admin.customer.templates.crudModal')
@endsection

@push('scripts')
  <script src="{{ asset('assets/backend') }}/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/select2/js/select2.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/toastrjs/toastr.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="{{ asset('assets/backend') }}/plugins/momentjs/moment.min.js"></script>
  <script src="{{ assetUrl() }}/plugins/jquery-datetime/jquery.datetimepicker.full.min.js" crossorigin="anonymous"></script>
  <script>
    var today_date = new Date();
    var yy = today_date.getFullYear();
    var dd = today_date.getDate().toString().padStart(2, "0");
    var mm =  (today_date.getMonth() + 1).toString().padStart(2, "0");
    var hh = today_date.getHours().toString().padStart(2, "0");
    var mn = today_date.getMinutes().toString().padStart(2, "0");
    var today = dd + '-' + mm + '-'+ yy + " " + hh + ":" + mn;
    $(document).on('keydown','#age',function(e) {
      if (e.keyCode == 13){
        $('#phone_no').focus();
        e.preventDefault();
      }
      var age = $(this).val();
      var dob = (yy - age) + '-'+ mm + '-' +dd;
      $('#crudObjectModal').find('#dob').val(dob);
    });
    $(function() {
      "use strict";
      $(document).ready(function() {
        var table = $('#datatable').DataTable( {
          lengthChange: false,
          buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );
        table.buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
        $('[data-bs-toggle="tooltip"]').tooltip();
        $('.single-select').select2({
          dropdownParent: $('#crudObjectModal'),
          theme: 'bootstrap4',
          width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
          placeholder: $(this).data('placeholder'),
          allowClear: Boolean($(this).data('allow-clear')),
        });
        $('#register_date, #dob').datetimepicker({
          format: 'Y-m-d H:i:s',
        });
      });
    });
  </script>
  <script>
    function changeProfile() {
      $('#photo').click();
    }
    $('#photo').change(function () {
      var imgPath = this.value;
      var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
      if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg") {
        $('#btn-remove').css('display','block');
        $('#btn-upload').text('Change');
        readURL(this);
      } else {
        alert("Please select image file (jpg, jpeg, png).")
      }
    });
    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.readAsDataURL(input.files[0]);
          reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
          };
        $("#remove").val(0);
      }
    }
    function removeImage() {
      $('#preview').attr('src',"{{ asset('images/avatar3.png') }}");
      $("#remove").val(1);
    }
  </script>
  <script>
    $(document).ready(function () {
      $('#province_id').change(function () {
        var $district = $('#district_id');
        $.ajax({
          url: "{{ route('districts.index') }}",
          data: {
            province_id: $(this).val()
          },
          success: function (data) {
            $district.html('<option value="" selected>Choose district</option>');
            $.each(data, function (id, value) {
              $district.append('<option value="' + id + '">' + value + '</option>');
            });
            var selectData = $district.attr('selectData');
            $district.val(selectData).trigger('change');
          }
        });
        $('#district, #commune_id','village_id').val("");
        $('#district_id').prop('disabled',false);
      });
      $('#district_id').change(function () {
        var $commune = $('#commune_id');
        $.ajax({
          url: "{{ route('communes.index') }}",
          data: {
            district_id: $(this).val()
          },
          success: function (data) {
            $commune.html('<option value="" selected>Choose commune</option>');
            $.each(data, function (id, value) {
              $commune.append('<option value="' + id + '">' + value + '</option>');
            });
            var selectData = $commune.attr('selectData');
            $commune.val(selectData).trigger('change');
          }
        });
        $('#commune_id').prop('disabled',false);
      });
      $('#commune_id').change(function () {
        var $village = $('#village_id');
        $.ajax({
          url: "{{ route('villages.index') }}",
          data: {
            commune_id: $(this).val()
          },
          success: function (data) {
            $village.html('<option value="" selected>Choose village</option>');
            $.each(data, function (id, value) {
              $village.append('<option value="' + id + '">' + value + '</option>');
            });
            var selectData = $village.attr('selectData');
            $village.val(selectData).trigger('change');
          }
        });
        $('#village_id').prop('disabled',false);
      });
    });
  </script>
  {{-- crud script --}}
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
        $('#frmCrudObject').find('span.text-danger').addClass('d-none');
        $('#frmCrudObject').find('select').val(0).trigger('change');
        $('#register_date').val(today);
      });

      $('#frmCrudObject').on('submit',function(e){
        e.preventDefault();
        $('#frmCrudObject').find('span.text-danger').removeClass('d-none');
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
              var $html =res.html;
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
          form.find('#customer_code').val(res.data.customer_code);
          form.find('#name').val(res.data.name);
          if ($('#frmCrudObject #sex').find("option[value='" + res.data.sex + "']").length) {
            $('#sex').val(res.data.sex).trigger('change');
          }
          form.find('#age').val(res.data.age);
          form.find('#dob').val(res.data.dob);
          form.find('#phone_no').val(res.data.phone_no);
          form.find('#old_image').val(res.data.photo);
          if(res.data.photo==null){
            form.find('#preview').attr('src',"{{ asset('images/avatar3.png') }}");
          } else {
            form.find('#preview').attr('src',"{{ asset('uploads/customer/') }}"+'/'+res.data.photo);
          }
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
