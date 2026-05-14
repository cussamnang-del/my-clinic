<?php

namespace App\Http\Controllers\Admin;

use App\Models\ItemType;
use App\Models\ItemGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ItemTypeController extends Controller
{
  protected $prefix = 'item_type_';

  protected $crudRoutePath = 'item_types';

  public function index()
  {
    abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $data = [
      'itemGroups' => ItemGroup::all(),
    ];
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    $data['item_types'] = ItemType::latest()->get();
    return view('admin.item_type.index',$data);
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
      'item_group_id'  => ['required','string'],
      'name'   => ['required','string'],
    ]);
    if(!$validator->passes()){
      $response = [
        'status'    => 400,
        'error'    => $validator->errors()->toArray(),
      ];
      return response()->json($response);
    } else {
      $datas   =   ItemType::updateOrCreate([
        'id' => $object_id],
        [
          'item_group_id' => $request->item_group_id,
          'name' => $request->name,
          'status' => $status
        ]);
      if($object_id){
        $type = 'update-object';
        $success = 'ItemType has been Updated!';
      } else {
        $type = 'store-object';
        $success = 'ItemType has been registered!';
      }
      $response = [
        'status'    => true,
        'type'    => $type,
        'data'    => $datas,
        'success' => $success,
        'html'    => view('admin.item_type.templates.ajax_tr',[
          'row'=> $datas,
          'prefix'=>$this->prefix,
          'crudRoutePath'=> $this->crudRoutePath])
          ->render(),
      ];
    }
    return response()->json($response);
  }

  public function show(ItemType $item_type)
  {
    abort_if(Gate::denies($this->prefix.'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response= [
      'data'  => $item_type
    ];
    return response()->json($response);
  }

  public function edit(ItemType $item_type)
  {
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response= [
      'data'  => $item_type
    ];
    return response()->json($response);
  }

  public function destroy(ItemType $item_type)
  {
    abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $item->delete();
    return response()->json(['success'=>'ItemType has been deleted successfully!']);
  }

  public function changeStatus(Request $request)
  {
    abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response = ItemType::find($request->object_id);
    $response->status = $request->status;
    $response->save();
    return response()->json(['success'=>'Status has been change successfully!']);
  }
}
