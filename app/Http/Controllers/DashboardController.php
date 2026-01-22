<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {


        $leave = LeaveBalance::where('employee_id', Auth::user()->employee_id)->first([
            'paid_total',
            'paid_used',
            'unpaid_total',
            'unpaid_used'
        ]);

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
        } else {
            $leave_request =  LeaveRequest::where('employee_id', Auth::user()->employee_id)->get([
                'leave_type',
                'start_date',
                'end_date',
                'total_days',
                'status'
            ]);
        }


        return view('dashboard', compact('leave', 'leave_request'));
    }

     public function Checkin(Request $request)
    {

        $attendance = Attendance::where('employee_id',Auth::user()->employee_id)
                    ->where('date',now()->startOfDay())->first();
        if($attendance){
            return redirect()->route('dashboard')->with('error', ' Checked In already today.');
        }

        $now = Carbon::now('Asia/Dhaka');
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
}
