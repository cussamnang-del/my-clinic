<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bio;
use App\Models\BioDetail;
use App\Models\CompanyInformation;
use App\Models\Customer;
use App\Models\DoctorDescription;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\DocumentLife;
use App\Models\DocumentLifeDetail;
use App\Models\HNote;
use App\Models\Hospital;
use App\Models\HospitalTreatment;
use App\Models\HospitalTreatmentDetail;
use App\Models\HowToUse;
use App\Models\Item;
use App\Models\ItemGroup;
use App\Models\ItemType;
use App\Models\LifeSign;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pbio;
use App\Models\PbioDetail;
use App\Models\Product;
use App\Models\Province;
use App\Models\Room;
use App\Models\Rx;
use App\Models\RxDetail;
use App\Models\RxDocfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    protected $prefix = 'document_';

    protected $crudRoutePath = 'documents';

    public function index(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['provinces'] = Province::all();
        $data['types'] = LifeSign::where('type_id', '=', 0)->pluck('name', 'id');
        $data['rooms'] = Room::pluck('room_no', 'id');
        // $data['products'] = Product::orderBy('p_name')->get();
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        if ($request->from_date != '' && $request->to_date != '') {
            $data['documents'] = Document::hospital(0)
                ->whereDate('visit_date', '>=', $request->from_date)
                ->whereDate('visit_date', '<=', $request->to_date)
                ->latest()->get();
            $data['document_hospitals'] = Document::hospital(1)
                ->latest()->get();
            $data['from_date'] = $request->from_date;
            $data['to_date'] = $request->to_date;
        } else {
            $data['documents'] = Document::hospital(0)
                ->whereDate('visit_date', '>=', date('Y-m-d'))
                ->whereDate('visit_date', '<=', date('Y-m-d'))
                ->latest()->get();
            $data['document_hospitals'] = Document::hospital(1)
                ->latest()->get();
            $data['from_date'] = date('Y-m-d');
            $data['to_date'] = date('Y-m-d');
        }

        return view('admin.document.index', $data);
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
            'customer_id' => 'required',
            'visit_date' => 'required|date|max:50',
        ]);

        if (! $validator->passes()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];
        } else {
            $datas = Document::updateOrCreate([
                'id' => $object_id],
                [
                    'customer_id' => $request->customer_id,
                    'user_id' => Auth::id(),
                    'visit_date' => date('Y-m-d H:i:s', strtotime($request->visit_date)),
                    'status' => $status,
                ]);
            if ($object_id) {
                $type = 'update-object';
                $success = 'Document has been Updated!';
            } else {
                $type = 'store-object';
                $success = 'Document has been registered!';
            }
            $response = [
                'status' => 200,
                'type' => $type,
                'data' => $datas,
                'success' => $success,
                'html' => view('admin.document.templates.ajax_tr', [
                    'row' => $datas,
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath])
                    ->render(),
            ];
        }

        return response()->json($response);
    }

    public function show(Document $document)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = ['data' => $document];

        return response()->json($response);
    }

    public function edit(Document $document)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = ['data' => $document];

        return response()->json($response);
    }

    public function destroy(Document $document)
    {
        abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $document->delete();

        return response()->json(['success' => 'Item has been deleted successfully!']);
    }

    public function changeStatus(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = Document::find($request->object_id);
        $response->status = $request->status;
        $response->save();

        return response()->json(['success' => 'Status has been change successfully!']);
    }

    public function getCustomer(Request $request)
    {
        $response = ['data' => Customer::FindOrFail($request->object_id)
            ->load(['province', 'district', 'commune', 'village'])];

        return response()->json($response);
    }

    public function gotoService(Document $document, Customer $customer)
    {
        $data['document'] = $document;
        $data['customer'] = $customer;
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['types'] = LifeSign::where('type_id', '=', 0)->pluck('name', 'id');
        $data['rooms'] = Room::pluck('room_no', 'id');
        $data['products'] = Product::orderBy('p_name')->get();
        $data['how_to_uses'] = HowToUse::orderBy('name')->get();
        $data['data'] = Document::FindOrFail($document->id)
            ->load(['customer', 'province', 'district', 'commune', 'village']);
        $data['typeA'] = DocumentLife::where('customer_id', '=', $customer->id)
            ->where('coltype', '=', 1)
            ->groupBy('colfield')
            ->get();
        $data['typeB'] = DocumentLife::where('customer_id', '=', $customer->id)
            ->where('coltype', '=', 2)
            ->groupBy('colfield')
            ->get();
        $hids = Hospital::where('customer_id', $customer->id)->get()->map(function ($hospital) {
            return $hospital->id;
        });
        $data['bios'] = Bio::where('customer_id', $customer->id)->get();
        $data['rx_details'] = Rx::where('customer_id', $customer->id)->get();
        $data['hospitals'] = Hospital::where('customer_id', $customer->id)->get();
        $data['hts'] = HospitalTreatment::whereIn('hospital_id', $hids)->get();
        $data['hnotes'] = HNote::orderBy('date', 'DESC')->get();
        $data['orders'] = Order::where('customer_id', $customer->id)->get();

        return view('admin.document.templates.customer_service', $data);
    }

    public function filterTreatment(Request $request)
    {
        if ($request->ajax()) {
            if ($request->from_date != '' && $request->to_date != '') {
                $data['hts'] = HospitalTreatment::whereBetween('ht_date', [$request->from_date, $request->to_date])
                    ->get();
                $data['hnotes'] = HNote::whereBetween('date', [$request->from_date, $request->to_date])
                    ->get();
            } else {
                $data['hts'] = HospitalTreatment::orderBy('ht_date', 'desc')->get();
                $data['hnotes'] = HNote::orderBy('date', 'desc')->get();
            }
            $response = [
                'hts' => view('admin.document.templates.h.ht_list', [
                    'hts' => $data['hts'],
                    'hnotes' => $data['hnotes'],
                    'prefix' => $this->prefix,
                ])->render(),
            ];

            return response()->json($response);
        }
    }

    public function getLifeSign(Request $request)
    {
        $response = LifeSign::where('type_id', '=', $request->type_id)->get();

        return response()->json($response);
    }

    public function storeDocumentLife(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->status) {
            $status = true;
        } else {
            $status = false;
        }
        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'type_name' => 'required|array|min:1',
            'type_date' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            date_default_timezone_set('Asia/Bangkok');
            $mytime = date('h:i:s');
            foreach ($request->type_name as $key => $colfield) {
                if ($request->type_desr[$key] != null) {
                    // document life
                    $docLife = DocumentLife::where('customer_id', '=', $request->exist_customer_id)
                        ->where('coltype', '=', $request->type_id)
                        ->where('colfield', '=', $request->type_name[$key])->first();
                    if ($docLife) {
                        if ($docLife->customer_id == $request->exist_customer_id && $docLife->coltype == $request->type_id && $docLife->colfield == $request->type_name[$key]) {
                            $docLife->document_id = $request->document_id;
                            $docLife->coltype = $request->type_id;
                            $docLife->colfield = $colfield;
                            $docLife->coldesr = $request->type_desr[$key];
                            $docLife->col_measure = $request->type_measure[$key];
                            $docLife->coltime = $mytime;
                            $docLife->status = $status;
                            $docLife->save();
                        }
                    } else {
                        $docLife = DocumentLife::Create([
                            'document_id' => $request->document_id,
                            'customer_id' => $request->exist_customer_id,
                            'coltype' => $request->type_id,
                            'colfield' => $colfield,
                            'coldesr' => $request->type_desr[$key],
                            'col_measure' => $request->type_measure[$key],
                            'coltime' => $mytime,
                            'status' => $status,
                        ]);
                    }
                    // document life detail
                    DocumentLifeDetail::create([
                        'document_lives_id' => $docLife->id,
                        'colfield' => $colfield,
                        'coldesr' => $request->type_desr[$key],
                        'col_measure' => $request->type_measure[$key],
                        'coldate' => date('Y-m-d', strtotime($request->type_date)),
                        'coltime' => $mytime,
                        'status' => $status,
                    ]);
                } else {
                    $response = [
                        'status' => 500,
                        'error' => 'Please fill out the description',
                    ];

                    return response()->json($response);
                }
            }

        }
        $response = [
            'status' => 200,
            'data' => $docLife,
            'success' => 'Document Life has been inserted Successfully!',
            'typeA' => view('admin.document.templates.doclife_typeA', [
                'typeA' => DocumentLife::where('customer_id', '=', $request->exist_customer_id)
                    ->where('coltype', '=', 1)
                    ->groupBy('colfield')
                    ->get()])
                ->render(),
            'typeB' => view('admin.document.templates.doclife_typeB', [
                'typeB' => DocumentLife::where('customer_id', '=', $request->exist_customer_id)
                    ->where('coltype', '=', 2)
                    ->groupBy('colfield')
                    ->get()])
                ->render(),
        ];

        return response()->json($response);
    }

    public function editDocumentLife(Request $request)
    {
        if (! $request->ajax()) {
            return response()->json(['status' => 400, 'error' => 'Bad Request'], 400);
        }

        if ($request->lifeid) {
            $response = [
                'docLife' => DocumentLife::findOrFail($request->lifeid),
                'liveDetail' => DocumentLifeDetail::findOrFail($request->id),
                'lifetype' => $request->lifetype,
            ];
        } else {
            $response = [
                'docLife' => DocumentLife::findOrFail($request->id),
                'lifetype' => $request->lifetype,
            ];
        }

        return response()->json($response);
    }

    public function updateDocumentLife(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_desr' => 'required',
            'type_date' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            if (! $request->ajax()) {
                return response()->json(['status' => 400, 'error' => 'Bad Request'], 400);
            }
            // document life detail
            date_default_timezone_set('Asia/Bangkok');
            $mytime = date('h:i:s');
            if ($request->doclife_detail_id) {
                $docLifeDetail = DocumentLifeDetail::findOrFail($request->doclife_detail_id);
                // document life
                if ($docLifeDetail->coldate == date('Y-m-d')) {
                    $docLife = DocumentLife::findOrFail($request->doclife_id);
                    $docLife->update([
                        'coldesr' => $request->type_desr,
                        'col_measure' => $request->type_measure,
                        'coltime' => $mytime,
                    ]);
                }
                $docLifeDetail->update([
                    'coldesr' => $request->type_desr,
                    'col_measure' => $request->type_measure,
                    'coltime' => $mytime,
                ]);
            } else {
                $docLife = DocumentLife::findOrFail($request->doclife_id);
                $docLife->update([
                    'coldesr' => $request->type_desr,
                    'col_measure' => $request->type_measure,
                    'coltime' => $mytime,
                ]);
                DocumentLifeDetail::create([
                    'document_lives_id' => $request->doclife_id,
                    'colfield' => $request->colfield,
                    'coldesr' => $request->type_desr,
                    'col_measure' => $request->type_measure,
                    'coldate' => date('Y-m-d', strtotime($request->type_date)),
                    'coltime' => $mytime,
                    'status' => true,
                ]);
            }
            $response = [
                'status' => 200,
                'success' => 'Document Life has been inserted Successfully!',
                'typeA' => view('admin.document.templates.doclife_typeA', [
                    'typeA' => DocumentLife::where('customer_id', '=', $request->exist_customer_id)
                        ->where('coltype', '=', 1)
                        ->groupBy('colfield')
                        ->get()])
                    ->render(),
                'typeB' => view('admin.document.templates.doclife_typeB', [
                    'typeB' => DocumentLife::where('customer_id', '=', $request->exist_customer_id)
                        ->where('coltype', '=', 2)
                        ->groupBy('colfield')
                        ->get()])
                    ->render(),
            ];
        }

        return response()->json($response);
    }

    public function getPBio(Request $request)
    {
        $response = [
            'items' => view('admin.document.templates.bio.pbio_detail_list', [
                'itemGroups' => ItemGroup::all(),
            ])->render(),
            'pbio_infos' => view('admin.document.templates.bio.pbio_info', [
                'pbio_infos' => Pbio::active()->where('customer_id', $request->customer_id)->get(),
                'prefix' => $this->prefix,
                'crudRoutePath' => $this->crudRoutePath,
            ])->render(),
        ];

        return response()->json($response);
    }

    public function getGroupType(Request $request)
    {
        $response = [
            'items' => view('admin.document.templates.bio.item_type_list', [
                'itemTypes' => ItemType::where('item_group_id', $request->item_group_id)->get(),
            ])->render(),
        ];

        return response()->json($response);
    }

    public function getItemTypeByName(Request $request)
    {
        $response = [
            'items' => view('admin.document.templates.bio.item_list', [
                'itemLists' => Item::where('item_type_id', $request->item_type_id)->get(),
            ])->render(),
        ];

        return response()->json($response);
    }

    public function storePBio(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validator = Validator::make($request->all(), [
            'bio_item_name.*' => ['integer'],
            'bio_item_name' => [
                'required',
                'array',
            ],
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            $pbio = Pbio::create([
                'customer_id' => $request->customer_id,
                'document_id' => $request->document_id,
                'status' => 1,
            ]);
            $itemids = $request->bio_item_name;
            foreach ($itemids as $item_id) {
                PbioDetail::create([
                    'pbio_id' => $pbio->id,
                    'item_id' => $item_id,
                    'item_group_id' => $request->item_group_id,
                    'item_type_id' => $request->item_type_id,
                    'status' => 1,
                ]);
            }
            $response = [
                'status' => 200,
                'success' => 'Pio has been insert!',
                'html' => view('admin.document.templates.bio.pbio_ajax_tr', [
                    'prefix' => $this->prefix,
                    'row' => $pbio])
                    ->render(),
            ];
        }

        return response()->json($response);
    }

    public function deletePBio(Request $request)
    {
        $pbio = Pbio::findOrFail($request->pbio_id);
        if ($pbio->delete()) {
            $pbio_details = PbioDetail::where('pbio_id', $request->pbio_id)->get();
            foreach ($pbio_details as $detail) {
                $detail->delete();
            }
            $response = [
                'success' => 'Pbio has been deleted successfull!',
            ];

            return response()->json($response);
        }
    }

    public function getBio(Request $request)
    {
        $response = [
            'bio_detail' => view('admin.document.templates.bio.bio_detail', [
                'bios' => Bio::where('customer_id', $request->customer_id)->get(),
            ])->render(),
            'pbio_details' => view('admin.document.templates.bio.pbio_detail', [
                'pbio_details' => Pbio::active()->where('customer_id', $request->customer_id)->get(),
                'prefix' => $this->prefix,
                'crudRoutePath' => $this->crudRoutePath,
            ])->render(),
        ];

        return response()->json($response);
    }

    public function getBioAnalystForm(Request $request)
    {
        $response = [
            'pbio_analyst_form' => view('admin.document.templates.bio.pbio_analyst_form', [
                'pbio_id' => $request->pbio_id,
                'pbio_analyst_forms' => PbioDetail::where('pbio_id', $request->pbio_id)->get(),
            ])->render(),
        ];

        return response()->json($response);
    }

    public function storeBio(Request $request)
    {
        // return response($request);
        abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validator = Validator::make($request->all(), [
            'bio_item_id.*' => ['integer'],
            'bio_item_id' => [
                'required',
                'array',
            ],
            'bio_result' => 'required|array',
            'bio_result.*' => 'required|string',
            // 'bio_result'=>'required',
            'bio_date' => 'required|date|max:50',
        ]);
        $itemids = $request->bio_item_id;
        if (! $validator->passes()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            foreach ($itemids as $key => $item_id) {
                $bio = checkExistBio($request->customer_id, $item_id);
                if ($bio) {
                    BioDetail::create([
                        'bio_id' => $bio->id,
                        'item_group_id' => $request->item_group_id[$key] ?? null,
                        'item_type_id' => $request->item_type_id[$key] ?? null,
                        'customer_id' => $request->customer_id,
                        'document_id' => $request->document_id,
                        'bio_date' => date('Y-m-d', strtotime($request->bio_date)),
                        'bio_result' => $request->bio_result[$key] ?? null,
                        'bio_note' => $request->bio_note[$key] ?? null,
                    ]);
                } else {
                    $newbio = Bio::create([
                        'customer_id' => $request->customer_id,
                        'document_id' => $request->document_id,
                        'user_id' => auth()->id(),
                        'item_id' => $item_id,
                        'status' => 1,
                    ]);
                    BioDetail::create([
                        'bio_id' => $newbio->id,
                        'item_group_id' => $request->item_group_id[$key] ?? null,
                        'item_type_id' => $request->item_type_id[$key] ?? null,
                        'customer_id' => $request->customer_id,
                        'document_id' => $request->document_id,
                        'bio_date' => date('Y-m-d', strtotime($request->bio_date)),
                        'bio_result' => $request->bio_result[$key] ?? null,
                        'bio_note' => $request->bio_note[$key] ?? null,
                    ]);
                }
            }
            $docDetail = checkExistService($request->document_id, 'bio');
            if ($docDetail) {
                $docDetail->update([
                    'service_name' => 'bio',
                    'status' => 1,
                ]);
            } else {
                DocumentDetail::create([
                    'document_id' => $request->document_id,
                    'user_id' => auth()->id(),
                    'service_name' => 'bio',
                    'status' => 1,
                ]);
            }
            $datas = Bio::where('customer_id', $request->customer_id)
                ->get();
            Pbio::findOrFail($request->pbio_id)->update(['status' => 0]);
            $response = [
                'status' => 200,
                'data' => Document::FindOrFail($request->document_id)
                    ->load(['customer', 'province', 'district', 'commune', 'village']),
                'success' => 'New Bio Analyst has been registered!',
                'bio_detail' => view('admin.document.templates.bio.bio_detail', [
                    'bios' => $datas,
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath])
                    ->render(),
                'pbio_details' => view('admin.document.templates.bio.pbio_detail', [
                    'pbio_details' => Pbio::active()->where('customer_id', $request->customer_id)->get(),
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath,
                ])->render(),
            ];
        }

        return response()->json($response);
    }

    public function bioReceipt(Request $request, $document_id, $customer_id)
    {
        $data['customer'] = $customer_id;
        $data['document'] = $document_id;
        $data['setting'] = CompanyInformation::find(1);
        if ($request->history_date) {
            $data['bDetail'] = BioDetail::where('customer_id', $customer_id)->where('document_id', $document_id)
                ->whereDate('bio_date', '=', date('Y-m-d', strtotime($request->history_date)))
                ->get()->unique('item_group_id');
            $data['print_date'] = date('Y-m-d', strtotime($request->history_date));
        } else {
            $data['bDetail'] = BioDetail::where('customer_id', $customer_id)->where('document_id', $document_id)
                ->whereDate('bio_date', '=', date('Y-m-d'))
                ->get()->unique('item_group_id');
            $data['print_date'] = date('Y-m-d');
        }
        if ($data['bDetail']->first()) {
            return view('admin.document.templates.bio.report.bio_analyst_receipt', $data);
        } else {
            return redirect()->back()->with(['success' => 'No Record Found']);
        }
    }

    public function getMore(Request $request)
    {
        $response = [
            'typeA' => view('admin.document.templates.doclife_typeA', [
                'typeA' => DocumentLife::where('customer_id', '=', $request->customer_id)
                    ->where('coltype', '=', 1)
                    ->groupBy('colfield')
                    ->get()])
                ->render(),
            'typeB' => view('admin.document.templates.doclife_typeB', [
                'typeB' => DocumentLife::where('customer_id', '=', $request->customer_id)
                    ->where('coltype', '=', 2)
                    ->groupBy('colfield')
                    ->get()])
                ->render(),
        ];

        return response()->json($response);
    }

    public function storeDoctorOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_order_name' => 'required',
        ]);
        if (! $validator->passes()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            $data = DoctorDescription::create([
                'description_name' => $request->doctor_order_name,
                'description_part' => 'rx',
            ]);
            $response = [
                'status' => 200,
                'data' => $data,
                'success' => 'Doctor order has been insert!',
                'doctor_descriptions' => view('admin.document.templates.rx.doctor_description', [
                    'doctorDescriptions' => DoctorDescription::latest()->get(),
                ])->render(),
            ];
        }

        return response()->json($response);
    }

    public function storeRx(Request $request)
    {
        if ($request->status) {
            $status = true;
        } else {
            $status = false;
        }
        $validator = Validator::make($request->all(), [
            'rx_date' => 'required',
            'doctor_description' => 'required|array',
        ]);
        if (! $validator->passes()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            $notes = implode(',', $request->doctor_description);
            $data = Rx::create([
                'rx_date' => date('Y-m-d', strtotime($request->rx_date)),
                'customer_id' => $request->customer_id,
                'document_id' => $request->document_id,
                'user_id' => auth()->id(),
                'rx_note' => $notes,
                'status' => $status,
            ]);
            $docDetail = checkExistService($request->document_id, 'rx');
            if ($docDetail) {
                $docDetail->update([
                    'service_name' => 'rx',
                    'status' => 1,
                ]);
            } else {
                DocumentDetail::create([
                    'document_id' => $request->document_id,
                    'user_id' => auth()->id(),
                    'service_name' => 'rx',
                    'status' => 1,
                ]);
            }
            $response = [
                'status' => 200,
                'data' => $data,
                'success' => 'Rx has been created Successfully!',
                'rx_nurses' => view('admin.document.templates.rx.showRxNurseModal', [
                    'rx_nurses' => Rx::latest()->get(),
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath,
                ])->render(),
            ];
        }

        return response()->json($response);
    }

    public function getRx(Request $request)
    {
        $response = [
            'nurse_form' => view('admin.document.templates.rx.nurse_form', [
                'nurse' => Rx::with('customer')->where('id', $request->bio_id)
                    ->where('customer_id', $request->customer_id)
                    ->where('document_id', $request->document_id)
                    ->first(),
            ])->render(),
            'rx_nurses' => view('admin.document.templates.rx.nurse_detail', [
                'rx_nurses' => Rx::pending()->latest()->get(),
                'prefix' => $this->prefix,
                'crudRoutePath' => $this->crudRoutePath,
            ])->render(),
        ];

        return response()->json($response);
    }

    public function editRxDetail(Request $request)
    {
        $response = [
            'nurse_form' => view('admin.document.templates.rx.edit_nurse_form', [
                'nurses' => RxDetail::with('rxdata')->where('rx_id', $request->rx_id)
                    ->get(),
                'docfiles' => RxDocfile::where('rx_id', $request->rx_id)->get(),
            ])->render(),
        ];

        return response()->json($response);
    }

    public function deleteFile(Request $request)
    {
        $file = RxDocfile::where('id', $request->id)
            ->where('rx_id', $request->rx_id)
            ->first();
        if ($file->delete()) {
            $filePath = public_path('uploads/rx/docfiles/'.$file->filename);
            if (! empty($file->filename) && is_file($filePath)) {
                @unlink($filePath);
            }
            $response = [
                'status' => 200,
                'success' => 'This file has been deleted!',
                'nurse_form' => view('admin.document.templates.rx.edit_nurse_form', [
                    'nurses' => RxDetail::with('rxdata')->where('rx_id', $request->rx_id)
                                // ->where('customer_id',$request->customer_id)
                                // ->where('document_id',$request->document_id)
                        ->get(),
                    'docfiles' => RxDocfile::where('rx_id', $request->rx_id)->get(),
                ])->render(),
            ];
        } else {
            $response = [
                'status' => 400,
                'success' => 'Error, Can not delete this file!',
            ];
        }

        return response()->json($response);
    }

    public function updateRxNurse(Request $request)
    {
        // return response()->json($request->all());
        $validator = Validator::make($request->all(), [
            'nuse_description' => 'required',
            'nurse_result' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            foreach ($request->rx_detail_id as $key => $id) {
                RxDetail::where('id', $id)->update([
                    'description' => $request->nuse_description[$key],
                    'result' => $request->nurse_result[$key],
                ]);
            }
            if ($request->hasFile('docfile')) {
                $docfiles = $request->file('docfile');
                foreach ($docfiles as $key => $file) {
                    // $mytime = Carbon\Carbon::now()->toDateString();
                    $cusName = Str::slug($request->name);
                    $mytime = date('d-M-Y');
                    $docname = 'Docfile-'.$key.'-'.$cusName.'-'.$mytime.uniqid().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads/rx/docfiles/'), $docname);
                    RxDocfile::create([
                        'rx_id' => $request->rx_id,
                        'filename' => $docname,
                    ]);
                }
            }
            Rx::where('id', $request->rx_id)->update([
                'status' => 1,
            ]);
            $response = [
                'status' => 200,
                'success' => 'Data successfully updated!',
                'rx_nurses' => view('admin.document.templates.rx.nurse_detail', [
                    'rx_nurses' => Rx::pending()->latest()->get(),
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath,
                ])->render(),
            ];
        }

        return response()->json($response);
    }

    public function getRxDetail(Request $request)
    {
        $response = [
            'rx_details' => view('admin.document.templates.rx.rx_detail', [
                'rx_details' => Rx::where('customer_id', $request->rx_customer_id)
                    ->complete()->latest()->get(),
                'prefix' => $this->prefix,
                'crudRoutePath' => $this->crudRoutePath,
            ])->render(),
            'doctor_descriptions' => view('admin.document.templates.rx.doctor_description', [
                'doctorDescriptions' => DoctorDescription::latest()->get(),
            ])->render(),
        ];

        return response()->json($response);
    }

    public function showtRxDetail(Request $request)
    {
        $response = [
            'show_rx_detail' => view('admin.document.templates.rx.show_rx_detail', [
                'rx_details' => RxDetail::where('rx_id', $request->rx_id)
                    ->get(),
                'rx_files' => RxDocfile::where('rx_id', $request->rx_id)->get(),
            ])->render(),
        ];

        return response()->json($response);
    }

    public function pdfPreview($id)
    {
        $pdfPreview = RxDocfile::findOrFail($id);

        return view('admin.document.pdf_preview', compact('pdfPreview'));
    }

    public function getNurseDetail()
    {
        $response = [
            'rx_nurses' => view('admin.document.templates.rx.nurse_detail', [
                'rx_nurses' => Rx::pending()->latest()->get(),
                'prefix' => $this->prefix,
                'crudRoutePath' => $this->crudRoutePath,
            ])->render(),
        ];

        return response()->json($response);
    }

    public function frmAddNewRxNurse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nuse_description' => 'required',
            'nurse_result' => 'required',
            'docfile' => 'required',
            'docfile.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:10240',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            foreach ($request->nurse_result as $key => $value) {
                RxDetail::create([
                    'rx_id' => $request->rx_id,
                    'user_id' => auth()->id(),
                    'description' => $request->nuse_description[$key],
                    'result' => $value,
                ]);
            }
            $docfiles = $request->file('docfile');
            foreach ($docfiles as $key => $file) {
                // $mytime = Carbon\Carbon::now()->toDateString();
                $cusName = Str::slug($request->name);
                $mytime = date('d-M-Y');
                $docname = 'Docfile-'.$key.'-'.$cusName.'-'.$mytime.'-'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/rx/docfiles/'), $docname);
                RxDocfile::create([
                    'rx_id' => $request->rx_id,
                    'filename' => $docname,
                ]);
            }
            Rx::where('id', $request->rx_id)->update([
                'status' => 1,
            ]);
            $response = [
                'status' => 200,
                'success' => 'Data successfully updated!',
                'rx_nurses' => view('admin.document.templates.rx.nurse_detail', [
                    'rx_nurses' => Rx::pending()->latest()->get(),
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath,
                ])->render(),
            ];
        }

        return response()->json($response);
    }

    public function getObjectH(Request $request)
    {
        $hospital = get_hospital_id($request->customer_id, $request->document_id);
        // for medicine order
        $kcustomer_order = Order::where('customer_id', '=', $request->customer_id)
            ->where('document_id', '=', $request->document_id)
            ->where('order_type', '=', 'Medicine')->first();

        if ($kcustomer_order) {
            $order_id = $kcustomer_order->id;
            $customer_order = $kcustomer_order;
        } else {
            $order_id = null;
            $customer_order = [];
        }
        // return response()->json($customer_order);
        if ($customer_order) {
            $kcustomer_order_details = OrderDetail::where('order_id', '=', $customer_order->id)->get();
            if ($kcustomer_order_details) {
                $customer_order_details = $kcustomer_order_details->load('product');
            } else {
                $customer_order_details = [];
            }
        } else {
            $customer_order_details = [];
        }
        // for Injection order
        $kcustomer_injection = Order::where('customer_id', '=', $request->customer_id)
            ->where('document_id', '=', $request->document_id)
            ->where('order_type', '=', 'Injection')->first();
        if ($kcustomer_injection) {
            $injection_id = $kcustomer_injection->id;
            $customer_injection = $kcustomer_injection;
        } else {
            $injection_id = null;
            $customer_injection = [];
        }
        if ($customer_injection) {
            $kcustomer_injection_details = OrderDetail::where('order_id', '=', $customer_injection->id)->get();
            if ($kcustomer_injection_details) {
                $customer_injection_details = $kcustomer_injection_details->load('product');
            } else {
                $customer_injection_details = [];
            }
        } else {
            $customer_injection_details = [];
        }
        $response = [
            'typeA' => view('admin.document.templates.doclife_typeA', [
                'typeA' => DocumentLife::where('customer_id', '=', $request->customer_id)
                    ->where('coltype', '=', 1)
                    ->groupBy('colfield')
                    ->get()])
                ->render(),
            'typeB' => view('admin.document.templates.doclife_typeB', [
                'typeB' => DocumentLife::where('customer_id', '=', $request->customer_id)
                    ->where('coltype', '=', 2)
                    ->groupBy('colfield')
                    ->get()])
                ->render(),
            'hts' => view('admin.document.templates.h.ht_detail', [
                'hospital_treatments' => HospitalTreatment::where('hospital_id', '=', $hospital)
                    ->latest()
                    ->get(),
                'crudRoutePath' => $this->crudRoutePath,
                'prefix' => $this->prefix])
                ->render(),
            'customer_order' => $customer_order,
            'customer_order_details' => $customer_order_details,
            'order_id' => $order_id,
            'customer_injection' => $customer_injection,
            'customer_injection_details' => $customer_injection_details,
            'injection_id' => $injection_id,
        ];

        return response()->json($response);
    }

    public function storeObjectH(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->status) {
            $status = true;
        } else {
            $status = false;
        }
        $validator = Validator::make($request->all(), [
            'room_no' => 'required',
            'h_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];
        } else {
            if (get_hospital_id($request->h_customer_id, $request->h_document_id)) {
                $datas = Hospital::where('customer_id', '=', $request->h_customer_id)
                    ->where('document_id', '=', $request->h_document_id)
                    ->first();
                $datas->update([
                    'room_id' => $request->room_no,
                    // 'h_note' => $request->h_note,
                ]);
                $response = [
                    'status' => 200,
                    'success' => 'Data Successfully updated!',
                    'data' => $datas,
                ];
            } else {
                $datas = Hospital::create([
                    'customer_id' => $request->h_customer_id,
                    'document_id' => $request->h_document_id,
                    'room_id' => $request->room_no,
                    'h_date' => date('Y-m-d H:i:s', strtotime($request->h_date)),
                    'status' => $status,
                ]);
                $response = [
                    'status' => 200,
                    'success' => 'Data Inserted Successfully!',
                    'data' => $datas,
                ];
            }
            $document = Document::where('customer_id', $request->h_customer_id)
                ->where('id', $request->h_document_id)->first();
            $document->update([
                'hospital_status' => 1,
            ]);
            $docDetail = checkExistService($request->h_document_id, 'h');
            if ($docDetail) {
                $docDetail->update([
                    'service_name' => 'h',
                    'status' => 1,
                ]);
            } else {
                DocumentDetail::create([
                    'document_id' => $request->h_document_id,
                    'user_id' => auth()->id(),
                    'service_name' => 'h',
                    'status' => 1,
                ]);
            }
        }

        return response()->json($response);
    }

    public function storeObjectHT(Request $request)
    {
        date_default_timezone_set('Asia/Phnom_Penh');
        abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->all();
        if ($data['status']) {
            $status = true;
        } else {
            $status = false;
        }
        $validator = Validator::make($request->all(), [
            'duration' => 'required',
            'product_id' => 'required',
            'qty' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];
        } else {
            if ($data['htd_hospital_treatment_id']) {
                $datas = HospitalTreatment::findOrFail($data['htd_hospital_id']);
                $datas->update([
                    'hospital_id' => $data['htd_hospital_treatment_id'],
                    'ht_date' => date('Y-m-d'),
                    'ht_time' => date('H:i:s'),
                    'product_id' => $data['product_id'],
                    'qty' => $data['qty'],
                    'duration' => $data['duration'],
                    'how_to_use' => $data['ht_how_to_use'],
                    'user_id' => auth()->id(),
                    'status' => $status,
                ]);
                if (count(array_filter($data['more_product'])) > 0) {
                    foreach ($data['more_product'] as $key => $value) {
                        if ($htd = HospitalTreatmentDetail::where('hospital_treatment_id', $data['htd_hospital_id'])
                            ->where('hospital_treatment_product_id', $data['htd_hospital_treatment_product_id'])
                            ->where('product_id', $value)->first()) {
                            $htd->update([
                                'qty' => $data['more_qty'][$key],
                                'how_to_use' => $data['more_how_to_use'][$key],
                            ]);
                        } else {
                            HospitalTreatmentDetail::create([
                                'hospital_treatment_id' => $data['htd_hospital_id'],
                                'hospital_treatment_product_id' => $data['htd_hospital_treatment_product_id'],
                                'product_id' => $value,
                                'qty' => $data['more_qty'][$key],
                                'how_to_use' => $data['more_how_to_use'][$key],
                            ]);
                        }
                    }
                    $response = [
                        'status' => 200,
                        'success' => 'Data successfully updated!',
                        'data' => $datas,
                        'hts' => view('admin.document.templates.h.ht_detail', [
                            'hospital_treatments' => HospitalTreatment::where('hospital_id', '=', $data['htd_hospital_treatment_id'])
                                ->latest()
                                ->get(),
                            'crudRoutePath' => $this->crudRoutePath,
                            'prefix' => $this->prefix])
                            ->render(),
                    ];
                }
            } else {
                $hospital = get_hospital_id($data['ht_customer_id'], $data['ht_document_id']);
                if ($hospital) {
                    $datas = HospitalTreatment::create([
                        'hospital_id' => $hospital,
                        'ht_date' => date('Y-m-d'),
                        'ht_time' => date('H:i:s'),
                        'product_id' => $data['product_id'],
                        'qty' => $data['qty'],
                        'duration' => $data['duration'],
                        'how_to_use' => $data['ht_how_to_use'],
                        'user_id' => auth()->id(),
                        'status' => $status,
                    ]);
                    $howToUse = $request->ht_how_to_use;
                    $unique = HowToUse::where('name', '=', $howToUse)->first();
                    if (! $unique) {
                        HowToUse::create([
                            'name' => $howToUse,
                        ]);
                    }
                    if (count(array_filter($data['more_product'])) > 0) {
                        foreach ($data['more_product'] as $key => $value) {
                            HospitalTreatmentDetail::create([
                                'hospital_treatment_id' => $datas->id,
                                'hospital_treatment_product_id' => $datas->product_id,
                                'product_id' => $value,
                                'qty' => $data['more_qty'][$key],
                                'how_to_use' => $data['more_how_to_use'][$key],
                            ]);
                        }
                        $howToUse = $request->more_how_to_use;
                        $uniques = array_unique($howToUse);
                        foreach ($uniques as $value) {
                            $unique = HowToUse::where('name', '=', $value)->first();
                            if (! $unique) {
                                HowToUse::create([
                                    'name' => $value,
                                ]);
                            } else {
                                continue;
                            }
                        }
                    }
                    $response = [
                        'status' => 200,
                        'success' => 'Data successfully create!',
                        'data' => $datas,
                        'hts' => view('admin.document.templates.h.ht_detail', [
                            'hospital_treatments' => HospitalTreatment::where('hospital_id', '=', $hospital)
                                ->latest()
                                ->get(),
                            'crudRoutePath' => $this->crudRoutePath,
                            'prefix' => $this->prefix])
                            ->render(),
                    ];
                }
            }
            $docDetail = checkExistService($request->ht_document_id, 'ht');
            if ($docDetail) {
                $docDetail->update([
                    'service_name' => 'ht',
                    'status' => 1,
                ]);
            } else {
                DocumentDetail::create([
                    'document_id' => $request->ht_document_id,
                    'user_id' => auth()->id(),
                    'service_name' => 'ht',
                    'status' => 1,
                ]);
            }
        }

        return response()->json($response);
    }

    public function editObjectHT(Request $request)
    {
        $hospital_treatments = HospitalTreatment::findOrFail($request->hospital_treatment_id);
        $product_details = HospitalTreatmentDetail::where('hospital_treatment_id', $hospital_treatments->id)
            ->where('hospital_treatment_product_id', $hospital_treatments->product_id)->get();
        $response = [
            'hospital_treatments' => $hospital_treatments,
            'product_details' => $product_details,
            'products' => Product::orderBy('p_name')->get(),
        ];

        return response()->json($response);
    }

    public function deleteObjectHT(Request $request)
    {
        $datas = HospitalTreatment::findOrFail($request->ht_id);
        $datas->delete();
        $htds = HospitalTreatmentDetail::where('hospital_treatment_id', $request->ht_id)->get();
        if ($htds->count() > 0) {
            foreach ($htds as $htd) {
                HospitalTreatmentDetail::findOrFail($htd->id)->delete();
            }
        }
        $response = [
            'status' => 200,
            'success' => 'Data was deleted successfully!',
            'data' => $datas,
        ];

        return response()->json($response);
    }

    public function deleteObjectHTD(Request $request)
    {
        $htd = HospitalTreatmentDetail::findOrFail($request->htd_id);
        $htd->delete();
        $response = [
            'status' => 200,
            'success' => 'Hospital Treatment Detail has been deleted Successfully!',
            'data' => $htd,
        ];

        return response()->json($response);
    }

    public function storeObjectHNote(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'mob' => 'required',
            // 'dia' => 'required',
            // 'todo' => 'required',
            // 'comment' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];
        } else {
            $hospital = get_hospital_id($data['med_customer_id'], $data['med_document_id']);
            $object_id = $request->med_object_id;
            if ($hospital) {
                $datas = HNote::updateOrcreate([
                    'id' => $object_id],
                    [
                        'hospital_id' => $hospital,
                        'date' => date('Y-m-d', strtotime($request['med_ht_date'])),
                        'mob' => $data['mob'],
                        'dia' => $data['dia'],
                        'todo' => $data['todo'],
                        'comment' => $data['comment'],
                    ]);
                if ($object_id) {
                    $type = 'update-object';
                    $success = 'Note has been updated Successfully!';
                } else {
                    $type = 'store-object';
                    $success = 'New Note Inserted Successfully!';
                }
                $response = [
                    'status' => 200,
                    'type' => $type,
                    'success' => $success,
                    'data' => $datas,
                    'html' => view('admin.document.templates.h.ajax_tr', [
                        'row' => $datas,
                        'prefix' => $this->prefix,
                        'crudRoutePath' => $this->crudRoutePath])
                        ->render(),
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Please Create Hospital First, Before Add Teatment Note',
                ];
            }
        }

        return response()->json($response);
    }

    public function editObjectHNote(Request $request)
    {
        $data['hnote'] = HNote::findOrFail($request->id);

        return response()->json($data);
    }

    public function updateObjectHNote(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->all();
        $datas = HNote::where('hospital_id', '=', $data['hospital_id'])
            ->whereDate('date', date('Y-m-d'))
            ->first();
        $datas->update(
            [
                'mob' => $data['mob'],
                'dia' => $data['dia'],
                'todo' => $data['todo'],
                'comment' => $data['comment'],
            ]
        );
        $response = [
            'status' => 200,
            'success' => 'Existing note Has been updated Successfully!',
            'data' => $datas,
        ];

        return response()->json($response);
    }

    public function deleteObjectHNote(Request $request)
    {
        $datas = HNote::findOrFail($request->hnote_id);
        $datas->delete();
        $response = [
            'status' => 200,
            'success' => 'Data was deleted successfully!',
            'data' => $datas,
        ];

        return response()->json($response);
    }

    public function storeObjectOrder(Request $request)
    {
        $datas = $request->all();
        $validator = Validator::make($request->all(), [
            'chief_complain' => 'required',
            // 'past_history' => 'required',
            // 'blood_test' => 'required',
            // 'orl_ent' => 'required',
            // 'ultra_sound' => 'required',
            // 'ecg' => 'required',
            // 'x_ray' => 'required',
            // 'et_at' => 'required',
            // 'diagnosis' => 'required',
            // 'recommendation' => 'required',
            // 'order_product' => 'required|array',
            // 'unit_save' => 'required|array',
            // 'strength_save' => 'required|array',
            // 'qty_save' => 'required|array',
            // 'how_to_use_save' => 'required|array',
            // 'before_after_save' => 'required|array',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            $all_order_data = [
                'order_date' => date('Y-m-d'),
                'document_id' => $datas['medicine_document_id'],
                'customer_id' => $datas['medicine_customer_id'],
                'user_id' => auth()->id(),
                'chief_complain' => $datas['chief_complain'],
                'past_history' => $datas['past_history'],
                'blood_test' => $datas['blood_test'],
                'orl_ent' => $datas['orl_ent'],
                'ultra_sound' => $datas['ultra_sound'],
                'ecg' => $datas['ecg'],
                'x_ray' => $datas['x_ray'],
                'et_at' => $datas['et_at'],
                'diagnosis' => $datas['diagnosis'],
                'recommendation' => $datas['recommendation'],
                'order_type' => 'Medicine',
            ];
            if ($datas['order_id']) {
                $existData = Order::findOrFail($datas['order_id']);
                $existData->update($all_order_data);
                $countProducts = $request->order_product_save;
                if ($countProducts) {
                    foreach ($countProducts as $key => $product_id) {
                        if ($request->idUpdate[$key] == null) {
                            // return 'no ID Update';
                            OrderDetail::create([
                                'order_id' => $datas['order_id'],
                                'product_id' => $product_id,
                                'unit' => $datas['unit_save'][$key],
                                'strength' => $datas['strength_save'][$key],
                                'qty' => $datas['qty_save'][$key],
                                'how_to_use' => $datas['how_to_use_save'][$key],
                                'before_after' => $datas['before_after_save'][$key],
                            ]);
                        } else {
                            OrderDetail::where('id', '=', $request->idUpdate[$key])->update([
                                'order_id' => $datas['order_id'],
                                'product_id' => $product_id,
                                'unit' => $datas['unit_save'][$key],
                                'strength' => $datas['strength_save'][$key],
                                'qty' => $datas['qty_save'][$key],
                                'how_to_use' => $datas['how_to_use_save'][$key],
                                'before_after' => $datas['before_after_save'][$key],
                            ]);
                            // return 'have ID to Update';
                        }
                    }
                    // //insert to table how_to_use
                    $howToUse = $request->how_to_use_save;
                    $uniques = array_unique($howToUse);
                    foreach ($uniques as $value) {
                        $unique = HowToUse::where('name', '=', $value)->first();
                        if (! $unique) {
                            HowToUse::create([
                                'name' => $value,
                            ]);
                        } else {
                            continue;
                        }
                    }
                }
                $success = 'Order has been updated Successfully!';
            } else {
                $order_data = Order::create($all_order_data);
                if ($order_data) {
                    $orderCount = $request->order_product_save;
                    // $countrow=count($request->order_product_save)-1;
                    if ($orderCount) {
                        foreach ($orderCount as $key => $product_id) {
                            // for($key=$countrow;$key>=0;$key--){
                            OrderDetail::create([
                                'order_id' => $order_data->id,
                                // 'product_id' => $datas['order_product_save'][$key],
                                'product_id' => $product_id,
                                'unit' => $datas['unit_save'][$key],
                                'strength' => $datas['strength_save'][$key],
                                'qty' => $datas['qty_save'][$key],
                                'how_to_use' => $datas['how_to_use_save'][$key],
                                'before_after' => $datas['before_after_save'][$key],
                            ]);
                        }
                        // //insert to table how_to_use
                        $howToUse = $request->how_to_use_save;
                        $uniques = array_unique($howToUse);
                        foreach ($uniques as $value) {
                            $unique = HowToUse::where('name', '=', $value)->first();
                            if (! $unique) {
                                HowToUse::create([
                                    'name' => $value,
                                ]);
                            } else {
                                continue;
                            }
                        }
                    }
                    $success = 'Order has been created Successfully!';
                }
            }
            $docDetail = checkExistService($datas['medicine_document_id'], 'order');
            if ($docDetail) {
                $docDetail->update([
                    'service_name' => 'order',
                    'status' => 1,
                ]);
            } else {
                DocumentDetail::create([
                    'document_id' => $datas['medicine_document_id'],
                    'user_id' => auth()->id(),
                    'service_name' => 'order',
                    'status' => 1,
                ]);
            }
            $response = [
                'status' => 200,
                'success' => $success,
                // 'data' => $data,
                // 'receipt' => view('admin.document.templates.order.receipt',[
                //   'order' => $data->load('details'),
                // ])->render(),
            ];
        }

        return response()->json($response);
    }

    public function getObjectOrder()
    {
        $data['orders'] = Order::latest()->get();
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;

        return view('admin.document.templates.order.list_orders', $data);
    }

    public function search_how_to_use(Request $request)
    {
        if ($request->get('term', '')) {
            $query = $request->get('term');
            $howtouses = HowToUse::where('name', 'LIKE', "%{$query}%")->get();
            $data = [];
            foreach ($howtouses as $row) {
                $data[] = ['name' => $row->name];
            }
            if (count($data)) {
                return $data;
            } else {
                return ['name' => ''];
            }
            // $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            // foreach($data as $row)
            // {
            //  $output .= '
            //  <li><a href="#">'.$row->name.'</a></li>
            //  ';
            // }
            // $output .= '</ul>';
            // echo $output;;
        }
    }

    public function getProductByID(Request $request)
    {
        if ($request->ajax()) {
            $response = [
                'product' => Product::findOrFail($request->product_id),
            ];

            return response()->json($response);
        }
    }

    public function previewReceipt(Order $order)
    {
        $data['order'] = $order;
        $data['setting'] = CompanyInformation::findOrFail(1);

        return view('admin.document.templates.order.receipt', $data);
    }

    public function storeObjectInjection(Request $request)
    {
        $datas = $request->all();
        $validator = Validator::make($request->all(), [
            'injection_product_save' => 'required|array',
            'injection_qty_save' => 'required|array',
            'injection_unit_save' => 'required|array',
            'injection_strength_save' => 'required|array',
            'injection_how_to_use_save' => 'required|array',
            'injection_before_after_save' => 'required|array',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            $all_data = [
                'order_date' => date('Y-m-d'),
                'customer_id' => $datas['injection_customer_id'],
                'document_id' => $datas['injection_document_id'],
                'user_id' => auth()->id(),
                'diagnosis' => 'diagnosis',
                'recommendation' => 'recommendation',
                'order_type' => 'Injection',
            ];
            // return response()->json($datas);
            if ($datas['injection_id']) {
                $existData = Order::findOrFail($datas['injection_id']);
                $existData->update($all_data);
                if ($existData) {
                    $orders = $request->injection_product_save;
                    if ($orders) {
                        foreach ($orders as $key => $order) {
                            if ($datas['id_Injection_Update'][$key] == null) {
                                OrderDetail::create([
                                    'order_id' => $datas['injection_id'],
                                    'product_id' => $order,
                                    'unit' => $datas['injection_unit_save'][$key],
                                    'strength' => $datas['injection_strength_save'][$key],
                                    'qty' => $datas['injection_qty_save'][$key],
                                    'how_to_use' => $datas['injection_how_to_use_save'][$key],
                                    'before_after' => $datas['injection_before_after_save'][$key],
                                ]);
                            } else {
                                OrderDetail::where('id', '=', $datas['id_Injection_Update'][$key])->update([
                                    'order_id' => $datas['injection_id'],
                                    'product_id' => $order,
                                    'unit' => $datas['injection_unit_save'][$key],
                                    'strength' => $datas['injection_strength_save'][$key],
                                    'qty' => $datas['injection_qty_save'][$key],
                                    'how_to_use' => $datas['injection_how_to_use_save'][$key],
                                    'before_after' => $datas['injection_before_after_save'][$key],
                                ]);
                            }
                        }
                        // insert to table how_to_use
                        $howToUse = $request->injection_how_to_use_save;
                        $uniques = array_unique($howToUse);
                        foreach ($uniques as $value) {
                            $unique = HowToUse::where('name', '=', $value)->first();
                            if (! $unique) {
                                HowToUse::create([
                                    'name' => $value,
                                ]);
                            } else {
                                continue;
                            }
                        }
                    }
                }
                $success = 'Injection has been updated Successfully!';
            } else {
                $data = Order::create($all_data);
                if ($data) {
                    $orders = $request->injection_product_save;
                    if ($orders) {
                        foreach ($orders as $key => $order) {
                            OrderDetail::create([
                                'order_id' => $data->id,
                                'product_id' => $order,
                                'unit' => $datas['injection_unit_save'][$key],
                                'strength' => $datas['injection_strength_save'][$key],
                                'qty' => $datas['injection_qty_save'][$key],
                                'how_to_use' => $datas['injection_how_to_use_save'][$key],
                                'before_after' => $datas['injection_before_after_save'][$key],
                            ]);
                        }
                        // //insert to table how_to_use
                        $howToUse = $request->injection_how_to_use_save;
                        $uniques = array_unique($howToUse);
                        foreach ($uniques as $value) {
                            $unique = HowToUse::where('name', '=', $value)->first();
                            if (! $unique) {
                                HowToUse::create([
                                    'name' => $value,
                                ]);
                            } else {
                                continue;
                            }
                        }
                    }
                }
                $success = 'Injection has been created Successfully!';
            }
            $docDetail = checkExistService($datas['injection_document_id'], 'injection');
            if ($docDetail) {
                $docDetail->update([
                    'service_name' => 'injection',
                    'status' => 1,
                ]);
            } else {
                DocumentDetail::create([
                    'document_id' => $datas['injection_document_id'],
                    'user_id' => auth()->id(),
                    'service_name' => 'injection',
                    'status' => 1,
                ]);
            }
            $response = [
                'status' => 200,
                'success' => $success,
                // 'data' => $data,
                // 'receipt' => view('admin.document.templates.order.receipt',[
                //   'order' => $data->load('details'),
                // ])->render(),
            ];
        }

        return response()->json($response);
    }

    public function checkout(Request $request)
    {
        $document = Document::findOrFail($request->document_id);
        $document->update([
            'checkout_date' => date('Y-m-d'),
            'checkout_status' => 'Y',
            'hospital_status' => 1,
        ]);
        $response = [
            'data' => $document,
            'success' => 'Document has been updated!',
        ];

        return response()->json($response);
    }

    public function storeCustomer(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $object_id = $request->object_id;
        $rules = [
            'name' => ['required', 'string'],
            'sex' => ['required', 'string'],
            'age' => ['required', 'string'],
            'dob' => ['required', 'date'],
            // 'province_id' => ['required'],
            // 'district_id' => ['required'],
            // 'commune_id' => ['required'],
            // 'village_id' => ['required'],
            // 'phone_no' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            if ($request->status) {
                $status = true;
            } else {
                $status = false;
            }
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $image_name = Str::slug($request->name).'-'.uniqid().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('uploads/customer/'), $image_name);
            } else {
                if ($request->old_image) {
                    $image_name = $request->old_image;
                } else {
                    $image_name = null;
                }
            }
            $datas = Customer::updateOrCreate([
                'id' => $object_id],
                [
                    'customer_code' => null,
                    'name' => $request->name,
                    'sex' => $request->sex,
                    'age' => $request->age,
                    'dob' => $request->dob,
                    'province_id' => $request->province_id ?? null,
                    'district_id' => $request->district_id ?? null,
                    'commune_id' => $request->commune_id ?? null,
                    'village_id' => $request->village_id ?? null,
                    'phone_no' => $request->phone_no ?? null,
                    'photo' => $image_name,
                    'register_date' => $request->register_date,
                    'register_by' => Auth::id(),
                    'status' => $status,
                ]);
            if (! $object_id && $datas) {
                Document::create([
                    'customer_id' => $datas->id,
                    'user_id' => Auth::id(),
                    'visit_date' => $datas->register_date,
                    'status' => true,
                ]);
            }
            if ($object_id) {
                $type = 'update-object';
                $success = 'Customer has been Updated!';
            } else {
                $type = 'store-object';
                $success = 'Customer has been registered!';
            }
            $response = [
                'status' => 200,
                'type' => $type,
                'data' => $datas,
                'success' => $success,
            ];
        }

        return response()->json($response);
    }

    public function showHospital(Customer $customer, Document $document)
    {
        $data['document'] = $document;
        $data['customer'] = $customer;
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['rooms'] = Room::pluck('room_no', 'id');
        $data['products'] = Product::orderBy('p_name')->get();
        $data['how_to_uses'] = HowToUse::orderBy('name')->get();
        $data['types'] = LifeSign::where('type_id', '=', 0)->pluck('name', 'id');
        $data['typeA'] = DocumentLife::where('customer_id', '=', $customer->id)
            ->where('coltype', '=', 1)
            ->groupBy('colfield')
            ->get();
        $data['typeB'] = DocumentLife::where('customer_id', '=', $customer->id)
            ->where('coltype', '=', 2)
            ->groupBy('colfield')
            ->get();
        $hids = Hospital::where('customer_id', $customer->id)->get()->map(function ($hospital) {
            return $hospital->id;
        });
        $data['hospital_treatments'] = HospitalTreatment::whereIn('hospital_id', $hids)->orderBy('ht_date', 'DESC')->get()->groupBy('ht_date');
        $data['hnotes'] = HNote::whereIn('hospital_id', $hids)->orderBy('date', 'DESC')->get()->groupBy('date');

        return view('admin.document.templates.h.hospital', $data);
    }

    public function searchProduct(Request $request)
    {
        if ($request->get('term', '')) {
            $query = $request->get('term');
            $products = Product::where('p_name', 'LIKE', "%{$query}%")->get();
            $data = [];
            foreach ($products as $row) {
                $data[] = [
                    'id' => $row->id,
                    'p_name' => $row->p_name,
                    'unit' => $row->unit,
                    'strength' => $row->strength,
                ];
            }
            if (count($data)) {
                return $data;
            } else {
                return ['p_name' => '', 'unit' => '', 'strength' => ''];
            }
        }
    }

    public function removeOrder(Request $request)
    {
        $order = OrderDetail::Find($request->order_id);
        $order->delete();

        return response()->json(['success' => 'Order has beed deleted successfully!']);
    }

    public function removeInjection(Request $request)
    {
        $injection = OrderDetail::Find($request->injection_id);
        $injection->delete();

        return response()->json(['success' => 'Injection has beed deleted successfully!']);
    }
}
