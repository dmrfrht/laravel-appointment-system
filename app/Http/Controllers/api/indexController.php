<?php

namespace App\Http\Controllers\api;

use App\Appointment;
use App\AppointmentNote;
use App\Http\Controllers\Controller;
use App\WorkingHours;
use Illuminate\Http\Request;

class indexController extends Controller
{
  public function getWorkingHours($date = '')
  {
    $date = ($date == '') ? date("Y-m-d") : $date;
    $day = date("l", strtotime($date));
    $returnArray = [];
    $hours = WorkingHours::where('day', $day)->get();

    foreach ($hours as $k => $v) {
      $control = Appointment::where('date', $date)
        ->where('workingHour', $v['id'])
        ->where(function ($control) {
          $control->orWhere('isActive', APPOINTMENT_DEFAULT);
          $control->orWhere('isActive', APPOINTMENT_SUCCESS);
        })
        ->count();

      $exp = explode('-', $v['hours']);
      $nowTime = date("H:i");

      $v['isActive'] = ($control == 0 and $exp[0] > $nowTime) ? true : false;
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

    $all['code'] = substr(md5(uniqid()), 0, 6);

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

  public function appointmentDetail(Request $request)
  {
    $returnArray = [];
    $returnArray['status'] = false;
    $all = $request->except('_token');
    $c = Appointment::where('code', $all['code'])->count();

    if ($all['code'] == "") {
      $returnArray['message'] = 'Lütfen kodu boş bırakmayınız';
      return response()->json($returnArray);
    }

    if ($c == 0) {
      $returnArray['message'] = 'Bu kodla eşlesen randevu bulunamadı';
      return response()->json($returnArray);
    }

    $info = Appointment::where('code', $all['code'])->get();
    $info[0]['working'] = WorkingHours::getString($info[0]['workingHour']);
    $info[0]['notification'] = ($info[0]['notificationType'] == NOTIFICATION_EMAIL) ? 'Email' : 'SMS';
    $returnArray['status'] = true;
    $returnArray['info'] = $info[0];
    $returnArray['note'] = AppointmentNote::where('appointment_id', $info[0]['id'])->orderBy('id', 'DESC')->get();

    return response()->json($returnArray);
  }
}
