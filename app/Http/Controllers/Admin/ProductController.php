<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    protected $prefix = 'product_';

    protected $crudRoutePath = 'products';

    public function index()
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['prefix'] = $this->prefix;
        $data['crudRoutePath'] = $this->crudRoutePath;
        $data['products'] = Product::latest()->get();

        return view('admin.product.index', $data);
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
        $validator = Validator::make($request->all(), StoreProductRequest::rulesFor());
        if (! $validator->passes()) {
            $response = [
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ];

            return response()->json($response);
        } else {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $mytime = date('d-M-Y');
                $image_name = 'Product-'.$mytime.'-'.uniqid().'.'.($image->extension() ?: $image->getClientOriginalExtension());
                $image->move(public_path('uploads/product/'), $image_name);
            } else {
                if ($request->old_image) {
                    $image_name = $request->old_image;
                } else {
                    $image_name = null;
                }
            }
            $all_data = [
                'p_name' => $request->p_name,
                'p_code' => $request->p_code,
                'unit' => $request->unit,
                'strength' => $request->strength,
                'group_id' => 1,
                'type_id' => 1,
                'country' => $request->country ?? '',
                'description' => $request->description ?? '',
                'image' => $image_name,
                'status' => $status,
            ];
            $datas = Product::updateOrCreate([
                'id' => $object_id], $all_data);
            if ($object_id) {
                $type = 'update-object';
                $success = 'Product has been Updated!';
            } else {
                $type = 'store-object';
                $success = 'Product has been registered!';
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

    public function show(Product $product)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = ['data' => $product];

        return response()->json($response);
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = ['data' => $product];

        return response()->json($response);
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies($this->prefix.'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($product->delete()) {
            $imagePath = public_path('uploads/product/'.$product->image);
            if (! empty($product->image) && is_file($imagePath)) {
                @unlink($imagePath);
            }
        }

        return response()->json(['success' => 'Item has been deleted successfully!']);
    }

    public function changeStatus(Request $request)
    {
        abort_if(Gate::denies($this->prefix.'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $response = Product::find($request->object_id);
        $response->status = $request->status;
        $response->save();

        return response()->json(['success' => 'Status has been change successfully!']);
    }
}
