<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Models\User;
use App\Modules\Settings\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function index()
    {
        $employees = null;
        if (Auth::user()->role == '101') {
            $leave_request =  LeaveRequest::leftjoin('users as employee', 'employee.employee_id', 'leave_requests.employee_id')
                ->where('status', 'Pending')->get([
                'leave_requests.id',
                'employee.employee_id',
                'employee.name as name',
                'leave_type',
                'start_date',
                'end_date',
                'total_days',
                'status'
            ]);

            $employees = User::where('role','505')->get();
        } else {
            
            $leave_request =  LeaveRequest::where('employee_id', Auth::user()->employee_id)->where('status', 'Pending')->get([
                'leave_type',
                'start_date',
                'end_date',
                'total_days',
                'status'
            ]);
        }


        return view('dashboard', compact( 'leave_request','employees'));
    }

     public function Checkin(Request $request)
    {
        $timezone = Settings::where('key', 'Timezone')->first()->value;
        $attendance = Attendance::where('employee_id',Auth::user()->employee_id)
                    ->where('date',now()->startOfDay())->first();
        if($attendance){
            return redirect()->route('dashboard')->with('error', ' Checked In already today.');
        }

        $now = Carbon::now($timezone);
        $currentTime = $now->format('H:i');

        if ($currentTime < '09:00') {
            $checkInLabel = 'Check in, Early';
        } elseif ($currentTime >= '09:00' && $currentTime <= '09:05') {
            $checkInLabel = 'Check in, On time';
        } elseif ($currentTime >= '09:06' && $currentTime <= '09:15') {
            $checkInLabel = 'Check in, Late';
        } elseif ($currentTime >= '09:16' && $currentTime <= '09:30') {
            $checkInLabel = 'Check in, Very late';
        } else {
            $checkInLabel = null;
        }

        $string_to_remove = "Check in, ";
        $status = str_replace($string_to_remove, "", $checkInLabel);
        
        Attendance::create([
            'employee_id' => Auth::user()->employee_id,
            'date'  => now()->startOfDay(),
            'check_in_time'  => now(),
            'status'    => $status,
            'source_ip'      => 'App',
        ]);
        

        return redirect()->route('dashboard')->with('success', ' Checked In successfully.');
    }

    public function employeeAttendanceData($employee)
    {
        
        $attendance = Attendance::where('employee_id', $employee)->get();
        $startOfMonth = Carbon::now()->subMonth()->startOfDay();
        $startOfWeek = Carbon::now()->subWeek()->startOfDay();
        $attendance_monthly = Attendance::where('employee_id',  $employee)
        ->where('created_at', '>=', $startOfMonth)
        ->get();
        $attendance_weekly = Attendance::where('employee_id',  $employee)
        ->where('created_at', '>=', $startOfWeek)
        ->get();
        return view('attendance_charts', compact('attendance','attendance_monthly','attendance_weekly'));
    }
}
