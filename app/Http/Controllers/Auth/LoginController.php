<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\Settings\Models\Settings;

use App\Models\Attendance;
use Carbon\Carbon;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        
        return view('auth.login');
    }
    

    public function login(Request $request)
    {
        $timezone = Settings::where('key', 'Timezone')->first()->value;
        $now = Carbon::now($timezone);
        $settings = Settings::all()->pluck('value', 'key')->toArray();
        $credentials = $request->only('email', 'password');
        $absentTimeStr = $settings['attendance_windows']['absent']['after'];
        $absentTime = Carbon::createFromFormat('H:i', $absentTimeStr, $timezone)
            ->setDate($now->year, $now->month, $now->day);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (Auth::user()->role == '505' && $now->greaterThan($absentTime)) {
                $today_attendance = Attendance::where('date', now()->startOfDay())
                    ->where('employee_id', Auth::user()->employee_id)
                    ->first();
                if ($today_attendance === null) {
                    Attendance::create([
                        'employee_id' => Auth::user()->employee_id,
                        'date'  => now()->startOfDay(),
                        'check_in_time'  => now(),
                        'status'    => 'Absent',
                        'source_ip'      => 'App',
                    ]);
                }
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    
}
