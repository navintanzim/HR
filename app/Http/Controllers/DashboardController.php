<?php

namespace App\Http\Controllers;

use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
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
}
