<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalCertificate;
use App\Models\OperativeProtocol;
use Illuminate\Http\Request;

class OperativeController extends Controller
{
    protected $prefix = 'document_';

    protected $crudRoutePath = 'documents';

    public function storeProtocol(Request $request)
    {
        if (! $request->ajax()) {
            return response()->json(['status' => 400, 'error' => 'Bad Request'], 400);
        }
        $datas = $request->all();
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
        $data['OperativeProtocol'] = $OperativeProtocol;
        $OperativeProtocol->load(['customer', 'document']);

        return view('admin.document.templates.more.protocol_receipt', $data);
    }

    public function storeMedicine(Request $request)
    {
        if (! $request->ajax()) {
            return response()->json(['status' => 400, 'error' => 'Bad Request'], 400);
        }
        if ($request->sick_leave) {
            $is_sick = true;
        } else {
            $is_sick = false;
        }
        if ($request->is_other) {
            $is_other = true;
        } else {
            $is_other = false;
        }
        $datas = $request->all();
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
        $data['MedicalCertificate'] = $MedicalCertificate;
        $MedicalCertificate->load(['customer', 'document']);

        return view('admin.document.templates.more.medicine_certificate_receipt', $data);
    }
}
