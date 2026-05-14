<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
  protected $prefix = 'permission_';

  protected $crudRoutePath = 'permissions';

  public function index()
  {
    abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    $data['permissions'] = Permission::latest()->get();
    return view('admin.permission.index',$data);
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
      'group' => ['required','string'],
      'title'  => ['required','string']
    ]);
    if($validator->fails()){
      $response = [
        'status'    => 400,
        'error'    => $validator->errors()->toArray(),
      ];
      return response()->json($response);
    } else {
      $datas   =   Permission::updateOrCreate([
        'id' => $object_id],
        [
          'group' => $request->group,
          'title' => $request->title,
          'status' => $status
      ]);
      if($object_id){
        $type = 'update-object';
        $success = 'Permission has been Updated!';
      } else {
        $type = 'store-object';
        $success = 'Permission has been registered!';
      }
      $response = [
        'status'    => 200,
        'type'    => $type,
        'data'    => $datas,
        'success' => $success,
        'html'    => view('admin.permission.templates.ajax_tr',[
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
      'data' => Permission::find($id)
    ];
    return response()->json($response);
  }

  public function edit($id){
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response = [
      'data' => Permission::find($id)
    ];
    return response()->json($response);
  }

  public function destroy($id)
  {
    abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    Permission::find($id)->delete();
    return response()->json(['success'=>'Permission has been deleted successfully!']);
  }

  public function changeStatus(Request $request)
  {
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response = Permission::find($request->object_id);
    $response->status = $request->status;
    $response->save();
    return response()->json(['success'=>'Status has been change successfully!']);
  }
}
