<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Settings\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'employee_id' => '1011',
            'name' => 'HR',
            'email' => 'tanzim.klinkode@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('klincode'),
            'role' => '101',
            'status' => 'active',
        ]);
        Settings::create([
            'key' => 'Timezone',
            'value' => 'Asia/Dhaka',
        ]);
        Settings::create([
            'key' => 'office_hours',
            'value' => ['start_time' => '09:00'],
        ]);
        Settings::create([
            'key' => 'leave_policy',
            'value' => ['paid_leave' => '14','unpaid_leave'=> '5'],
        ]);
        Settings::create([
            'key' => 'attendance_windows',
            'value' => ['early' => ['before' => '09:00'],
                        'on_time'=> ['from' => '09:00', 'to' => '09:05'],
                        'late' => ['from' => '09:06', 'to' => '09:15'],
                        'very_late' => ['from' => '09:16', 'to' => '09:30'],
                        'absent' => ['after' => '09:30']],
        ]);
    }
}
