<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemGroup;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller
{
    protected $prefix = 'item_';

    protected $crudRoutePath = 'items';

    public function index()
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = [
            'itemGroups' => ItemGroup::all(),
            'itemTypes' => ItemType::all(),
        ];
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['items'] = Item::latest()->get();

        return view('admin.item.index', $data);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->status) {
            $status = true;
        } else {
            $status = false;
        }
        $object_id = $request->object_id;
        $validator = Validator::make($request->all(), [
            'item_group_id' => ['required', 'string'],
            'item_type_id' => ['required', 'string'],
            'item_name' => ['required', 'string'],
            'normal_value' => ['required', 'string'],
            'min_value' => ['required', 'string'],
            'max_value' => ['required', 'string'],
            'numset' => ['required', 'numeric'],
            'item_price' => ['required', 'numeric'],
        ]);
        if (! $validator->passes()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            $datas = Item::updateOrCreate([
                'id' => $object_id],
                [
                    'item_group_id' => $request->item_group_id,
                    'item_type_id' => $request->item_type_id,
                    'item_name' => $request->item_name,
                    'normal_value' => $request->normal_value,
                    'min_value' => $request->min_value,
                    'max_value' => $request->max_value,
                    'numset' => $request->numset,
                    'uvn' => $request->uvn,
                    'item_price' => $request->item_price,
                    'status' => $status,
                ]);
            if ($object_id) {
                $type = 'update-object';
                $success = 'Item has been Updated!';
            } else {
                $type = 'store-object';
                $success = 'Item has been registered!';
            }
            $response = [
                'status' => true,
                'type' => $type,
                'data' => $datas,
                'success' => $success,
                'html' => view('admin.item.templates.ajax_tr', [
                    'row' => $datas,
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath])
                    ->render(),
            ];
        }

        return response()->json($response);
    }

    public function show(Item $item)
    {
        abort_if(Gate::denies($this->prefix.'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = [
            'data' => $item,
        ];

        return response()->json($response);
    }

    public function edit(Item $item)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = [
            'data' => $item,
        ];

        return response()->json($response);
    }

    public function destroy(Item $item)
    {
        abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item->delete();

        return response()->json(['success' => 'Item has been deleted successfully!']);
    }

    public function changeStatus(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = Item::find($request->object_id);
        $response->status = $request->status;
        $response->save();

        return response()->json(['success' => 'Status has been change successfully!']);
    }
}
