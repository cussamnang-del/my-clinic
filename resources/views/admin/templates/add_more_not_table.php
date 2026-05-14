<div class="field_wrapper">
  <div class="mb-2" id="no-delete">
    <div class="row">
      <div class="col-lg-6">
        <div class="form-group">
          <label for="more_product" class="form-control-label mb-2">{{ trans('cruds.ht.fields.product_id') }}:</label>
          <select id="more_product" name="more_product[]" class="form-control single-select more_product"  style="width: 100%" data-placeholder="Select Medicine">
            <option value="0">{{ trans('global.select') }} {{ trans('cruds.ht.fields.product_id') }}</option>
            @foreach ($products as $key => $row)
              <option value="{{ $row->id }}">{{ $row->p_name }}</option>
            @endforeach
          </select>
          <span class="text-danger error-text more_product_error"></span>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="form-group mb-2">
          <label for="more_qty" class="form-control-label mb-2">{{ trans('cruds.ht.fields.qty') }}:</label>
          <input id="more_qty" name="more_qty[]" class="form-control canenter" type="text" placeholder="{{ trans('cruds.ht.fields.qty') }}">
          <span class="text-danger error-text more_qty_error"></span>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="form-group mb-2">
          <label for="more_how_to_use" class="form-control-label mb-2">{{ trans('cruds.ht.fields.how_to_use') }}:</label>
          <input id="more_how_to_use" name="more_how_to_use[]" class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.how_to_use') }}">
          <input list="how_to_uses" id="more_how_to_use" name="more_how_to_use[]"  class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.how_to_use') }}">
          <span class="text-danger error-text more_how_to_use_error"></span>
        </div>
      </div>
      <div class="col-lg-2 mt-4">
        <label for="">&nbsp;</label>
        <button type="button" class="btn btn-sm btn-success mt-2 add_more_treatment"><i class="fadeIn animated bx bx-plus-medical"></i> Add</button>
      </div>
    </div>
  </div>
</div>
================================================================
<script>
  $(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    // var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var loopcount = $('.field_wrapper .p_count').length+1; //Initial field counter is 1
    //Once add button is clicked
    $('body').on('click','.add_more_treatment',function(){
      var $fieldHTML = $(`
        <div class="mb-2 p_count">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="more_product" class="form-control-label mb-2">{{ trans('cruds.ht.fields.product_id') }}:</label>
                <select id="more_product" name="more_product[]" class="form-control more_product"  style="width: 100%" data-placeholder="Select Medicine">
                  <option value="0">{{ trans('global.select') }} {{ trans('cruds.ht.fields.product_id') }}</option>
                  @foreach ($products as $key => $row)
                    <option value="{{ $row->id }}">{{ $row->p_name }}</option>
                  @endforeach
                </select>
                <span class="text-danger error-text more_product_error"></span>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="form-group mb-2">
                <label for="more_qty" class="form-control-label mb-2">{{ trans('cruds.ht.fields.qty') }}:</label>
                <input id="more_qty_${loopcount}" name="more_qty[]" class="form-control canenter" type="text" placeholder="{{ trans('cruds.ht.fields.qty') }}">
                <span class="text-danger error-text more_qty_error"></span>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="form-group mb-2">
                <label for="more_how_to_use" class="form-control-label mb-2">{{ trans('cruds.ht.fields.how_to_use') }}:</label>
                <input list="how_to_uses" id="more_how_to_use_${loopcount}" name="more_how_to_use[]"  class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.how_to_use') }}">
                <span class="text-danger error-text more_how_to_use_error"></span>
              </div>
            </div>
            <div class="col-lg-2 mt-4">
              <label for="">&nbsp;</label>
              <button type="button" class="btn btn-sm btn-danger mt-2 remove_button_treatment"><i class="fadeIn animated bx bx-trash"></i> Remove</button>
            </div>
          </div>
        </div>
      `);
      var $clone = $fieldHTML.clone();
      //Check maximum number of input fields
      if(loopcount < maxField){
        $(wrapper).append($clone); //Add field html
        loopcount++; //Increment field counter
      }
      $clone.find('.more_product').select2({
        dropdownParent: $('#addNewTreatmentObjectModal'),
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
      });
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button_treatment', function(e){
      e.preventDefault();
      $(this).parent().parent('div').remove(); //Remove field html
      loopcount--; //Decrement field counter
    });
  });
</script>
