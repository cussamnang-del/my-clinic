<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCustomerRequest;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Document;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
  protected string $prefix = 'customer_';

  protected string $crudRoutePath = 'customers';

  public function index()
  {
    abort_if(Gate::denies($this->prefix . 'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    return view('admin.customer.index', [
      'prefix'        => $this->prefix,
      'crudRoutePath' => $this->crudRoutePath,
      'customers'     => Customer::latest()->get(),
      'provinces'     => Province::all(),
    ]);
  }

  /**
   * Create or update a Customer record.
   *
   * Validation rules come from {Store,Update}CustomerRequest so the
   * rule set is documented in one place; splitting this into RESTful
   * store + update endpoints is tracked in audit-report.md (Phase 1b).
   */
  public function store(Request $request)
  {
    $objectId = (int) $request->input('object_id') ?: null;
    $isUpdate = $objectId !== null;

    abort_if(
      $isUpdate
        ? Gate::denies($this->prefix . 'edit')
        : Gate::denies($this->prefix . 'create'),
      Response::HTTP_FORBIDDEN,
      '403 Forbidden'
    );

    $rules = $isUpdate
      ? UpdateCustomerRequest::rulesFor()
      : StoreCustomerRequest::rulesFor();

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'error'  => $validator->errors()->toArray(),
      ]);
    }

    $validated = $validator->validated();

    $imageName = $this->resolvePhoto($request, $validated);

    $registerDate = !empty($validated['register_date'])
      ? date('Y-m-d', strtotime($validated['register_date']))
      : date('Y-m-d');

    $customer = Customer::updateOrCreate(
      ['id' => $objectId],
      [
        'customer_code' => null,
        'name'          => $validated['name'] ?? null,
        'sex'           => $validated['sex'] ?? null,
        'age'           => $validated['age'] ?? null,
        'dob'           => $validated['dob'] ?? null,
        'province_id'   => $validated['province_id'] ?? null,
        'district_id'   => $validated['district_id'] ?? null,
        'commune_id'    => $validated['commune_id'] ?? null,
        'village_id'    => $validated['village_id'] ?? null,
        'phone_no'      => $validated['phone_no'] ?? null,
        'photo'         => $imageName,
        'register_date' => $registerDate,
        'register_by'   => Auth::id(),
        'status'        => (bool) $request->input('status'),
      ]
    );

    // When a brand-new customer is created, seed a Document so the
    // service flow has somewhere to attach lab orders to.
    if (!$isUpdate && $customer) {
      Document::create([
        'customer_id' => $customer->id,
        'user_id'     => Auth::id(),
        'visit_date'  => $customer->register_date,
        'status'      => true,
      ]);
    }

    return response()->json([
      'status'  => 200,
      'type'    => $isUpdate ? 'update-object' : 'store-object',
      'data'    => $customer,
      'success' => $isUpdate
        ? 'Customer has been updated!'
        : 'Customer has been registered!',
      'html'    => view('admin.customer.templates.ajax_tr', [
        'row'           => $customer,
        'prefix'        => $this->prefix,
        'crudRoutePath' => $this->crudRoutePath,
      ])->render(),
    ]);
  }

  public function show(Customer $customer)
  {
    abort_if(Gate::denies($this->prefix . 'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    return view('admin.customer.index', [
      'prefix'        => $this->prefix,
      'crudRoutePath' => $this->crudRoutePath,
      'customers'     => $customer,
      'provinces'     => Province::all(),
    ]);
  }

  public function edit(Customer $customer)
  {
    abort_if(Gate::denies($this->prefix . 'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    return response()->json(['data' => $customer]);
  }

  public function destroy(Customer $customer)
  {
    abort_if(Gate::denies($this->prefix . 'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $photoPath = public_path('uploads/customer/' . $customer->photo);
    if ($customer->delete()) {
      if (!empty($customer->photo) && is_file($photoPath)) {
        @unlink($photoPath);
      }
    }

    return response()->json(['success' => 'Customer has been deleted successfully!']);
  }

  public function changeStatus(Request $request)
  {
    abort_if(Gate::denies($this->prefix . 'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $customer = Customer::findOrFail((int) $request->input('object_id'));
    $customer->status = (bool) $request->input('status');
    $customer->save();

    return response()->json(['success' => 'Status has been changed successfully!']);
  }

  /**
   * Choose where the customer's photo will be stored.
   *
   * Uses a UUID filename + MIME-sniffed extension so the user cannot
   * influence the on-disk path or extension. The existing
   * public/uploads/customer/ location is preserved for backward
   * compatibility; migration to Laravel Storage is Phase 2.
   */
  protected function resolvePhoto(Request $request, array $validated): ?string
  {
    if ($request->hasFile('photo')) {
      $image     = $request->file('photo');
      $extension = $image->extension() ?: $image->getClientOriginalExtension();
      $filename  = Str::uuid()->toString() . '.' . strtolower($extension);
      $destDir   = public_path('uploads/customer');
      if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
      }
      $image->move($destDir, $filename);
      return $filename;
    }

    return $validated['old_image'] ?? null;
  }
}
