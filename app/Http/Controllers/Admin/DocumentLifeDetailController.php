<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentLife;
use App\Models\DocumentLifeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DocumentLifeDetailController extends Controller
{
    protected $prefix = 'document_life_detail_';

    protected $crudRoutePath = 'document_life_details';

    public function index()
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['document_lives'] = DocumentLife::all();
        $data['documentlive_details'] = DocumentLifeDetail::latest()->get();

        return view('admin.document_life_detail.index', $data);
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
            'document_lives_id' => 'required',
            'colfield' => 'required',
            'coldesr' => 'required',
            'coldate' => 'required',
        ]);

        if (! $validator->passes()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            $datas = DocumentLifeDetail::updateOrCreate([
                'id' => $object_id],
                [
                    'document_lives_id' => $request->document_lives_id,
                    'colfield' => $request->colfield,
                    'coldesr' => $request->coldesr,
                    'coldate' => $request->coldate,
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
                'html' => view('admin.document_life_detail.templates.ajax_tr', [
                    'row' => $datas,
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath])
                    ->render(),
            ];
        }

        return response()->json($response);
    }

    public function show(DocumentLifeDetail $documentLifeDetail)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = ['data' => $documentLifeDetail];

        return response()->json($response);
    }

    public function edit(DocumentLifeDetail $documentLifeDetail)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = ['data' => $documentLifeDetail];

        return response()->json($response);
    }

    public function destroy(DocumentLifeDetail $documentLifeDetail)
    {
        abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $documentLifeDetail->delete();

        return response()->json(['success' => 'Item has been deleted successfully!']);
    }

    public function changeStatus(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = DocumentLifeDetail::find($request->object_id);
        $response->status = $request->status;
        $response->save();

        return response()->json(['success' => 'Status has been change successfully!']);
    }
}
