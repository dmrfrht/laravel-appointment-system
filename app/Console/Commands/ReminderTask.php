<?php

namespace App\Console\Commands;

use App\Appointment;
use App\WorkingHours;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use function Symfony\Component\Translation\t;

class ReminderTask extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'Reminder:Start';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $date = date('Y-m-d');
    $nextDate = date('Y-m-d', strtotime('+1 day', time()));

    $list = Appointment::whereIn('date', [$date, $nextDate])
      ->where('isActive', APPOINTMENT_SUCCESS)
      ->where('isSend', REMINDER_DEFAULT)
      ->get();

    foreach ($list as $k => $v) {
      if ($v['notificationType'] == NOTIFICATION_EMAIL) {
        $data = [
          'id' => $v['id'],
          'name' => $v['full_name'],
          'email' => $v['email'],
          'date' => $v['date'],
          'time' => WorkingHours::getString($v['workingHour']),
        ];

        try {
          Mail::send('email', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name'])->subject('Randevu Hatırlatma');
            $message->from('randevusistemi.laravelvue@gmail.com', 'Randevu Sistemi');
          });

          Appointment::where('id', $v['id'])->update(['isSend' => REMINDER_SUCCESS]);
        } catch (\Exception $e) {
          dd($e->getMessage());
        }
      }
    }

  }
}
