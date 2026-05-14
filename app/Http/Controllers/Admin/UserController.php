<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
  public $updateMode = false;

  public $prefix = 'user_';

  public $crudRoutePath = 'users';

  public function index()
  {
    abort_if(Gate::denies($this->prefix . 'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $data['prefix'] = $this->prefix;
    $data['crudRoutePath'] = $this->crudRoutePath;
    $data['updateMode'] = $this->updateMode;
    $data['roles'] = Role::pluck('title', 'id');
    $data['users'] = User::where('id', '>', 1)->latest()->get();
    return view('admin.user.index', $data);
  }

  public function store(Request $request)
  {
    abort_if(Gate::denies($this->prefix . 'create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    if ($request->status) {
      $status = true;
    } else {
      $status = false;
    }
    $rules =  [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'username'  => ['required', 'unique:users'],
      'phone_no'  => ['required', 'unique:users'],
      'roles.*' => [
        'integer',
      ],
      'roles' => [
        'required',
        'array',
      ],
    ];
    if ($request->hasFile('profile_image')) {
      $image = $request->file('profile_image');
      $image_name = $request->username . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('uploads/user/'), $image_name);
    } else {
      if ($request->old_image) {
        $image_name = $request->old_image;
      } else {
        $image_name = null;
      }
    }
    $object_id = $request->object_id;
    if ($object_id) {
      unset(
        $rules['email'],
        $rules['username'],
        $rules['phone_no'],
        $rules['password'],
      );
      $type = 'update-object';
      $success = 'User has been updated successfully!';
    } else {
      $type = 'store-object';
      $success = 'User has been register successfully!';
    }
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      $response = [
        'status' => 400,
        'error' => $validator->errors()->toArray()
      ];
      return response()->json($response);
    } else {
      if (!$request->password) {
        $datas   =   User::updateOrCreate(
          [
            'id' => $object_id
          ],
          [
            'name' => $request->name,
            'username' => $request->username,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'status' => $status,
            'profile_image' => $image_name
          ]
        );
      } else {
        $datas   =   User::updateOrCreate(
          [
            'id' => $object_id
          ],
          [
            'name' => $request->name,
            'username' => $request->username,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $status,
            'profile_image' => $image_name
          ]
        );
      }
      $datas->roles()->sync($request->roles);
      $response = [
        'status'   => 200,
        'type'    => $type,
        'data'    => $datas,
        'success' => $success,
        'html'    => view('admin.user.templates.ajax_tr', [
          'row' => $datas,
          'prefix' => $this->prefix,
          'crudRoutePath' => $this->crudRoutePath
        ])
          ->render(),
      ];
      return response()->json($response);
    }
  }

  public function show($id)
  {
    abort_if(Gate::denies($this->prefix . 'show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $user = User::findOrFail($id);
    $response = [
      'data'  => $user
    ];
    return response()->json($response);
  }

  public function edit($id)
  {
    abort_if(Gate::denies($this->prefix . 'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response = [
      'data'  => User::findOrFail($id)->load('roles')
    ];
    return response()->json($response);
  }

  public function destroy($id)
  {
    abort_if(Gate::denies($this->prefix . 'delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $datas = User::find($id)->delete();
    return response()->json($datas);
  }

  public function changeStatus(Request $request)
  {
    abort_if(Gate::denies($this->prefix . 'edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $response = User::find($request->object_id);
    $response->status = $request->status;
    $response->save();
    return response()->json(['success' => 'Status has been change successfully!']);
  }
}
