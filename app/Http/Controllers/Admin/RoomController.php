<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
    protected $prefix = 'room_';

    protected $crudRoutePath = 'rooms';

    public function index()
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['rooms'] = Room::latest()->get();

        return view('admin.room.index', $data);
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
        $validator = Validator::make($request->all(), StoreRoomRequest::rulesFor());
        if (! $validator->passes()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            $datas = Room::updateOrCreate([
                'id' => $object_id],
                [
                    'room_no' => $request->room_no,
                    'status' => $status,
                ]);
            if ($object_id) {
                $type = 'update-object';
                $success = 'Room has been Updated!';
            } else {
                $type = 'store-object';
                $success = 'Room has been registered!';
            }
            $response = [
                'status' => true,
                'type' => $type,
                'data' => $datas,
                'success' => $success,
                'html' => view('admin.room.templates.ajax_tr', [
                    'row' => $datas,
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath])
                    ->render(),
            ];
        }

        return response()->json($response);
    }

    public function show(Room $room)
    {
        abort_if(Gate::denies($this->prefix.'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = [
            'data' => $room,
        ];

        return response()->json($response);
    }

    public function edit(Room $room)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = [
            'data' => $room,
        ];

        return response()->json($response);
    }

    public function destroy(Room $room)
    {
        abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $room->delete();

        return response()->json(['success' => 'Room has been deleted successfully!']);
    }

    public function changeStatus(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = Room::find($request->object_id);
        $response->status = $request->status;
        $response->save();

        return response()->json(['success' => 'Status has been change successfully!']);
    }
}
