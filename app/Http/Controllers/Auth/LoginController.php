<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Modules\Settings\Models\Settings;
use App\Models\LeaveBalance;
use App\Models\Attendance;
use Carbon\Carbon;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        
        return view('auth.login');
    }
    public function showRegisterForm()
    {
        
        return view('auth.register');
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

    public function register(Request $request)
    {
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', 
            'role' => 'required|string|max:50',
        ]);
        

        if($data['role']=="admin"){
            $role= '101';
        }else{
            $role= '505';
        }
        $lastIndex = User::latest('id')->value('id') ?? 0;
        DB::transaction(function () use ($role, $lastIndex,$data) {
            $user = User::create([
                'employee_id' => $role . ($lastIndex + 1),
                'name' => $data['name'],
                'email' => $data['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($data['password']),
                'role' => $role,
                'created_at' => now(),
            ]);

            if ($role === '505') {
                $leave = Settings::where('key', 'leave_policy')->first()->value;
                 LeaveBalance::create([
                    'employee_id' => $role . ($lastIndex + 1),
                    'year' => now()->year,
                    'paid_total' => $leave['paid_leave'],
                    'paid_used' => 0,
                    'unpaid_total' => $leave['unpaid_leave'],
                    'unpaid_used' => 0,
                    'created_at' => now(),
                ]);
            }

             Auth::login($user);
        });
        
       

        return redirect('/dashboard')->with('status', 'User registered successfully!');
    }
}
