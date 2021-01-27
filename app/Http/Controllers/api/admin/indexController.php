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
    $data = Appointment::where('isActive', 1)->where('date', '>', date('Y-m-d'))->orderBy('workingHour', 'ASC')->paginate(3);
    $data->getCollection()->transform(function ($value) {
      $value['working'] = WorkingHours::getString($value['workingHour']);
      return $value;
    });


    return response()->json($data);
  }

  public function getTodayList()
  {
    $data = Appointment::where('isActive', 1)->where('date', date('Y-m-d'))->orderBy('workingHour', 'ASC')->paginate(3);
    $data->getCollection()->transform(function ($value) {
      $value['working'] = WorkingHours::getString($value['workingHour']);
      return $value;
    });


    return response()->json($data);
  }

  public function getLastList()
  {
    $data = Appointment::where('date', '<', date('Y-m-d'))->orderBy('workingHour', 'ASC')->paginate(3);
    $data->getCollection()->transform(function ($value) {
      $value['working'] = WorkingHours::getString($value['workingHour']);
      return $value;
    });


    return response()->json($data);
  }

  public function getWaitingList()
  {
    $data = Appointment::where('isActive', 0)->orderBy('workingHour', 'ASC')->paginate(3);
    $data->getCollection()->transform(function ($value) {
      $value['working'] = WorkingHours::getString($value['workingHour']);
      return $value;
    });


    return response()->json($data);
  }

  public function getCancelList()
  {
    $data = Appointment::where('isActive', 2)->orderBy('workingHour', 'ASC')->paginate(3);
    $data->getCollection()->transform(function ($value) {
      $value['working'] = WorkingHours::getString($value['workingHour']);
      return $value;
    });


    return response()->json($data);
  }

  public function process(Request $request)
  {
    $all = $request->except('_token');
    Appointment::where('id', $all['id'])->update(['isActive' => $all['type']]);

    return response()->json(["status" => true]);
  }
}
