<?php

namespace App\Http\Controllers\Admin;

use App\Models\Commune;
use App\Models\Village;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProvinceDistrictCommuneVillageController extends Controller
{
  public function district()
  {
    $flag = app()->getLocale();
    $districts = District::whereHas('province', function ($query) {
      $query->whereId(request()->input('province_id', 0));
    })->pluck( 'name_'.$flag, 'id');

    return response()->json($districts);
  }

  public function commune()
  {
    $flag = app()->getLocale();
    $communes = Commune::whereHas('district', function ($query) {
      $query->whereId(request()->input('district_id', 0));
    })->pluck( 'name_'.$flag, 'id');
    return response()->json($communes);
  }

  public function village()
  {
    $flag = app()->getLocale();
    $villages = Village::whereHas('commune', function ($query) {
      $query->whereId(request()->input('commune_id', 0));
    })->pluck( 'name_'.$flag, 'id');
    return response()->json($villages);
  }
}
