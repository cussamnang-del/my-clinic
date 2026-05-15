<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name')}}-Bio Analysting</title>
  {{-- <link href="https://fonts.googleapis.com/css2?family=Moul&family=Moulpali&family=Noto+Sans+Khmer:wght@400;700;900&display=swap" rel="stylesheet"> --}}
  <link rel="stylesheet" href="{{ asset('assets/backend') }}/css/bio_invoice.css">
  <link href="{{ asset('assets/backend') }}/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    *{
      margin: 0;
      padding: 0;
    }
    body, html {
      /* font-family: 'Cambria', Cochin, Georgia, Times, serif; */
      /* font-family: 'Moul', cursive; */
      /* font-family: 'Moulpali', cursive; */
      font-family: 'Noto Sans Khmer', sans-serif;
      font-size: 15px;
      font-weight: 400;
      line-height: 1;
    }
    #print-area {
      margin-top:15px;
    }
    .top-logo table tr td {
      line-height: 1;
    }
    .top-logo img{
      width: 130px;
      height: 130px;
      border-radius: 50%;
    }
    .footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      /* background-color: red; */
      /* color: white; */
      text-align: right;
    }
  </style>
</head>
<body>

  <div class="container" id="print_bio">
    <div class="row">
      <div class="col-lg-10 offset-lg-1 offset-md-1">
        <div class="row top-banner">
          <div class="table-responsive">
            <table class="table table-borderless">
              <tr>
                <td width="10%" rowspan="3">
                  <img src="{{ uploadUrl().'/logo/kong_rithy_logo.png' }}" alt="" width="90px" height="70px">
                </td>
                <td width="80%" align="center" style="font-family: 'Moul', cursive; font-size:30px;padding-top: 10px;">
                  {{$setting->name_kh}}
                </td>
                <td width="10%"></td>
              </tr>
              <tr>
                <td width="80%" align="center" style="font-size:18px;font-weight:700;">
                  {{$setting->name_en}}
                </td>
                <td width="10%"></td>
              </tr>
              <tr>
                <td width="80%" align="center"​ style="font-family: 'Noto Sans Khmer', sans-serif; font-size:20px;">
                  {{$setting->address}}
                </td>
                <td width="10%"></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Top Logo -->
        <div class="row top-logo">
          <div class="table-responsive">
            <table class="table table-borderless">
              <tr>
                <td width="50%">
                  Lab Tell : {{$setting->phone1}}
                </td>
                <td width="50%">
                  Nom et Sugnatujre du Medicine : {{$bDetail[0]->user->name}}
                </td>
              </tr>
              <tr>
                <td width="50%">
                  Date : <?php echo date('d-M-Y') ?>
                </td>
                <td width="50%">
                  Nom et Prénom : {{$bDetail[0]->customer->name}}
                </td>
              </tr>
              <tr>
                <td width="50%">
                  Code : {{$bDetail[0]->customer->customer_code}}
                </td>
                <td width="50%">
                  <span>Sexe : {{$bDetail[0]->customer->sex}} </span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Age : {{$bDetail[0]->customer->age}}</span>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <hr>
        {{-- ANALYING INFORMATION--}}
        <div class="row">
          <div class="table-responsive">
            <table class="table table-borderless">
              @foreach ($bDetail as $key => $group)
                <tr>
                  <td align="center">
                    <h4><b>{{$group->itemGroup->name}}</b></h4>
                    <?php
                      $itemTypes =  App\Models\BioDetail::where('customer_id',$customer)->where('document_id',$document)
                                                          ->whereDate('bio_date', '=', $print_date)
                                                          ->where('item_group_id',$group->item_group_id)->get()->unique('item_type_id');
                      ?>
                    @foreach ($itemTypes as $type)
                      <tr>
                        <td>
                          <strong><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>{{$type->itemType->name}}</strong>
                          <?php
                            $items =  App\Models\BioDetail::where('customer_id',$customer)->where('document_id',$document)
                                                          ->whereDate('bio_date', '=',  $print_date)
                                                          ->where('item_type_id',$type->item_type_id)->get();
                          ?>
                          @foreach ($items as $item)
                            <tr>
                              <td width="60%">
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                {{$item->item->item_name}}
                              </td>
                              <td width="15%">
                                @if ($item->bio_result < $item->item->min_value || $item->bio_result>$item->item->max_value)
                                  <strong style="font-size: 16px">{{$item->bio_result}}</strong>
                                @else
                                  {{$item->bio_result}}
                                @endif
                              </td>
                              <td width="15%">
                                {{$item->item->normal_value}}
                              </td>
                              <td width="10%">
                                {{ $item->item->uvn }}
                              </td>
                            </tr>
                          @endforeach
                        </td>
                      </tr>
                    @endforeach
                  </td>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
        <!-- SIGNATURE -->
      </div>
    </div>
    <footer>
      <div class="row​​​ footer">
        <div class="col-lg-10 offset-lg-1 offset-md-1">
          <div class="table-responsive">
            <table class="table table-borderless">
              <tr>
                <td>
                  <h5>Kong Rithy</h5>
                </td>
              </tr>
              {{-- <tr>
                <td class="text-end">
                  <h5>Kong Rithy</h5>
                </td>
              </tr> --}}
            </table>
          </div>
        </div>
      </div>
    </footer>
  </div>
<!--plugins-->
  <script src="{{ asset('assets/backend') }}/js/jquery.min.js"></script>
  <!-- Bootstrap bundle JS -->
  <script src="{{ asset('assets/backend') }}/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript">
    printContent('print_bio');
    function printContent(el)
    {
      //var restorpage=document.body.innerHTML;
      var printloc=document.getElementById(el).innerHTML;
      document.body.innerHTML=printloc;
      window.print();
      window.onafterprint = function(){ window.close()};
    }
  </script>
</body>
</html>
