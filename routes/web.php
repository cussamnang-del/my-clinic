<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\Admin\ProvinceDistrictCommuneVillageController;

Route::get('/', function () {
  // $data = Document::whereDate('visit_date', '>=', '2022-07-26')
  //                   ->whereDate('visit_date', '<=', '2022-07-27')
  //                   ->get();
  // return $data;
//  return $now = date('Y-m-d');
  // if(Product::where('id',2)->whereDate('created_at', '=',  $now)->first()){
  //   return "The same date";
  // } else {
  //   return "Deference Date";
  // }
  // $admin_permissions = Permission::all();
  // Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
  return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/districts', [ProvinceDistrictCommuneVillageController::class, 'district'])
  ->name('districts.index');

Route::get('/communes', [ProvinceDistrictCommuneVillageController::class, 'commune'])
  ->name('communes.index');

Route::get('/villages', [ProvinceDistrictCommuneVillageController::class, 'village'])
  ->name('villages.index');

//for switching language route
Route::get('/locale/{locale}', function ($locale) {
  Session::put('locale', $locale);
  return redirect()->back();
});

Route::get('full-calendar', [FullCalenderController::class, 'calendar3']);

Route::post('full-calendar/action', [FullCalenderController::class, 'action']);

Route::get('/auto', function () {
  return view('autocomplete');
});

Route::get('/get-countries', function (Request $request) {
  $name = $request->get('name');
  $fieldName = $request->get('fieldName');
  $name = strtolower(trim($name));
  $allowedFields = ['name', 'id', 'code'];
  if (empty($fieldName) || !in_array($fieldName, $allowedFields)) {
    $fieldName = 'name';
  }
  $countries = DB::table('country')
    ->select('country.*')
    ->whereRaw("LOWER(" . $fieldName . ") LIKE ?", ["$name%"])
    ->limit(25)
    ->get();

  return $countries;
});
