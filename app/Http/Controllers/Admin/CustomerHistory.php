<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bio;
use App\Models\CompanyInformation;
use App\Models\Customer;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\HNote;
use App\Models\Hospital;
use App\Models\HospitalTreatment;
use App\Models\Order;
use App\Models\Rx;
use App\Models\RxDetail;
use App\Models\RxDocfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CustomerHistory extends Controller
{
    protected $prefix = 'customer_';

    protected $crudRoutePath = 'histories';

    public function showHistory()
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['customers'] = Customer::latest()->get();

        return view('admin.customer.history', $data);
    }

    public function detail(Customer $customer)
    {
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['bios'] = Bio::where('customer_id', $customer->id)->get();
        $data['rx_details'] = Rx::where('customer_id', $customer->id)->get();
        $data['hospitals'] = Hospital::where('customer_id', $customer->id)->get();
        $hids = Hospital::where('customer_id', $customer->id)->get()->map(function ($hospital) {
            return $hospital->id;
        });
        $data['hospital_treatments'] = HospitalTreatment::whereIn('hospital_id', $hids)->latest()->get();
        $data['orders'] = Order::where('customer_id', $customer->id)->get();
        $data['hnotes'] = HNote::orderBy('date', 'DESC')->get();

        return view('admin.customer.analisis_by_customer', $data);
    }

    public function customerDetail(Request $request)
    {
        $customer = Customer::findOrFail($request->customer_id);
        $customer->load('village', 'commune', 'district', 'province', 'documents');
        $address = optional($customer->village)->name_en.' Village, '
                    .optional($customer->commune)->name_en.' Commune, '
                    .optional($customer->district)->name_en.' District, '
                    .optional($customer->province)->name_en.' Province';
        $response = [
            'customer_details' => view('admin.customer.templates.document_detail_by_customer', [
                'customer' => $customer,
                'address' => $address,
                'prefix' => $this->prefix,
                'crudRoutePath' => $this->crudRoutePath,
            ])->render(),
        ];

        return response()->json($response);
    }

    public function documentDetail($customer, $document)
    {
        $hospital = get_hospital_id($customer, $document);
        $data['bios'] = Bio::where('customer_id', $customer)
            ->where('document_id', $document)->get();
        $data['hospital_treatments'] = HospitalTreatment::where('hospital_id', '=', $hospital)
            ->latest()
            ->get();
        $data['hospitals'] = Hospital::where('id', $hospital)->get();
        $data['rx_details'] = Rx::where('customer_id', $customer)
            ->where('document_id', $document)
            ->complete()->latest()->get();
        $data['orders'] = Order::where('customer_id', $customer)
            ->where('document_id', $document)
            ->latest()->get();
        $data['documents'] = Document::where('customer_id', $customer)->get();
        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['hnotes'] = HNote::orderBy('date', 'DESC')->get();

        return view('admin.customer.history_detail', $data);
    }

    public function previewReceipt(Order $order)
    {
        $data['order'] = $order;
        $data['setting'] = CompanyInformation::findOrFail(1);

        return view('admin.document.templates.order.receipt', $data);
    }

    public function showtRxDetail(Request $request)
    {
        $response = [
            'history_rx_detail' => view('admin.customer.templates.history_rx_detail', [
                'rx_details' => RxDetail::where('rx_id', $request->rx_id)
                    ->get(),
                'rx_files' => RxDocfile::where('rx_id', $request->rx_id)->get(),
            ])->render(),
            'customer' => Customer::findOrFail($request->customer_id),
        ];

        return response()->json($response);
    }

    public function serviceDetail($customer)
    {
        $data['documents'] = Document::where('customer_id', $customer)->get();

        return view('admin.customer.customer_service_detail', $data);
    }

    public function changeStatus(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = DocumentDetail::find($request->object_id);
        $response->status = $request->status;
        $response->save();

        return response()->json(['success' => 'Status has been change successfully!']);
    }

    public function order()
    {
        $data['orders'] = Order::latest()->get();

        return view('admin.customer.order',$data);
    }
}
