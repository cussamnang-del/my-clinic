<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rx;
use App\Models\Bio;
use App\Models\User;
use App\Models\HNote;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Document;
use App\Models\Hospital;
use App\Models\Schedule;
use App\Models\DocumentLife;
use Illuminate\Http\Request;
use App\Models\HospitalTreatment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ScheduleController extends Controller
{
  protected $prefix = 'schedule_';

  protected $crudRoutePath = 'schedules';

  public function index()
  {
    abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    $data['schedules'] = Schedule::latest()->get();
    return view('admin.schedule.index',$data);
  }

  public function create()
  {
    $data = [
      'customers' => Customer::all(),
      'users' => User::all(),
    ];
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    return view('admin.schedule.create',$data);
  }

  public function store(Request $request)
  {
    abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $this->validate($request, [
      'title'=>'required',
      'ap_date'=>'required|date',
      'ap_time'=>'required',
      'customer_id'=>'required',
      'user_id'=>'required',
    ]);
    //  Store data in database
    Schedule::create($request->all());
    return back()->with('success', 'Your Schedule has been created Successfully!');
  }

  public function show(Schedule $schedule)
  {
    $data = [
      'customers' => Customer::all(),
      'users' => User::all(),
      'schedule'=> $schedule,
    ];
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    return view('admin.schedule.show',$data);
  }

  public function edit(Schedule $schedule)
  {
    $data = [
      'customers' => Customer::all(),
      'users' => User::all(),
      'schedule'=> $schedule,
    ];
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    return view('admin.schedule.edit',$data);
  }

  public function update(Request $request, Schedule $schedule)
  {
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $this->validate($request, [
      'title'=>'required',
      'ap_date'=>'required|date',
      'ap_time'=>'required',
      'customer_id'=>'required',
      'user_id'=>'required',
    ]);
    //  Store data in database
    $schedule->update($request->all());
    return back()->with('success', 'Your Schedule has been updated Successfully!');
  }

  public function destroy(Schedule $schedule)
  {
    abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    if($schedule->delete()){
      return response()->json([
        'schedule' => $schedule,
        'success'=>'Schedule has been deleted successfully!'
      ],200);
    } else {
      return response()->json([
        'error'=>'Unable to locate the event'
      ],404);
    }
  }

  public function changeStatus(Request $request)
  {
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response = Schedule::find($request->object_id);
    $response->status = $request->status;
    $response->save();
    return response()->json(['success'=>'Status has been change successfully!']);
  }

  public function showCalendar(Request $request)
  {
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    $schedules = Schedule::all();
    $data['events'] = [];
    foreach($schedules as $row){
      $data['events'][] = [
        'id'    => $row->id,
        'title' => $row->title.' Doctor:'. $row->user->name .' Customer:'. $row->customer->name,
        'start' => $row->start_time,
        'end'   => $row->finish_time,
        'customer_id' => $row->customer_id,
        'user_id' => $row->user_id,
        'status'  => $row->status,
        'desr'  => $row->desr,
        'color' => $row->color,
        'url'   => route('admin.schedules.showScheduleDocument',$row->id),
      ];
    }
    return view('admin.schedule.calendar',$data);
  }

  public function showScheduleDocument(Schedule $schedule)
  {
    // abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $data['document'] = Document::where('customer_id',$schedule->customer_id)->get();
    $data['customer'] = Customer::findOrFail($schedule->customer_id);
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    $data['documentRoute'] = 'documents';
    $data['typeA'] = DocumentLife::where('customer_id','=',$data['customer']->id)
          ->where('coltype','=',1)
          ->groupBy('colfield')
          ->get();
    $data['typeB']= DocumentLife::where('customer_id','=',$data['customer']->id)
        ->where('coltype','=',2)
        ->groupBy('colfield')
        ->get();
    $data['documents'] = Document::hospital(0)->where('customer_id',$schedule->customer_id)->latest()->get();
    $data['document_hospitals'] = Document::hospital(1)->where('customer_id',$schedule->customer_id)->latest()->get();
    return view('admin.schedule.schedule_document',$data);
  }

  public function showDetailByDocument($document_id,$customer_id)
  {
    $data['document'] = Document::where('id',$document_id)->get();
    $data['customer'] = Customer::findOrFail($customer_id);
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    $data['documentRoute'] = 'documents';
    $data['typeA'] = DocumentLife::where('customer_id','=',$data['customer']->id)
        ->where('coltype','=',1)
        ->groupBy('colfield')
        ->get();
    $data['typeB']= DocumentLife::where('customer_id','=',$data['customer']->id)
      ->where('coltype','=',2)
      ->groupBy('colfield')
      ->get();
    $hids = Hospital::where('customer_id',$data['customer']->id)->get()->map(function($hospital){
      return $hospital->id;
    });
    $data['bios'] = Bio::where('customer_id',$data['customer']->id)->get();
    $data['rx_details'] = Rx::where('customer_id',$data['customer']->id)->get();
    $data['hospitals'] = Hospital::where('customer_id',$data['customer']->id)->get();
    $data['orders'] = Order::where('customer_id',$data['customer']->id)->get();
    $data['hospital_treatments'] = HospitalTreatment::whereIn('hospital_id', $hids)->orderBy('ht_date','DESC')->get()->groupBy('ht_date');
    $data['hnotes'] = HNote::whereIn('hospital_id', $hids)->orderBy('date','DESC')->get()->groupBy('date');
    // return $data;
    return view('admin.schedule.schedule_document_detail',$data);
  }
}
