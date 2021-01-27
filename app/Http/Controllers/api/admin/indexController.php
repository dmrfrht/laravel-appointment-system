<?php

namespace App\Http\Controllers\api\admin;

use App\Appointment;
use App\Http\Controllers\Controller;
use App\WorkingHours;
use Illuminate\Http\Request;

class indexController extends Controller
{
  public function getList()
  {
    $data = Appointment::orderBy('created_at', 'DESC')->paginate(1);
    $data->getCollection()->transform(function ($value) {
      $value['working'] = WorkingHours::getString($value['workingHour']);
      return $value;
    });


    return response()->json($data);
  }
}
