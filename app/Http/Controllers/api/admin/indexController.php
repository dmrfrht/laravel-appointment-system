<?php

namespace App\Http\Controllers\api\admin;

use App\Appointment;
use App\Http\Controllers\Controller;
use App\WorkingHours;
use Illuminate\Http\Request;

class indexController extends Controller
{
  public function all()
  {
    $returnArray = [];

    /** waiting */
    $returnArray['waiting_list'] = Appointment::where('isActive', 0)->orderBy('workingHour', 'ASC')->paginate(6);
    $returnArray['waiting_list']->getCollection()->transform(function ($value) {
      $value['working'] = WorkingHours::getString($value['workingHour']);
      return $value;
    });

    /** cancel */
    $returnArray['cancel_list'] = Appointment::where('isActive', 2)->orderBy('workingHour', 'ASC')->paginate(6);
    $returnArray['cancel_list']->getCollection()->transform(function ($value) {
      $value['working'] = WorkingHours::getString($value['workingHour']);
      return $value;
    });

    /** list */
    $returnArray['list'] = Appointment::where('isActive', 1)->where('date', '>', date('Y-m-d'))->orderBy('workingHour', 'ASC')->paginate(6);
    $returnArray['list']->getCollection()->transform(function ($value) {
      $value['working'] = WorkingHours::getString($value['workingHour']);
      return $value;
    });

    /** last */
    $returnArray['last_list'] = Appointment::where('date', '<', date('Y-m-d'))->orderBy('workingHour', 'ASC')->paginate(6);
    $returnArray['last_list']->getCollection()->transform(function ($value) {
      $value['working'] = WorkingHours::getString($value['workingHour']);
      return $value;
    });

    /** today */
    $returnArray['today_list'] = Appointment::where('isActive', 1)->where('date', date('Y-m-d'))->orderBy('workingHour', 'ASC')->paginate(6);
    $returnArray['today_list']->getCollection()->transform(function ($value) {
      $value['working'] = WorkingHours::getString($value['workingHour']);
      return $value;
    });

    return response()->json($returnArray);
  }

  public function process(Request $request)
  {
    $all = $request->except('_token');
    Appointment::where('id', $all['id'])->update(['isActive' => $all['type']]);

    return response()->json(["status" => true]);
  }
}
