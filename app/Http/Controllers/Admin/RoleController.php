<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
  public $prefix = 'role_';

  public $crudRoutePath = 'roles';

  public function index()
  {
    abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    $data['roles'] = Role::with('permissions')->latest()->get();
    $data['all_permissions'] = Permission::all()->groupBy('group')->toArray();
    return view('admin.role.index',$data);
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
      'title' => ['required','string'],
      'permissions.*' => ['integer'],
      'permissions' => [
        'required',
        'array',
      ],
    ]);
    if(!$validator->passes()){
      $response = [
        'status' => 400,
        'error'  => $validator->errors()->toArray()
      ];
      return response()->json($response);
    } else {
      $datas   =   Role::updateOrCreate([
        'id' => $object_id],
        [
          'title' => $request->title,
          'status' => $status
        ]);
      $datas->permissions()->sync($request->permissions);
      if($object_id){
        $type = 'update-object';
        $success = 'Role has been Updated!';
      } else {
        $type = 'store-object';
        $success = 'Role has been registered!';
      }
      $response = [
        'status'  => 200,
        'type'    => $type,
        'success' => $success,
        'data'    => $datas,
        'html'    => view('admin.role.templates.ajax_tr',[
          'row'=> $datas,
          'prefix'=>$this->prefix,
          'crudRoutePath'=> $this->crudRoutePath])
          ->render(),
      ];
    }
    return response()->json($response);
  }

  public function show(Role $role)
  {
    //
  }

  public function edit(Role $role)
  {
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response= [
      'data'    => $role,
      'role_permissions' => $role->permissions->pluck('id','id')->toArray(),
    ];
    return response()->json($response);
  }

  public function destroy(Role $role)
  {
    abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $role->delete();
    return response()->json(['success'=>'Item has been deleted successfully!']);
  }

  public function changeStatus(Request $request)
  {
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response = Role::find($request->object_id);
    $response->status = $request->status;
    $response->save();
    return response()->json(['success'=>'Status has been change successfully!']);
  }
}
