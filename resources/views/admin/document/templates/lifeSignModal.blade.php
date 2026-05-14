<div class="modal fade" id="lifeSignModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="frmLifeSign" action="{{ route('admin.documents.documentlife.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="exist_customer_id" id="exist_customer_id" value="{{ $customer->id }}">
          <input type="hidden" name="document_id" id="document_id" value="{{ $document->id }}">
          <input type="hidden" name="crudRoutePath" id="crudRoutePath" value="{{ $crudRoutePath }}">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="form-group mb-2">
                <label for="type_id" class="form-control-label mb-2">{{ trans('cruds.lifesign.fields.type') }}: <span class="text-danger">*</span></label>
                <select id="type_id" name="type_id" class="form-control type-select" data-placeholder="Select Type">
                  <option value="">{{ trans('global.select') }} {{ trans('cruds.lifesign.fields.type') }}</option>
                  @foreach ($types as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                  @endforeach
                </select>
                <span class="text-danger error-text type_id_error"></span>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="form-group mb-2">
                <label for="type_date" class="form-control-label mb-2">{{ trans('cruds.document.fields.type_date') }}:</label>
                <input id="type_date" name="type_date" class="form-control" type="text" placeholder="{{ trans('cruds.document.fields.type_date') }}">
                <span class="text-danger error-text type_date_error"></span>
              </div>
            </div>
          </div>
          <div id="lifesign_form"></div>
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="form-group" style="margin-top:0.8rem;">
                <div class="form-check form-switch">
                  <input id="status" name="status" class="form-check-input" type="checkbox" checked>
                  <label class="form-check-label mt-1" for="flexSwitchCheckChecked">&nbsp;&nbsp;{{ trans('global.status') }}</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          @include('admin.templates.button')
        </div>
      </form>
    </div>
  </div>
</div>
@push('modal')
  <script>
    $('body').on('change','#type_name',function(e){
      var id= $(this).val();
      if($(this).prop('checked')==true){
        $('.type_desr[data-id="' + id + '"]').attr('disabled', false)
        $('.type_measure[data-id="' + id + '"]').attr('disabled', false)
      } else {
        $('.type_desr[data-id="' + id + '"]').attr('disabled', true)
        $('.type_measure[data-id="' + id + '"]').attr('disabled', true)
      }
    });

    $('body').on('click','a#objectAddTypeA',function(e){
      $('#lifesign_form').empty();
      $('#lifeSignModal').find('.modal-title').html('Add New ObjectA');
      $('#lifeSignModal').find('#type_id').val(1).trigger('change');
      var today = dd + '-' + mm + '-'+ yy;
      $('#lifeSignModal').find('#type_date').val(today);
      $('#lifeSignModal').modal('show');
    });

    $('body').on('click','a#objectAddTypeB',function(e){
      $('#lifesign_form').empty();
      $('#lifeSignModal').find('.modal-title').html('Add New ObjectB');
      $('#lifeSignModal').find('#type_id').val(2).trigger('change');
      var today = dd + '-' + mm + '-'+ yy;
      $('#lifeSignModal').find('#type_date').val(today);
      $('#lifeSignModal').modal('show');
    });

    $('body').on('click','a#hobjectAddTypeA',function(e){
      $('#lifesign_form').empty();
      $('#lifeSignModal').find('.modal-title').html('Add New ObjectA');
      $('#lifeSignModal').find('#type_id').val(1).trigger('change');
      var today = dd + '-' + mm + '-'+ yy;
      $('#lifeSignModal').find('#type_date').val(today);
      $('#lifeSignModal').modal('show');
    })

    $('body').on('click','a#hobjectAddTypeB',function(e){
      $('#lifesign_form').empty();
      $('#lifeSignModal').find('.modal-title').html('Add New ObjectB');
      $('#lifeSignModal').find('#type_id').val(2).trigger('change');
      var today = dd + '-' + mm + '-'+ yy;
      $('#lifeSignModal').find('#type_date').val(today);
      $('#lifeSignModal').modal('show');
    });

    $('body').on('change','#type_id',function(e){
      e.preventDefault();
      var type_id = $(this).val();
      if(type_id==0){
        return false;
      } else {
        $.ajax({
          type : 'GET',
          dataType: 'JSON',
          url :`{{ route('admin.documents.getLifeSign') }}`,
          data: {
            'type_id':type_id
          },
          success:function(res){
            $('#lifesign_form').empty();
            $.each(res,function(i,e){
              $html = `
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group mb-2">
                      <div class="form-check ">
                        <input value="${e.id}" id="type_name" name="type_name[]" class="form-check-input" type="checkbox" data-id="${e.id}">
                        <label class="form-check-label mt-1" for="flexSwitchCheckChecked">&nbsp;&nbsp;${e.name}</label>
                      </div>
                      <span class="text-danger error-text type_name_error"></span>
                    </div>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group mb-2">
                      <label for="type_desr" class="form-control-label mb-2">${e.name} {{ trans('cruds.document_life.fields.coldesr') }}:</label>
                      <input id="type_desr" name="type_desr[]" class="form-control type_desr" type="text" placeholder="${e.name} {{ trans('cruds.document_life.fields.coldesr') }}" data-id="${e.id}" disabled>
                      <input id="type_measure" name="type_measure[]" class="form-control type_measure" type="hidden" value="${e.measure}" data-id="${e.id}" disabled>
                      </div>
                    <span class="text-danger error-text type_desr_error"></span>
                  </div>
                </div>
              `;
              $('#lifesign_form').append($html);
            })
          },
          error:function(err){
            console.log(err);
          }
        });
      }
    });

    $('#frmLifeSign').on('submit',function(e){
      e.preventDefault();
      var actionUrl = $(this).attr('action');
      var method = $(this).attr('method')
      var modal = $('#orderObjectModal');
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
          console.log(res)
          if(res.status==400){
            $.each(res.error, function(prefix, val){
              $('span.'+prefix+'_error').text(val[0]);
            });
          } else if (res.status==500) {
            toastr.error(res.error);
          } else {
            $(document).find('#typeA').empty().append(res.typeA);
            $(document).find('#typeB').empty().append(res.typeB);
            modal.find('#typeA').empty().append(res.typeA);
            modal.find('#typeB').empty().append(res.typeB);
            $('#moreObjectModal').find('#typeA').empty().append(res.typeA)
            $('#moreObjectModal').find('#typeB').empty().append(res.typeB);
            $('#frmLifeSign').trigger("reset");
            $('#btnObjectSave').html(`{{ trans('global.save') }}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
            $('#lifeSignModal').modal('hide');
            toastr.success(res.success);
          }
        },
        error: function (error) {
          console.log('Error:', error);
          $('#btnObjectSave').html(`{{ trans('global.save') }}`);
          $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
        }
      });
    });

    $('#frmUpdateLifeSign').on('submit',function(e){
      e.preventDefault();
      var actionUrl = $(this).attr('action');
      var modal = $('#editLifeSignModal');
      var service_modal = $('#frmAddService');
      $.ajax({
        type: 'POST',
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
            $(document).find('#typeA').empty().append(res.typeA);
            $(document).find('#typeB').empty().append(res.typeB);
            service_modal.find('#typeA').empty().append(res.typeA);
            service_modal.find('#typeB').empty().append(res.typeB);
            $('#moreObjectModal').find('#typeA').empty().append(res.typeA)
            $('#moreObjectModal').find('#typeB').empty().append(res.typeB);
            $('#orderObjectModal').find('#typeA').empty().append(res.typeA)
            $('#orderObjectModal').find('#typeB').empty().append(res.typeB);
            $('#btnObjectSave').html(`{{ trans('global.save') }}`);
            $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
            modal.modal('hide');
            toastr.success(res.success);
          }
        },
        error: function (error) {
          console.log('Error:', error);
          $('#btnObjectSave').html(`{{ trans('global.save') }}`);
          $('#btnObjectUpdate').html(`{{ trans('global.update') }}`);
        }
      });
    });
  </script>
@endpush
