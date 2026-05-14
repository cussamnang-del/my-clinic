<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Province;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{

  protected $prefix = 'customer_';

  protected $crudRoutePath = 'customers';

  public function index()
  {
    abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    $data['customers'] = Customer::latest()->get();
    $data['provinces'] = Province::all();
    return view('admin.customer.index',$data);
  }

  public function store(Request $request)
  {
    abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $object_id= $request->object_id;
    $rules = [
      'name' => ['required','string'],
      'sex' => ['required','string'],
      'age' => ['required','string'],
      'dob' => ['required','date'],
      // 'province_id' => ['required'],
      // 'district_id' => ['required'],
      // 'commune_id' => ['required'],
      // 'village_id' => ['required'],
      // 'phone_no' => ['required'],
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
      $response = [
        'status' => 400,
        'error' =>$validator->errors()->toArray()
      ];
      return response()->json($response);
    } else {
      if($request->status){
        $status = true;
      } else {
        $status = false;
      }
      if($request->hasFile('photo')){
        $image = $request->file('photo');
        $image_name = Str::slug($request->name).'-'. uniqid().'.'. $image->getClientOriginalExtension();
        $image->move(public_path('uploads/customer/'),$image_name);
      } else {
        if($request->old_image){
          $image_name = $request->old_image;
        } else {
          $image_name = null;
        }
      }
      $datas   =   Customer::updateOrCreate([
        'id' => $object_id],
        [
          'customer_code' => null,
          'name' => $request->name,
          'sex' => $request->sex,
          'age' => $request->age,
          'dob' => $request->dob,
          'province_id' => $request->province_id ?? null,
          'district_id' => $request->district_id ?? null,
          'commune_id' => $request->commune_id ?? null,
          'village_id' => $request->village_id ?? null,
          'phone_no' => $request->phone_no ?? null,
          'photo'   => $image_name,
          'register_date' => date('Y-m-d', strtotime($request->register_date)),
          'register_by' => Auth::id(),
          'status' => $status
      ]);
      if($datas){
        if(!$object_id){
          Document::create([
            'customer_id' => $datas->id,
            'user_id' => Auth::id(),
            'visit_date' => $datas->register_date,
            'status' =>true
          ]);
        }
      }
      if($object_id){
        $type = 'update-object';
        $success = 'Customer has been Updated!';
      } else {
        $type = 'store-object';
        $success = 'Customer has been registered!';
      }
      $response = [
        'status'   => 200,
        'type'    => $type,
        'data'    => $datas,
        'success' => $success,
        'html'    => view('admin.customer.templates.ajax_tr',[
          'row'=> $datas,
          'prefix'=>$this->prefix,
          'crudRoutePath'=> $this->crudRoutePath])
          ->render(),
      ];
    }
    return response()->json($response);
  }

  public function show(Customer $customer)
  {
    abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    $data['customers'] = $customer;
    // $data['customers'] = Customer::latest()->get();
    $data['provinces'] = Province::all();
    return view('admin.customer.index',$data);
  }

  public function edit(Customer $customer)
  {
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response=[
      'data' => $customer,
    ];
    return response()->json($response);
  }

  public function destroy(Customer $customer)
  {
    abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $deleteImage = public_path('uploads/customer/'.$customer->photo);
    if($customer->delete()){
      if(!empty($customer->photo)){
        unlink($deleteImage);
      }
    }
    return response()->json(['success'=>'Customer has been deleted successfully!']);
  }

  public function changeStatus(Request $request)
  {
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response = Customer::find($request->object_id);
    $response->status = $request->status;
    $response->save();
    return response()->json(['success'=>'Status has been change successfully!']);
  }

}
