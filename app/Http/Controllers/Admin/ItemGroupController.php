<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ItemGroupController extends Controller
{
    protected $prefix = 'item_group_';

    protected $crudRoutePath = 'item_groups';

    public function index()
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['item_groups'] = ItemGroup::latest()->get();

        return view('admin.item_group.index', $data);
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
            'name' => ['required', 'string'],
        ]);
        if (! $validator->passes()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            $datas = ItemGroup::updateOrCreate([
                'id' => $object_id],
                [
                    'name' => $request->name,
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
                'html' => view('admin.item_group.templates.ajax_tr', [
                    'row' => $datas,
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath])
                    ->render(),
            ];
        }

        return response()->json($response);
    }

    public function show(ItemGroup $item_group)
    {
        abort_if(Gate::denies($this->prefix.'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = [
            'data' => $item_group,
        ];

        return response()->json($response);
    }

    public function edit(ItemGroup $item_group)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = [
            'data' => $item_group,
        ];

        return response()->json($response);
    }

    public function destroy(ItemGroup $item_group)
    {
        abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item_group->delete();

        return response()->json(['success' => 'Item has been deleted successfully!']);
    }

    public function changeStatus(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = ItemGroup::find($request->object_id);
        $response->status = $request->status;
        $response->save();

        return response()->json(['success' => 'Status has been change successfully!']);
    }
}
