<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Modules\Settings\Models\Settings;
use Illuminate\Console\Scheduling\Schedule;

class Kernel extends HttpKernel
{

    protected $commands = [
        \App\Console\Commands\MarkAbsent::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $settings = Settings::all()->pluck('value', 'key')->toArray();
        $absentTimeStr = $settings['attendance_windows']['absent']['after']; // "09:30"

        [$hour, $minute] = explode(':', $absentTimeStr);
        $minute = (int)$minute + 1; // +1 minute

        $schedule->command('app:mark-absent')
            ->dailyAt(sprintf('%02d:%02d', $hour, $minute));


        //some samples

        // $schedule->command('status:change')->cron('* * * * *');
        // $schedule->command('lead:notify')->daily();

        // $schedule->command('lead:notify')->everyFiveMinutes();
        // $schedule->command('email:notify')
        //            ->everyThirtyMinutes();
        // $schedule->command('email:queue')
        //            ->everyThirtyMinutes();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
