<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name')}}-Medicine Certificate</title>
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
    .top-logo td,th {
      line-height: 1;
      font-size: 12px;
    }
    .top-logo img{
      width: 100px;
      height: 100px;
      border-radius: 50%;
    }
    .doctor-infor td,th{
      font-size: 13px;
      line-height: 1;
    }
    .medical {
      font-weight: 600;
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
              <td rowspan="4">
                <img src="{{ asset('images/avatar3.png') }}" alt="">
              </td>
              <td>Mondol 3 Village, Slorkram Commune,</td>
              <th>
                Name of Patient
              </th>
              <td>{{ isset($MedicalCertificate)?$MedicalCertificate->customer->name:'' }}</td>
              <th>
                Patient ID
              </th>
              <td>{{ isset($MedicalCertificate)?$MedicalCertificate->customer->customer_code:'' }}</td>
            </tr>
            <tr>
              <td>Siemreap Province</td>
              <th>
                Date of Birth
              </th>
              <td>{{ isset($MedicalCertificate)?date('d-m-Y',strtotime($MedicalCertificate->customer->dob)):'' }}</td>
              <th>
                Nationality
              </th>
              <td>{{ isset($MedicalCertificate)?$MedicalCertificate->customer->nationality:'' }}</td>
            </tr>
            <tr>
              <td>Tel: 063 356 885, 012 693 125</td>
              <th>
                Age
              </th>
              <td>{{ isset($MedicalCertificate)?$MedicalCertificate->customer->age:'' }}</td>
              <th>
                Passport N<sup>o</sup>
              </th>
              <td>{{ isset($MedicalCertificate)?$MedicalCertificate->customer->passport_no:'' }}</td>
            </tr>
            <tr>
              <td>Email: kong_rithy@yahoo.com</td>
              <th>
                Gender
              </th>
              <td>{{ isset($MedicalCertificate)?$MedicalCertificate->customer->sex:'' }}</td>
              <th>
                Date of Visit
              </th>
              <td>{{ isset($MedicalCertificate)?date('d-m-Y',strtotime($MedicalCertificate->document->visit_date)):'' }}</td>
            </tr>
          </table>
        </div>
      </div>
      {{-- Medical Certificate --}}
      <div class="row">
        <div class="col-xl-12">
          <h2 class="text-center medical">Medical Certificate</h2>
        </div>
      </div>
      {{-- Detail information --}}
      <div class="row doctor-infor">
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <tr>
              <th>Chief Complaint/Present Illness</th>
            </tr>
            <tr>
              <td>
                {{ isset($MedicalCertificate)?$MedicalCertificate->chief_complain:'' }}
              </td>
            </tr>
            {{-- ==================================================== --}}
            <tr>
              <th>Underlaying Disease/Past History</th>
            </tr>
            <tr>
              <td>
                {{ isset($MedicalCertificate)?$MedicalCertificate->past_history:'' }}
              </td>
            </tr>
            {{-- ==================================================== --}}
            <tr>
              <th>Physical Examination/Investigation/Laboratory/Imaging</th>
            </tr>
            <tr>
              <td>
                {{ isset($MedicalCertificate)?$MedicalCertificate->examination:'' }}
              </td>
            </tr>
            {{-- ==================================================== --}}
            <tr>
              <th>Dianosis</th>
            </tr>
            <tr>
              <td>
                {{ isset($MedicalCertificate)?$MedicalCertificate->diagnosis:'' }}
              </td>
            </tr>
            {{-- ==================================================== --}}
            <tr>
              <th>Treatment plan (for surgical procedure with approximate length of stay)</th>
            </tr>
            <tr>
              <td>
                {{ isset($MedicalCertificate)?$MedicalCertificate->treatment:'' }}
              </td>
            </tr>
          </table>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <tr>
              <th colspan="6">Physician's recommendation</th>
            </tr>
            <tr>
              <td width="40%">
                <input type="checkbox" name="sick_leave" id="sick_leave" {{ isset($MedicalCertificate)?$MedicalCertificate->is_sick==1?'checked':'':'' }}>
                <label for="">Sick Leave (if suggested by Physician):</label>
              </td>
              <td width="10%">From:</td>
              <td width="20%">
                {{ isset($MedicalCertificate)?date('d-m-Y',strtotime($MedicalCertificate->from_date)):'' }}
              </td>
              <td width="10%">To:</td>
              <td width="20%">
                {{ isset($MedicalCertificate)?date('d-m-Y',strtotime($MedicalCertificate->to_date)):'' }}
              </td>
            </tr>
            {{-- ==================================================== --}}
            <tr>
              <td width="100%" colspan="5">
                <input type="checkbox" name="is_other" id="is_other" {{ isset($MedicalCertificate)?$MedicalCertificate->is_other==1?'checked':'':'' }}>
                <label for="is_other">Other:</label>
                {{ isset($MedicalCertificate)?$MedicalCertificate->note:'' }}
              </td>
            </tr>
            {{-- ==================================================== --}}
            <tr>
              <th colspan="5">Attending Physician</th>
            </tr>
            <tr>
              <td colspan="5">
                <p>{{ isset($MedicalCertificate)?$MedicalCertificate->attending:'' }}</p>
              </td>
            </tr>
            <tr>
              <th colspan="5">Date: {{ isset($MedicalCertificate)?date('d-m-Y',strtotime($MedicalCertificate->date)):'' }}</th>
            </tr>
          </table>
        </div>
      </div>
		</div>
  </div>
</div>

<!--plugins-->
  <script src="{{ asset('assets/backend') }}/js/jquery.min.js"></script>
  <script src="{{ asset('assets/backend') }}/js/bootstrap.bundle.min.js"></script>
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
