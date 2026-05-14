<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hanuman:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <style>
    #invoice-pos{
      box-shadow: 0 0 1in -0.25in rgb(0,0,0.5);
      padding:0mm;
      margin:0 auto;
      width:60mm;
      background:#fff;
    }
    #invoice-pos ::selection{
      background:#34495E;
      color:#fff;
    }
    #invoice-pos ::-mox-selection{
      background:#34495E;
      color:#fff;
    }
    thead{
      font-family:'Noto Sans Khmer', sans-serif;
      font-size:12px;
      padding:0px;
      color:black;
    }
    tbody{
      font-family:arial;
      font-size:10px;
      padding:0px;
    }
    .logo{
      font-family:khmer os muol light;
      font-size:22px;
      margin-top:5px;
      color:black;
    }
    .info{
      font-family:khmer os muol light;
      font-size:16px;
      color:black;
    }
    #top p{
      font-family:'Noto Sans Khmer', sans-serif;
      font-size:12px;
      margin-left:5px;
      padding:0px;
      color:black;
    }
    .receipt_info{
      border-style:none;
      font-family:'Noto Sans Khmer', sans-serif;
      font-size:12px;
      color:black;
      padding:0px;
      margin-left:5px;
    }
    .service{
      font-family:'Noto Sans Khmer', sans-serif;
      font-size:12px;
      color:black;
    }
  </style>
    @php
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
    <body>
        <div id="invoice-pos">
          <div class="" style="margin-top:0px;">
              <table class="table table-bordered" style="width:100%;">
                <tbody>
                  @php
                    $buy='';
                    $curbuy='';
                    $sale='';
                    $cursale='';
                    $sign='';
                    if($e->product<0){
                      $buy=$e->amount;
                      $curbuy=$e->maincur;
                      $sale=abs($e->product);
                      $cursale=$e->pcur;
                    }else{
                      $buy=$e->product;
                      $curbuy=$e->pcur;
                      $sale=abs($e->amount);
                      $cursale=$e->maincur;
                    }
                    if(abs($e->product)>abs($e->amount)){
                      if($e->amount>0){
                        $sign='*';
                      }else{
                        $sign='/';
                      }
                    }else{
                      if($e->amount>0){
                        $sign='/';
                      }else{
                        $sign='*';
                      }
                    }
                  @endphp
                  <tr class="service">
                    <td>
                      {{ phpformatnumber($buy) }} <sup style="font-size:6px;">{{ $curbuy }}</sup>
                      <sub>{{ $sign }}</sub> {{ phpformatnumber($e->rate) . '=' }}
                      {{ phpformatnumber($sale) }} <sup style="font-size:6px;">{{ $cursale }}</sup>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="legalcopy">
                <p class=""legal>
                <p style="font-family:Noto Sans Khmer,sans-serif;font-size:12px;text-align:center;color:black;">សូមអរគុណចំពោះការអញ្ជើញមក <br>
                    Thank you for your visiting
                </p>
                </p>
              </div>
              <div class="serial-number">
              </div>
          </div>
        </div>
    </body>
    <script type="text/javascript">
      printContent('invoice-pos');
      function printContent(el)
      {
        //var restorpage=document.body.innerHTML;
        var printloc=document.getElementById(el).innerHTML;
        document.body.innerHTML=printloc;
        window.print();
        window.onafterprint = function(){ window.close()};
        //history.back();
        //document.body.innerTHML=restorpage;
      }
    </script>

  {{-- function print(id){
    var htp=window.location.protocol;
    var htn=window.location.hostname;
    var redirectWindow = window.open(htp+'//'+htn+'/chaybros.com/exchange/print?id='+id, '_blank');
    redirectWindow.location;
  }
  public function exchangeprint(Request $request){
    $e=Exchange::where('id',$request->id)->first();
    return view('exchanges.receipt',compact('e'));
  } --}}
</html>
