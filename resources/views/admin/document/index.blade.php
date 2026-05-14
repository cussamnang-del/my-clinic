@extends('admin.admin_layout')

@push('select2')
  <link href="{{ assetUrl() }}/plugins/select2/css/select2.min.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/plugins/select2/css/select2-bootstrap4.min.css" rel="stylesheet" />
@endpush

@push('styles')
  <link href="{{ assetUrl() }}/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ assetUrl() }}/css/toggle.css">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/toastrjs/toastr.min.css">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/sweetalert2/sweetalert2.min.css">
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
    fieldset {
        border: solid 1px gray;
        padding-top: 5px;
        padding-right: 12px;
        padding-bottom: 10px;
        padding-left: 12px;
    }
    legend {
      float: none;
      width: inherit;
    }
		.hiddenRow {
    	padding: 0 !important;
		}
    tr:hover td{
      cursor:pointer;
      color:red;
    }
    /* .input-group>.form-control:focus, .input-group>.form-select:focus{
      z-index: 9999 !important;
    } */
    .input-group>.bootstrap-datetimepicker-widget{
      z-index: 9999 !important;
    }
  </style>
@endpush

@section('content')
  @section('breadcrumb',trans('cruds.document.title'))
  {{-- all document not stay in hopital and not checkout --}}
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>
        {{ trans('global.list') }} {{ trans('cruds.document.title') }}
        @can($prefix.'create')
          <button id="addNewObject" type="button" class="btn btn-sm btn-outline-primary px-4 radius-30 float-end" data-bs-toggle="modal" data-bs-target="#crudObjectModal">
            <i class='bx bxs-plus-square'></i> {{ trans('global.add') }} {{ trans('global.new') }}
          </button>
        @endcan
      </h4>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-grid mx-auto">
          <form action="{{ route('admin.documents.index') }}" method="get">
            @csrf
            <div class="row mb-2">
              <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
                <div class="input-group input-daterange mb-2">
                  <input name="from_date" id="from_date" type="text" class="form-control" readonly placeholder="from_date" aria-label="from_date" value="{{ $from_date }}">
                  <span class="input-group-text">TO</span>
                  <input name="to_date" id="to_date" type="text" class="form-control" readonly placeholder="to_date" aria-label="to_date" value="{{ $to_date }}">
                </div>
              </div>
              <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <div class="d-grid gap-2 mx-auto">
                  <button type="submit" class="btn btn-md btn-block btn-outline-success">
                    <i class="fadeIn animated bx bx-search-alt"></i> Search
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table id="datatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>{{ trans('cruds.document.fields.id') }}</th>
              <th>{{ trans('cruds.document.fields.add_service') }}</th>
              <th>{{ trans('cruds.document.fields.visit_date') }}</th>
              <th>{{ trans('cruds.document.fields.customer_id') }}</th>
              <th>{{ trans('cruds.customer.fields.sex') }}</th>
              <th>{{ trans('cruds.customer.fields.age') }}</th>
              <th>{{ trans('cruds.customer.fields.phone_no') }}</th>
              <th>{{ trans('cruds.customer.fields.address') }}</th>
              <th>{{ trans('global.status') }}</th>
              <th>{{ trans('global.action') }}</th>
            </tr>
          </thead>
          <tbody id="objectDocumentList">
            @foreach ($documents as $row)
              <tr id="tr_object_id_{{ $row->id }}" class="gotoService" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer->id }}">
                <td>{{ $row->id }}</td>
                <td class="text-center">
                  <a id="checkout" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer->id }}" href="javascript:void(0)" class="btn btn-sm btn-outline-success px-3"><strong>Checkout</strong></a>
                </td>
                <td>{{ date('d-m-Y',strtotime($row->visit_date)) }}</td>
                <td>{{ $row->customer->name }}</td>
                <td>{{ $row->customer->sex }}</td>
                <td>{{ $row->customer->age }}</td>
                <td>{{ $row->customer->phone_no }}</td>
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
  {{-- all document stay in hopital and not checkout --}}
  @if (count($document_hospitals))
    <div class="card">
      <div class="card-header">
        <h4 class="mb-0 text-primary"><i class="bx bxs-user me-1 font-22 text-primary"></i>
          {{ trans('global.list') }} {{ trans('cruds.document.fields.customer_stay') }}
        </h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="datatable" class="table table-striped table-bordered" style="height: 180px">
            <thead>
              <tr>
                <th>{{ trans('cruds.document.fields.id') }}</th>
                <th>{{ trans('cruds.document.fields.add_service') }}</th>
                <th>{{ trans('cruds.document.fields.visit_date') }}</th>
                <th>{{ trans('cruds.document.fields.customer_id') }}</th>
                <th>{{ trans('cruds.customer.fields.sex') }}</th>
                <th>{{ trans('cruds.customer.fields.age') }}</th>
                <th>{{ trans('cruds.customer.fields.phone_no') }}</th>
                <th>{{ trans('cruds.customer.fields.address') }}</th>
                <th>{{ trans('global.status') }}</th>
                <th>{{ trans('global.action') }}</th>
              </tr>
            </thead>
            <tbody id="objectDocumentHospital">
              @foreach ($document_hospitals as $row)
              <tr id="tr_object_id_{{ $row->id }}" class="gotoService" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer->id }}">
                <td>{{ $row->id }}</td>
                <td class="text-center">
                  <a id="checkout" data-id="{{ $row->id }}" data-customer_id="{{ $row->customer->id }}" href="javascript:void(0)" class="btn btn-sm btn-outline-success px-3"><strong>Checkout</strong></a>
                </td>
                <td>{{ date('d-m-Y',strtotime($row->visit_date)) }}</td>
                <td>{{ $row->customer->name }}</td>
                <td>{{ $row->customer->sex }}</td>
                <td>{{ $row->customer->age }}</td>
                <td>{{ $row->customer->phone_no }}</td>
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
  @endif

  @include('admin.document.templates.crudModal')
  @include('admin.document.customerModal')
