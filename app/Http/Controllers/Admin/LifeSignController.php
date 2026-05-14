<?php

namespace App\Http\Controllers\Admin;

use App\Models\LifeSign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class LifeSignController extends Controller
{
  protected $prefix = 'lifesign_';

  protected $crudRoutePath = 'lifesigns';

  public function index()
  {
    abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    $data['lifesigns'] = LifeSign::where('type_id','=',0)->pluck('name','id')->all();
    $data['all_lifesigns'] = LifeSign::where('type_id','<>',0)->latest()->get();
    return view('admin.lifesign.index',$data);
  }

  public function store(Request $request)
  {
    abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    if($request->status){
      $status = true;
    } else {
      $status = false;
    }
    $object_id= $request->object_id;
    $validator = Validator::make($request->all(),[
      'name'  => ['required','string']
    ]);
    if($validator->fails()){
      $response = [
        'status'    => 400,
        'error'    => $validator->errors()->toArray(),
      ];
      return response()->json($response);
    }
    else {
      $datas   =   LifeSign::updateOrCreate([
        'id' => $object_id],
        [
          'type_id' => $request->type_id,
          'name' => $request->name,
          'status' => $status
      ]);
      if($object_id){
        $type = 'update-object';
        $success = 'Lifesign has been Updated!';
      } else {
        $type = 'store-object';
        $success = 'Lifesign has been registered!';
      }
      $response = [
        'status'    => 200,
        'type'    => $type,
        'data'    => $datas,
        'success' => $success,
        'html'    => view('admin.lifesign.templates.ajax_tr',[
          'row'=> $datas,
          'prefix'=>$this->prefix,
          'crudRoutePath'=> $this->crudRoutePath])
          ->render(),
      ];
    }
    return response()->json($response);
  }

  public function show($id)
  {
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response = [
      'data' => LifeSign::find($id)
    ];
    return response()->json($response);
  }

  public function edit($id){
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response = [
      'data' => LifeSign::find($id)
    ];
    return response()->json($response);
  }

  public function destroy($id)
  {
    abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    LifeSign::find($id)->delete();
    return response()->json(['success'=>'Item has been deleted successfully!']);
  }

  public function changeStatus(Request $request)
  {
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response = LifeSign::find($request->object_id);
    $response->status = $request->status;
    $response->save();
    return response()->json(['success'=>'Status has been change successfully!']);
  }
}
