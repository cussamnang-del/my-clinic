<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCompanyInformationRequest;
use App\Models\CompanyInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CompanyInformationController extends Controller
{
    protected $prefix = 'company_information_';

    protected $crudRoutePath = 'company_informations';

    public function index()
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['company_informations'] = CompanyInformation::latest()->get();

        return view('admin.company_information.index', $data);
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
        $rules = StoreCompanyInformationRequest::rulesFor();
        if (! $object_id) {
            $rules['photo'] = 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1920,max_height=1080';
        }
        $validator = Validator::make($request->all(), $rules);
        if (! $validator->passes()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $image_name = 'kong_rithy_logo_'.uniqid().'.'.($image->extension() ?: $image->getClientOriginalExtension());
                $image->move(public_path('uploads/logo/'), $image_name);
            } else {
                if ($request->old_image) {
                    $image_name = $request->old_image;
                } else {
                    $image_name = 'image-icon.png';
                }
            }
            $all_datas = [
                'name_en' => $request->name_en,
                'name_kh' => $request->name_kh,
                'address' => $request->address,
                'phone1' => $request->phone1,
                'phone2' => $request->phone2,
                'phone3' => $request->phone3,
                'logo' => $image_name,
                'status' => $status,
            ];
            // return response()->json($all_datas);
            $datas = CompanyInformation::updateOrCreate([
                'id' => $object_id], $all_datas);
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
                'html' => view('admin.company_information.templates.ajax_tr', [
                    'row' => $datas,
                    'prefix' => $this->prefix,
                    'crudRoutePath' => $this->crudRoutePath])
                    ->render(),
            ];
        }

        return response()->json($response);
    }

    public function show(CompanyInformation $company_information)
    {
        abort_if(Gate::denies($this->prefix.'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = [
            'data' => $company_information,
        ];

        return response()->json($response);
    }

    public function edit(CompanyInformation $company_information)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = [
            'data' => $company_information,
        ];

        return response()->json($response);
    }

    public function destroy(CompanyInformation $company_information)
    {
        abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $deleteImage = public_path('uploads/logo/'.$company_information->logo);
        if ($company_information->delete()) {
            if (\file_exists($deleteImage)) {
                unlink($deleteImage);
            }
        }

        return response()->json(['success' => 'Item has been deleted successfully!']);
    }

    public function changeStatus(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = CompanyInformation::find($request->object_id);
        $response->status = $request->status;
        $response->save();

        return response()->json(['success' => 'Status has been change successfully!']);
    }
}
