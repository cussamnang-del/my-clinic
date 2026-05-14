<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
  public bool $updateMode = false;

  public string $prefix = 'user_';

  public string $crudRoutePath = 'users';

  public function index()
  {
    abort_if(Gate::denies($this->prefix . 'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    return view('admin.user.index', [
      'prefix'        => $this->prefix,
      'crudRoutePath' => $this->crudRoutePath,
      'updateMode'    => $this->updateMode,
      'roles'         => Role::pluck('title', 'id'),
      'users'         => User::where('id', '>', 1)->latest()->get(),
    ]);
  }

  /**
   * Create or update a User record.
   *
   * The endpoint is dual-purpose for legacy frontend reasons (the admin
   * UI submits both create and update to /admin/users with an
   * `object_id` flag). Validation rules are sourced from
   * StoreUserRequest / UpdateUserRequest so the rule set is documented
   * in one place; splitting this into RESTful store + update endpoints
   * is tracked in audit-report.md (Phase 1b refactor).
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
      ? UpdateUserRequest::rulesFor($objectId)
      : StoreUserRequest::rulesFor();

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'error'  => $validator->errors()->toArray(),
      ]);
    }

    $validated = $validator->validated();

    // Resolve the profile image: prefer a freshly uploaded file (with a
    // sanitised random filename) over a previously-stored one.
    $imageName = $this->resolveProfileImage($request, $validated);

    $payload = [
      'name'          => $validated['name'] ?? null,
      'username'      => $validated['username'] ?? null,
      'phone_no'      => $validated['phone_no'] ?? null,
      'email'         => $validated['email'] ?? null,
      'status'        => (bool) $request->input('status'),
      'profile_image' => $imageName,
    ];

    // The User model's setPasswordAttribute() hashes via bcrypt when set;
    // only include the password key when an actual value was supplied.
    if (!empty($validated['password'])) {
      $payload['password'] = $validated['password'];
    }

    // Strip null fields on update so we don't accidentally clear them.
    if ($isUpdate) {
      $payload = array_filter(
        $payload,
        static fn ($value, $key) => $value !== null || $key === 'profile_image' || $key === 'status',
        ARRAY_FILTER_USE_BOTH
      );
    }

    $user = User::updateOrCreate(['id' => $objectId], $payload);

    if (!empty($validated['roles'])) {
      $user->roles()->sync($validated['roles']);
    }

    return response()->json([
      'status'  => 200,
      'type'    => $isUpdate ? 'update-object' : 'store-object',
      'data'    => $user,
      'success' => $isUpdate
        ? 'User has been updated successfully!'
        : 'User has been registered successfully!',
      'html'    => view('admin.user.templates.ajax_tr', [
        'row'           => $user,
        'prefix'        => $this->prefix,
        'crudRoutePath' => $this->crudRoutePath,
      ])->render(),
    ]);
  }

  public function show($id)
  {
    abort_if(Gate::denies($this->prefix . 'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    return response()->json(['data' => User::findOrFail($id)]);
  }

  public function edit($id)
  {
    abort_if(Gate::denies($this->prefix . 'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    return response()->json([
      'data' => User::findOrFail($id)->load('roles'),
    ]);
  }

  public function destroy($id)
  {
    abort_if(Gate::denies($this->prefix . 'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    return response()->json(User::findOrFail($id)->delete());
  }

  public function changeStatus(Request $request)
  {
    abort_if(Gate::denies($this->prefix . 'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $user = User::findOrFail((int) $request->input('object_id'));
    $user->status = (bool) $request->input('status');
    $user->save();

    return response()->json(['success' => 'Status has been changed successfully!']);
  }

  /**
   * Choose where the user's profile image will be stored.
   *
   * On upload: write to public/uploads/user/<random>.<ext> using a UUID
   * filename so the user cannot influence the path or extension. The
   * extension is taken from PHP's MIME-sniffed value via
   * UploadedFile::extension() rather than the client-provided filename.
   *
   * Migration to storage/app/public + Storage::url() is tracked as
   * Phase 2 work in audit-report.md.
   */
  protected function resolveProfileImage(Request $request, array $validated): ?string
  {
    if ($request->hasFile('profile_image')) {
      $image     = $request->file('profile_image');
      $extension = $image->extension() ?: $image->getClientOriginalExtension();
      $filename  = Str::uuid()->toString() . '.' . strtolower($extension);
      $destDir   = public_path('uploads/user');
      if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
      }
      $image->move($destDir, $filename);
      return $filename;
    }

    return $validated['old_image'] ?? null;
  }
}
