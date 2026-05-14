<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Table Head Colors</h2>
  <table class="table">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Document</th>
        <th>User</th>
        <th>Item</th>
        @if ($bios->count()>0)
          @foreach ($bios as $row)
            @foreach ($row->detail as $bio)
              <th>{{ $bio->bio_date }}</th>
            @endforeach
          @endforeach
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach ($bios as $bio)
        <tr>
          <td>{{ $bio->id }}</td>
          <td>{{ $bio->customer_id }}</td>
          <td>{{ $bio->document_id }}</td>
          <td>{{ $bio->user_id }}</td>
          <td>{{ $bio->item_id }}</td>
          @foreach ($bio->detail as $row)
            <td>{{ $row->bio_result }}</td>
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

</body>
</html>


// $.ajax({
  //   type : 'GET',
  //   dataType: 'JSON',
  //   url :`{{ route('admin.documents.gotoService') }}`,
  //   data: {
  //     'document_id':document_id,
  //     'customer_id' : customer_id
  //   },
  //   success:function(res){
  //     var modal = $('#addSeriveObjectModal');
  //     var address =  res.data.village.name_en+' Village, ' + res.data.commune.name_en + ' Commune, ' + res.data.district.name_en + ' District, ' + res.data.province.name_en + ' Province ';
  //     modal.find('#name').val(res.data.customer.name);
  //     modal.find('#age').val(res.data.customer.age);
  //     modal.find('#sex').val(res.data.customer.sex);
  //     modal.find('#customer_id').val(res.data.customer_id);
  //     modal.find('#document_id').val(res.data.id);
  //     modal.find('#address').val(address);
  //     modal.find('#phone_no').val(res.data.customer.phone_no);
  //     modal.find('#rx_bio_name').val(res.data.customer.name);
  //     modal.find('#rx_bio_customer_code').val(res.data.customer.customer_code);
  //     modal.find('#rx_bio_age').val(res.data.customer.age);
  //     modal.find('#rx_bio_sex').val(res.data.customer.sex);
  //     modal.find('#rx_bio_customer_id').val(res.data.customer_id);
  //     modal.find('#rx_bio_phone_no').val(res.data.customer.phone_no);
  //     modal.find('#rx_bio_address').val(address);
  //     modal.find('#rx_bio_document_id').val(res.data.id);
  //     $('#lifeSignModal').find('#document_id').val(res.data.id);
  //     $('#lifeSignModal').find('#exist_customer_id').val(res.data.customer_id);
  //     modal.find('#typeA').empty().append(res.typeA);
  //     modal.find('#typeB').empty().append(res.typeB);
  //     modal.find('#customer_history_information').empty().append(res.customer_histories);
  //     $('#addSeriveObjectModal').modal('show')
  //   },
  //   error:function(err){
  //     console.log(err);
  //   }
  // });


  var document_id = $(this).data('id');
  var customer_id = $(this).data('customer_id');
  var url = `{{ route("admin.documents.gotoService", [":document",":customer"]) }}`;
  url = url.replace(':document', document_id);
  url = url.replace(':customer',customer_id)
  window.open(url,'_blank');
