<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalCertificate;
use App\Models\OperativeProtocol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class OperativeController extends Controller
{
    protected $prefix = 'document_';

    protected $crudRoutePath = 'documents';

    public function storeProtocol(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (! $request->ajax()) {
            return response()->json(['status' => 400, 'error' => 'Bad Request'], 400);
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'time' => 'required',
            'protocol_document_id' => 'required|integer',
            'protocol_customer_id' => 'required|integer',
            'operater' => 'nullable|string|max:255',
            'aide' => 'nullable|string|max:255',
            'anesth' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        }

        $datas = $validator->validated() + $request->only([
            'diapre', 'diaper', 'indication', 'position', 'note', 'protocol_object_id',
        ]);
        $attributes = [
            'date' => date('Y-m-d', \strtotime($datas['date'])),
            'time' => $datas['time'],
            'document_id' => $datas['protocol_document_id'],
            'customer_id' => $datas['protocol_customer_id'],
            'operater' => $datas['operater'],
            'aide' => $datas['aide'],
            'anesth' => $datas['anesth'],
            'diapre' => $datas['diapre'],
            'diaper' => $datas['diaper'],
            'indication' => $datas['indication'],
            'position' => $datas['position'],
            'note' => $datas['note'],
            'user_id' => auth()->id(),
            'status' => true,
        ];
        if ($datas['protocol_object_id']) {
            $data = OperativeProtocol::findOrFail($datas['protocol_object_id']);
            $data->update($attributes);
            $type = 'update-object';
            $success = 'Operative has been Updated!';
        } else {
            $data = OperativeProtocol::create($attributes);
            $type = 'store-object';
            $success = 'Operative has been Saved!';
        }
        $response = [
            'status' => 200,
            'type' => $type,
            'data' => $data,
            'success' => $success,
        ];

        return response()->json($response);
    }

    public function receiptProtocol(OperativeProtocol $OperativeProtocol)
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['OperativeProtocol'] = $OperativeProtocol;
        $OperativeProtocol->load(['customer', 'document']);

        return view('admin.document.templates.more.protocol_receipt', $data);
    }

    public function storeMedicine(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (! $request->ajax()) {
            return response()->json(['status' => 400, 'error' => 'Bad Request'], 400);
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'time' => 'required',
            'medicine_document_id' => 'required|integer',
            'medicine_customer_id' => 'required|integer',
            'diagnosis' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        }

        $is_sick = (bool) $request->sick_leave;
        $is_other = (bool) $request->is_other;
        $datas = $validator->validated() + $request->only([
            'chief_complain', 'past_history', 'treatment_plan', 'physical_examination',
            'from_date', 'to_date', 'attending_physician', 'medicine_note', 'medicine_object_id',
        ]);
        $attributes = [
            'date' => date('Y-m-d', \strtotime($datas['date'])),
            'time' => $datas['time'],
            'document_id' => $datas['medicine_document_id'],
            'customer_id' => $datas['medicine_customer_id'],
            'chief_complain' => $datas['chief_complain'],
            'past_history' => $datas['past_history'],
            'diagnosis' => $datas['diagnosis'],
            'treatment' => $datas['treatment_plan'],
            'examination' => $datas['physical_examination'],
            'is_sick' => $is_sick,
            'from_date' => date('Y-m-d', \strtotime($datas['from_date'])),
            'to_date' => date('Y-m-d', \strtotime($datas['to_date'])),
            'attending' => $datas['attending_physician'],
            'is_other' => $is_other,
            'note' => $datas['medicine_note'],
            'user_id' => auth()->id(),
            'status' => true,
        ];
        if ($datas['medicine_object_id']) {
            $data = MedicalCertificate::findOrFail($datas['medicine_object_id']);
            $data->update($attributes);
            $type = 'update-object';
            $success = 'Medicine has been Updated!';
        } else {
            $data = MedicalCertificate::create($attributes);
            $type = 'store-object';
            $success = 'Medicine has been Saved!';
        }
        $response = [
            'status' => 200,
            'type' => $type,
            'data' => $data,
            'success' => $success,
        ];

        return response()->json($response);
    }

    public function receiptMedicine(MedicalCertificate $MedicalCertificate)
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['MedicalCertificate'] = $MedicalCertificate;
        $MedicalCertificate->load(['customer', 'document']);

        return view('admin.document.templates.more.medicine_certificate_receipt', $data);
    }
}
