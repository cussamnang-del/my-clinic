<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name')}}-Operative Protocols</title>
  <link href="{{ asset('assets/backend') }}/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    *{
      margin: 0;
      padding: 0;
    }
    body, html {
      font-family: 'Cambria', Cochin, Georgia, Times, serif;
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
              <td width="15%" rowspan="4">
                <img src="{{ asset('images/avatar3.png') }}" alt="">
              </td>
              <td width="85%" align="right">
                Mondol 3 Village, Slorkram Commune, Siem Reap Province
              </td>
            </tr>
            <tr>
              <td width="85%" align="right">
                Tel : 063 569 638, 012 698 254
              </td>
            </tr>
            <tr>
              <td width="85%" align="right">
                Email: kong_rithy@yahoo.com
              </td>
            </tr>
            <tr>
              <td width="85%" align="right">
                Date :17/11/2022 16:25
              </td>
            </tr>
          </table>
        </div>
      </div>
      {{-- doctor information --}}
      <div class="row doctor-infor">
        <div class="table-responsive">
          <table class="table table-borderless">
            <tr>
              <td width="15%">Opèrateur</td>
              <td width="85%">Dr. Kong Sunly</td>
            </tr>
            <tr>
              <td width="15%">Aide</td>
              <td width="85%">inf.BOREI</td>
            </tr>
            <tr>
              <td width="15%">Anesthésiste</td>
              <td width="85%">Dr.Poleak</td>
            </tr>
          </table>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr align="center">
                <th>NOM</th>
                <th>PRÈNOM</th>
                <th>SEX</th>
                <th>ÂGE</th>
              </tr>
            </thead>
            <tbody>
              <tr align="center">
                <td>THEN</td>
                <td>HONGSEANG</td>
                <td>MALE</td>
                <td>40</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      {{-- Operator Protocols --}}
      <div class="row">
        <div class="col-xl-12">
          <h2 class="text-center protocol">Protocole opératoire</h2>
        </div>
      </div>
      <div class="row">
        <div class="table-responsive">
          <table class="table table-borderless">
            <tr>
              <td width="20%">Dianostic pré-opé:</td>
              <th width="80%">
                {{ isset($OperativeProtocol)?$OperativeProtocol->diapre:'' }}
              </th>
            </tr>
            <tr>
              <td width="20%">Dianostic per-opé:</td>
              <th width="80%">
                {{ isset($OperativeProtocol)?$OperativeProtocol->diaper:'' }}
              </th>
            </tr>
            <tr>
              <td width="20%">Indication:</td>
              <th width="80%">
                {{ isset($OperativeProtocol)?$OperativeProtocol->indication:'' }}
              </th>
            </tr>
            <tr>
              <td width="20%">Position:</td>
              <th width="80%">
                {{ isset($OperativeProtocol)?$OperativeProtocol->position:'' }}
              </th>
            </tr>
          </table>
        </div>
      </div>
      {{-- detail note --}}
      <div class="row">
        <div class="table-responsive">
          <table class="table table-borderless">
            <tr>
              <td width="100%">
                {!! isset($OperativeProtocol)?$OperativeProtocol->note:'' !!}
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="table-responsive">
          <table class="table table-borderless">
            <tr>
              <td width="20%" rowspan="2">Consigne</td>
              <td width="80%">-Ablation de drain............................</td>
            </tr>
            <tr>
              <td width="80%">-Ablation de drain............................</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- SIGNATURE -->
			{{-- <div class="row​​​ footer">
        <div class="col-xl-12 col-lg-12">
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
      <br><br><br>
      <div class="row​​​ footer">
        <div class="col-xl-12 col-lg-12">
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
			</div> --}}
		</div>
  </div>
</div>

<!--plugins-->
  <script src="{{ asset('assets/backend') }}/js/jquery.min.js"></script>
  <!-- Bootstrap bundle JS -->
  <script src="{{ asset('assets/backend') }}/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/backend') }}/js/jquery.PrintArea.js"></script>
  <script type="text/javascript">
    // printContent('print-area');
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
