<?php

namespace App\Modules\Employees\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
{
    public function index()
    {
        $leave = LeaveBalance::where('employee_id', Auth::user()->employee_id)->first([
            'paid_total',
            'paid_used',
            'half_day',
            'unpaid_total',
            'unpaid_used'
        ]);

        $attendance = Attendance::where('employee_id', Auth::user()->employee_id)->get();

        if ($leave) {
            $halfDayDeduction = intdiv($leave->half_day, 2);
            $paidRemaining = $leave->paid_total - $leave->paid_used - $halfDayDeduction;
        }
        return view('employees::index', compact('leave', 'paidRemaining', 'attendance'));
    }
}
