<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Attendance;
use App\Modules\Settings\Models\Settings;
use Carbon\Carbon;

class MarkAbsent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark absent employees automatically at configured time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = Settings::all()->pluck('value', 'key')->toArray();
        $absentTimeStr = $settings['attendance_windows']['absent']['after'];
        $absentTime = Carbon::createFromFormat('H:i', $absentTimeStr, 'Asia/Dhaka')->startOfDay()->addHours(
            (int) explode(':', $absentTimeStr)[0]
        )->addMinutes(
            (int) explode(':', $absentTimeStr)[1]
        );
        $absentTime->addMinute();
        $timezone = Settings::where('key', 'Timezone')->first()->value;
        $today = now($timezone)->startOfDay();
        $employees = User::where('role', '!=', '101')->get();
        foreach ($employees as $employee) {
            $exists = Attendance::where('employee_id', $employee->employee_id)
                ->whereDate('date', $today)
                ->exists();

            if (!$exists) {
                Attendance::create([
                    'employee_id' => $employee->employee_id,
                    'date'        => $today,
                    'check_in_time' => null,
                    'status'      => 'Absent',
                    'source_ip'   => 'App',
                ]);
            }
        }

        $this->info('Absent marking completed.');
    }
}
