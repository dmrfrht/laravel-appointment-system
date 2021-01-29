<?php

namespace App\Http\Controllers\api;

use App\Appointment;
use App\Http\Controllers\Controller;
use App\WorkingHours;
use Illuminate\Http\Request;

class indexController extends Controller
{
  public function getWorkingHours($date = '')
  {
    $date = ($date == '') ? date("Y-m-d") : $date;
    $returnArray = [];
    $hours = WorkingHours::all();

    foreach ($hours as $k => $v) {
      $control = Appointment::where('date', $date)->where('workingHour', $v['id'])->where('isActive', 1)->count();
      $v['isActive'] = ($control == 0) ? true : false;
      $returnArray[] = $v;
    }

    return response()->json($returnArray);
  }

  public function appointmentStore(Request $request)
  {
    $returnArray = [];
    $returnArray['status'] = false;
    $all = $request->except('_token');

    $control = Appointment::where('date', $all['date'])->where('workingHour', $all['workingHour'])->count();

    if ($control != 0) $returnArray['message'] = 'Bu randevu tarihi doludur.';

    $create = Appointment::create($all);

    if ($create) {
      $returnArray['status'] = true;
      $returnArray['message'] = 'Randevu başarıyle kayıt edildi';
    } else {
      $returnArray['status'] = false;
      $returnArray['message'] = 'Randevu kaydı sırasında bir sorun oluştur';
    }

    return response()->json($returnArray);
  }

  public function postWorkingStore(Request $request)
  {
    $all = $request->except('_token');

    WorkingHours::query()->delete();

    foreach ($all as $k => $v) {

      foreach ($v as $key => $value) {
        WorkingHours::create([
          'day' => $k,
          'hours' => $value
        ]);
      }
    }

    return response()->json($all);
  }

  public function getWorkingList()
  {
    $returnArray = [];
    $data = WorkingHours::all();
    foreach ($data as $k => $v) {
      $returnArray[$v['day']][] = $v['hours'];
    }

    return response()->json($returnArray);
  }
}
