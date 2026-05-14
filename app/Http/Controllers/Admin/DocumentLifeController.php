<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentLife;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DocumentLifeController extends Controller
{
    protected $prefix = 'document_life_';

    protected $crudRoutePath = 'document_lives';

    public function index()
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['documents'] = Document::all();
        $data['documentlives'] = DocumentLife::latest()->get();

        return view('admin.document_life.index', $data);
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
            'type_id' => 'required',
            'type_name' => 'required',
            'type_desr' => 'required',
            'num' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            $datas = DocumentLife::updateOrCreate([
                'id' => $object_id],
                [
                    'document_id' => $request->document_id,
                    'coltype' => $request->type_id,
                    'colfield' => $request->type_name,
                    'coldesr' => $request->type_desr,
                    'num' => $request->num,
                    'status' => $status,
                ]);
            if ($object_id) {
                $type = 'update-object';
                $success = 'DocumentLife has been Updated!';
            } else {
                $type = 'store-object';
                $success = 'DocumentLife has been registered!';
            }
            $response = [
                'status' => 200,
                'type' => $type,
                'data' => $datas,
                'success' => $success,
                'html' => view('admin.document_life.templates.ajax_tr', [
                    'row' => $datas,
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath])
                    ->render(),
            ];
        }

        return response()->json($response);
    }

    public function show(DocumentLife $documentLife)
    {
        return response()->json($documentLife);
    }

    public function edit(DocumentLife $documentLife)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = ['data' => $documentLife];

        return response()->json($response);
    }

    public function destroy(DocumentLife $documentLife)
    {
        abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $documentLife->delete();

        return response()->json(['success' => 'Item has been deleted successfully!']);
    }

    public function changeStatus(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = DocumentLife::find($request->object_id);
        $response->status = $request->status;
        $response->save();

        return response()->json(['success' => 'Status has been change successfully!']);
    }
}
