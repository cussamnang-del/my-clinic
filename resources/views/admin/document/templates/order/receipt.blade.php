<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name')}}-Medicine Order</title>
  <link href="{{ asset('assets/backend') }}/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="{{ asset('assets/backend') }}/css/invoice.css">
  <style>
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

<div class="container" id="print-area">
  <div class="row">
		<div class="col-lg-10 offset-lg-1 offset-md-1">
      <!-- Top Logo -->
			<div class="row top-logo">
        <div class="table-responsive">
          <table class="table table-borderless">
            <tr>
              <td style="width: 15%;" class="text-end">
                <img src="{{ uploadUrl() }}/logo/{{$setting->logo}}" width="100px" height="100px" alt="">
              </td>
              <td class="text-center">
                <h2 class="kh-header">{{$setting->name_kh}}</h2>
                <h2 class="latin">{{$setting->name_en}}</h2>
                <h6 class="latin">Tel: {{$setting->phone1}}{{$setting->phone2?' / ':''}}{{$setting->phone2}}{{$setting->phone3?' / ':''}}{{$setting->phone3}}</h6>
                <p class="khcontent">{{$setting->address}}</p>
              </td>
              <td style="width: 15%;" class="text-start">
                <img src="{{ uploadUrl() }}/logo/{{$setting->logo}}" width="100px" height="100px" alt="">
              </td>
            </tr>
          </table>
        </div>
      </div>
      <!-- វេជ្ជបញ្ជា -->
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<h3 class="text-center kh-header">វេជ្ជបញ្ជា</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-12 col-lg-12">
          <div class="table-responsive">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <th>PATIENT</th>
                  <td>{{ $order->customer->name }}</td>
                  <th>SEX</th>
                  <td>{{ $order->customer->sex }}</td>
                  <th>AGE</th>
                  <td>{{ $order->customer->age }}</td>
                  <th>DATE</th>
                  <td>{{ $order->order_date }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="table-responsive">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <th>HISTORY</th>
                  <td>checkup</td>
                  <th>PAST HISTORY</th>
                  <td>{{ $order->past_history }}</td>
                </tr>
                <tr>
                  <th>BLOOD TEST</th>
                  <td>{{ $order->blood_test }}</td>
                  <th>ORL/ENT</th>
                  <td>{{ $order->orl_ent }}</td>
                </tr>
                <tr>
                  <th>ULTRA SOUND</th>
                  <td>{{ $order->ultra_sound }}</td>
                  <th>ECG</th>
                  <td>{{ $order->egc }}</td>
                </tr>
                <tr>
                  <th>X-RAY</th>
                  <td>{{ $order->x_ray }}</td>
                  <th>ETAT</th>
                  <td>{{ $order->et_at }}</td>
                </tr>
                <tr>
                  <th>DIAGNOSIS</th>
                  <td>{{ $order->diagnosis }}</td>
                </tr>
              </tbody>
            </table>
          </div>
				</div>
			</div>
      <!-- ការព្យាបាល -->
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<h3 class="text-center kh-header">ការព្យាបាល</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-12 col-lg-12">
          <div class="table-responsive">
            <table class="table table-borderless">
              <thead>
                @forelse ($order->details as $detail)
                  <tr>
                    <th>{{ $detail->product->p_name }}</th>
                    <th>{{ $detail->strength }}</th>
                    <th>{{ $detail->qty }}</th>
                    <th>{{ $detail->unit }}</th>
                    <th>{{ $detail->how_to_use }}</th>
                    <th class="khcontent">{{ $detail->before_after }}</th>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5">No Order Found</td>
                  </tr>
                @endforelse
              </thead>
            </table>
          </div>
				</div>
			</div>
		</div>
  </div>
  <!-- SIGNATURE -->
  <footer class="footer">
    <div class="col-lg-10 offset-lg-1 offset-md-1">
      <div class="row">
        <div class="col-lg-10 offset-lg-1 offset-md-1"">
          <div class="table-responsive">
            <table class="table table-borderless">
              <tr>
                <td class="text-start">
                  <h5>RECOMMENDATION</h5>
                </td>
                <td class="text-center">
                  <h5>SIGNATURE</h5>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-lg-10 offset-lg-1 offset-md-1"">
          <div class="table-responsive">
            <table class="table table-borderless">
              <tr>
                <td class="text-start">
                  <h5>Recommendation</h5>
                </td>
                <td class="text-center">
                  <h5>Kong Rithy</h5>
                </td>
              </tr>
            </table>
          </div>
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
    printContent('print-area');
    function printContent(el)
    {
      var printloc=document.getElementById(el).innerHTML;
      document.body.innerHTML=printloc;
      window.print();
      window.onafterprint = function(){ window.close()};
    }
  </script>
</body>
</html>