@endsection

@push('scripts')
  <script src="{{ assetUrl() }}/plugins/datatable/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/datatable/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/select2/js/select2.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/toastrjs/toastr.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/sweetalert2/sweetalert2.all.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/momentjs/moment.min.js" crossorigin="anonymous"></script>
  <script src="{{ assetUrl() }}/plugins/jquery-datetime/jquery.datetimepicker.full.min.js" crossorigin="anonymous"></script>
  <script>
    var today_date = new Date();
    var yy = today_date.getFullYear();
    var dd = today_date.getDate().toString().padStart(2, "0");
    var mm =  (today_date.getMonth() + 1).toString().padStart(2, "0");
    var hh = today_date.getHours().toString().padStart(2, "0");
    var mn = today_date.getMinutes().toString().padStart(2, "0");
    var ss = today_date.getSeconds().toString().padStart(2, "0");
    var today = dd + '-' + mm + '-' + yy + " " + hh + ":" + mn + ":" + ss;
    $(function() {
      "use strict";
      $(document).ready(function() {
        var table = $('#datatable').DataTable( {
          lengthChange: false,
          buttons: [ 'copy', 'excel', 'pdf', 'print']
        });
        table.buttons().container()
        .appendTo( '#datatable_wrapper .col-md-6:eq(0)');
      });
    });
    $(function () {
      "use strict";
      $('[data-bs-toggle="tooltip"]').tooltip();
      $('#customer_id').select2({
          dropdownParent: $('#crudObjectModal'),
          theme: 'bootstrap4',
          width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
          placeholder: $(this).data('placeholder'),
          allowClear: Boolean($(this).data('allow-clear')),
      });
      $('.single-select').select2({
          dropdownParent: $('#customerModal'),
          theme: 'bootstrap4',
          width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
          placeholder: $(this).data('placeholder'),
          allowClear: Boolean($(this).data('allow-clear')),
      });
    })
    $(function(){
      $('#from_date').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
        this.setOptions({
          maxDate:$('#to_date').val()?$('#to_date').val():false
        })
        },
        timepicker:false
      });
      $('#to_date').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
        this.setOptions({
          minDate:$('#from_date').val()?$('#from_date').val():false
        })
        },
        timepicker:false
      });
      $('#visit_date').datetimepicker({
        format:'Y-m-d H:i',
        // timepicker:false
      });
      $('#checkout_date').datetimepicker({
        format:'Y-m-d H:i',
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
  <script type="text/javascript">
    $(document).ready(function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $(document).on('keyup','#age',function(e) {
        if (e.keyCode == 13){
          $('#phone_no').focus();
          e.preventDefault();
        }
        var age = $(this).val();
        var dob = (yy - age) + '-'+ mm + '-' + dd;
        console.log(age);
        $('#customerModal').find('#dob').val(dob);
      });

      $('body').on('click','#objectAddCustomer',function(e){
        e.preventDefault();
        $('body').find('#frmCustomer').trigger('reset');
        $('body').find('#frmCustomer select').val(0).trigger('change');
        $('body').find('#frmCustomer #preview').attr('src',"{{ asset('images/avatar3.png') }}");
        $('#register_date').val(today);
        $('#register_date').datetimepicker({
          format:'Y-m-d H:i',
        });
        $('#customerModal').modal('show');
      });

      $('#customer_id').change(function(e){
        e.preventDefault();
        var object_id = $(this).val();
        var form = $('#frmCrudObject');
        if(object_id ==0){
          return false;
        } else {
          $.ajax({
            type : 'GET',
            dataType: 'JSON',
            url :`{{ route('admin.documents.getCustomer') }}`,
            data: {
              'object_id':object_id
            },
            success:function(res){
              var address = res.data.province.name_en + ', ' + res.data.district.name_en + ', ' + res.data.commune.name_en + ', ' + res.data.village.name_en
              form.find('#customer_id').val(res.data.id);
              form.find('#sex').val(res.data.sex);
              form.find('#age').val(res.data.age);
              form.find('#phone_no').val(res.data.phone_no);
              form.find('#address').val(address);
            },
            error:function(err){
              console.log(err);
            }
          });
        }
      });

      $('#frmCustomer').on('submit',function(e){
        e.preventDefault();
        $('#frmCustomer').find('span.text-danger').removeClass('d-none');
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
              $html = `
                <option value="${res.data.id}">(${res.data.customer_code})-${res.data.name}</option>
              `;
              if(res.type == 'store-object'){
                $('#frmCrudObject').find('#customer_id').append($html);
              }else{
                $("#tr_object_id_" + res.data.id).replaceWith($html);
              }
              $('#btnObjectSave').html('{{ trans('global.save') }}');
              $('#btnObjectUpdate').html('{{ trans('global.update') }}');
              $('#frmCrudObject').find('#customer_id').val(res.data.id).trigger('change');
              $('#customerModal').modal('hide');
              toastr.success(res.success);
              window.location.reload();
            }
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html('{{ trans('global.save')}}');
            $('#btnObjectUpdate').html('{{ trans('global.update') }}');
          }
        });
      });

      $('#addNewObject').on('click',function(e){
        e.preventDefault();
        $('#crudObjectModal').find('.modal-title').html(`{{ trans('global.add') }} {{ trans('cruds.document.title_singular') }}`);
        $('#frmCrudObject').find('#object_id').val('');
        $('#frmCrudObject').find('#btnObjectSave').html(`<i class="fadeIn animated bx bx-plus-circle"></i>&nbsp;{{ trans('global.save') }}`);
        $('#frmCrudObject').find('#btnObjectSave').removeClass('d-none');
        $('#frmCrudObject').find('#btnObjectUpdate').addClass('d-none');
        $('#frmCrudObject').trigger('reset');
        $('#frmCrudObject').find('span.text-danger').addClass('d-none');
        $('#frmCrudObject').find('#visit_date').val(today);
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
          dataType: 'json',
          processData:false,
          dataType:'json',
          contentType:false,
          beforeSend:function(){
            $(document).find('span.error-text').text('');
          },
          success: function (res) {
            if(res.status==400){
              $.each(res.error, function(prefix, val){
                $('span.'+prefix+'_error').text(val[0]);
              });
            } else {
              var $html = res.html;
              if(res.type == 'store-object'){
                $('tbody#objectServiceList').append($html);
              }else{
                $("#tr_object_id_" + res.data.id).replaceWith($html);
              }
              $('#frmCrudObject').trigger("reset");
              $('#frmCrudObject').find('#customer_id').val(0).trigger('change');
              $('#crudObjectModal').modal('hide');
              $('#btnObjectSave').html(`{{ trans('global.save') }}`);
              $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
              toastr.success(res.success);
            }
            $('#frmCrudObject').find('span.text-danger').removeClass('d-none');
            window.location.reload();
          },
          error: function (error) {
            console.log('Error:', error);
            $('#btnObjectSave').html(`{{ trans('global.save') }}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
          }
        });
      });

      $('body').on('click', 'a#objectEdit', function (e) {
        e.preventDefault();
        $('#frmCrudObject').find('#btnObjectSave').addClass('d-none');
        $('#frmCrudObject').find('#btnObjectUpdate').removeClass('d-none');
        $('#frmCrudObject').find('#btnObjectUpdate').html(`<i class="fadeIn animated bx bx-edit"></i>&nbsp;{{ trans('global.update') }}`);
        $('#frmCrudObject').trigger('reset');
        var object_id = $(this).data('id');
        var form = $('#frmCrudObject');
        var modal = $('#crudObjectModal');
        var actionUrl = $('#crudRoutePath').val();
        modal.find('.modal-title').html(`{{ trans('global.edit') }} {{ trans('cruds.document.title_singular') }}`);
        $.get( actionUrl +'/' +object_id+'/edit', function (res) {
          form.find('#object_id').val(res.data.id);
          if ($('#frmCrudObject #customer_id').find("option[value='" + res.data.customer_id + "']").length) {
            $('#customer_id').val(res.data.customer_id).trigger('change');
          }
          form.find('#visit_date').val(res.data.visit_date);
          if(res.data.status==1){
            form.find('#status').prop('checked',true);
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
        $('#crudObjectModal').find('.modal-title').html(`{{ trans('global.add') }} {{ trans('cruds.document.title_singular') }}`);
        $('#frmCrudObject').trigger('reset');
      });

      $('body').on('change','.ace-switch',function(e){
        var object_id = $(this).data('id');
        var status = $(this).prop('checked')==true ? 1 :0 ;
        $.ajax({
          type : 'GET',
          dataType: 'JSON',
          url :`{{ route('admin.documents.changeStatus') }}`,
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

      $('body').on('dblclick','table tr',function(e) {
        e.preventDefault();
        var document_id = $(this).data('id');
        var customer_id = $(this).data('customer_id');
        var url = `{{ route("admin.documents.gotoService", [":document",":customer"]) }}`;
        url = url.replace(':document', document_id);
        url = url.replace(':customer',customer_id)
        window.open(url,'_blank');
      });

      $('body').on('click','a#checkout',function(e){
        e.preventDefault();
        var document_id = $(this).data('id');
        Swal.fire({
          title: 'Are you sure?',
          text: "You want to checkout now?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Checkout it!'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              type: 'POST',
              dataType: 'json',
              url: "{{ route('admin.documents.checkout') }}",
              data: {
                'document_id':document_id,
              },
              beforeSend:function(){
                $(document).find('span.error-text').text('');
              },
              success: function (res) {
                if(res.status==400){
                  $.each(res.error, function(prefix, val){
                    $('span.'+prefix+'_error').text(val[0]);
                  });
                } else {
                  toastr.success(res.success);
                  location.reload();
                }
              },
              error: function (error) {
                console.log('Error:', error);
                $('#btnObjectSave').html(`{{ trans('global.save')}}`);
                $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
              }
            });
          }
        })
      });
    });
  </script>

@endpush
