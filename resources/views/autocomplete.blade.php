@extends('admin.admin_layout')

@section('content')
@php
  $imgpath=asset('images/minus.png');
  function phpformatnumber($num){
    $dc=0;
    $p=strpos((float)$num,'.');
    if($p>0){
    $fp=substr($num,$p,strlen($num)-$p);
    $dc=strlen((float)$fp)-2;

    }
    return number_format($num,$dc,'.',',');
  }
@endphp
<input type="hidden" id="image_path" value="{{ $imgpath }}">
<div class="container">
  <div class="row">
    <div class="col-sm-12 col-md-9 offset-md-1">
      <h1>Auto Complete Table Input</h1>
      <form action="">
        <div class="table-responsive">
          <table id="autocomplete_table" class="table table-hover autocomplete_table">
            <thead class="thead-light">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Country Name</th>
                <th scope="col">Country Number</th>
                <th scope="col">Country Phone Code</th>
                <th scope="col">Contry Code</th>
              </tr>
            </thead>
            <tbody>
              <tr id="row_1">
                <th id="delete_1" scope="row" class="delete_row"><img src="{{ $imgpath }}" alt=""></th>
                <td>
                  <input type="text" data-field-name="name" name="countryname[]" id="countryname_1" class="form-control autocomplete_txt" autocomplete="off">
                </td>
                <td>
                  <input type="text" data-field-name="numcode" name="no[]" id="countryno_1" class="form-control">
                </td>
                <td>
                  <input type="text" data-field-name="phonecode" name="phone_code[]" id="phone_code_1" class="form-control">
                </td>
                <td>
                  <input type="text" data-field-name="iso3" name="country_code[]" id="country_code_1" class="form-control">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="btn-container">
          <button class="btn btn-success" id="addNew" type="button">
            Add New
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
  $(document).ready(function(){
    var rowcount,addBtn,tableBody,imgPath,basePath;
    addBtn=$('#addNew');
    rowcount=$('#autocomplete_table tbody tr').length+1;
    tableBody=$('#autocomplete_table tbody');
    imgPath= $('#image_path').val();
    basePath=$('#base_path').val();
    console.log(imgPath);
    function deleteRow(){
        var rowNo;
        id=$(this).attr('id');
        console.log(id);
        idArr=id.split('_');
        console.log(idArr);
        rowNo=idArr[idArr.length-1];
        console.log(rowNo);
        $('#row_'+rowNo).remove();
    }
    function addNewRow(){
      var html=formHtml();
      tableBody.append(html);
    }
    function formHtml(){
      html=`
        <tr id="row_${rowcount}">
          <th id="delete_${rowcount}" scope="row" class="delete_row"><img src="${imgPath}" alt=""></th>
          <td>
              <input type="text" data-field-name="name" name="countryname[]" id="countryname_${rowcount}" class="form-control autocomplete_txt" autocomplete="off">
          </td>
          <td>
              <input type="text" data-field-name="numcode" name="no[]" id="countryno_${rowcount}" class="form-control">
          </td>
          <td>
              <input type="text" data-field-name="phonecode" name="phone_code[]" id="phone_code_${rowcount}" class="form-control">
          </td>
          <td>
              <input type="text" data-field-name="iso3" name="country_code[]" id="country_code_${rowcount}" class="form-control">
          </td>
        </tr>
        `
        rowcount++;
        return html;
    }
    function registerEvents(){
      addBtn.on('click',addNewRow)
      $(document).on('focus','.autocomplete_txt',handleAutocomplete);
    }
    function handleAutocomplete(){
      var fieldName,currentEle;
      currentEle=$(this);
      fieldName=currentEle.data('field-name');
      console.log(currentEle)
      console.log(fieldName)
      if(typeof fieldName==='undefined'){
        return false;
      }
      currentEle.autocomplete({
        source:function(data,cb){
          $.ajax({
            url:'get-countries',
            method:'GET',
            dataType:'json',
            data:{
              name:data.term,
              fieldname:fieldName
            },
            success:function(res){
              var result;
              result=[
                {
                  label:'There is no matching record found for ' + data.term,
                  value:''
                }
              ];
              if(res.length){
                result=$.map(res,function(obj){
                  return{
                    label:obj[fieldName],
                    value:obj[fieldName],
                    data:obj
                  };
                });
              }
              cb(result);
            }
          });
        },
        autoFocus:true,
        minLength:2,
        // select:function(event,selectedData){
        //   if(selectedData && selectedData.item && selectedData.item.data){
        //     console.log(selectedData);
        //     var rowNo,data;
        //     rowNo=getId(currentEle);
        //     data=selectedData.item.data;
        //     $('#countryname_'+rowNo).val(data.name);
        //     $('#countryno_'+rowNo).val(data.numcode);
        //     $('#phone_code_'+rowNo).val(data.phonecode);
        //     $('#country_code_'+rowNo).val(data.iso3);
        //   }
        // }
      });
    }
    // function getId(element){
    //   var id,idAtt;
    //   id=elelement.attr('id');
    //   idArr=id.split("_");
    //   return idArr[idArr.length-1];
    // }
    registerEvents();
  })
</script>
@endpush
