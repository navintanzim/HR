<?php

namespace App\Modules\Leaves\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\Auth;


class LeavesController extends Controller
{
    public function index()
    {
        $team_leaves = null;
        $paidRemaining = null;
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

            $leave = LeaveBalance::leftjoin('users as employee', 'employee.employee_id', 'leave_balances.employee_id')->get([
                'employee.employee_id',
                'employee.name as name',
                'paid_total',
                'paid_used',
                'half_day',
                'unpaid_total',
                'unpaid_used'
            ]);

            $team_leaves = LeaveRequest::leftjoin('users as employee', 'employee.employee_id', 'leave_requests.employee_id')
                ->get([
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
            $leave = LeaveBalance::where('employee_id', Auth::user()->employee_id)->first([
                'paid_total',
                'paid_used',
                'half_day',
                'unpaid_total',
                'unpaid_used'
            ]);
            if ($leave) {
                $halfDayDeduction = intdiv($leave->half_day, 2);
                $paidRemaining = $leave->paid_total - $leave->paid_used - $halfDayDeduction;
            }
        }




        return view('leaves::index', compact('leave', 'paidRemaining', 'leave_request', 'team_leaves'));
    }

    public function create()
    {

        return view('leaves::apply');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'leave_type' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'reason'     => 'nullable|string|max:500',
        ]);

        $start = Carbon::parse($request->input('start_date'));
        if ($data['leave_type'] == 'half_day') {
            $end = $start;
            $time = $request->input('time');
            $totalDays = 1;
        } else {
            $end = Carbon::parse($request->input('end_date'));
            $time = null;
            $totalDays = 0;
            $weekendDays = [5, 6];
            $period = CarbonPeriod::create($start, $end);

            foreach ($period as $date) {
                if (in_array($date->dayOfWeekIso, $weekendDays)) {
                    continue;
                }

                $totalDays++;
            }
        }

        LeaveRequest::create([
            'employee_id' => Auth::user()->employee_id,
            'leave_type'  => $data['leave_type'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'] ?? $data['start_date'],
            'total_days'      => $totalDays ?? null,
            'time'      => $time,
            'reason'      => $data['reason'],
            'status'      => 'Pending',
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Leave application submitted.');
    }

    public function showProcessForm($id)
    {

        $leave = LeaveRequest::leftJoin('users', 'leave_requests.employee_id', '=', 'users.employee_id')
            ->select(
                'leave_requests.*',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->where('leave_requests.id', $id)
            ->first();
        return view('leaves::process', compact('leave'));
    }

    public function process(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $data = $request->validate([
            'status' => 'required|in:Approved,Rejected',
            'admin_note' => 'nullable|string|max:500',
        ]);
        $data['decided_at'] = now();
        $data['decided_by'] = Auth::user()->employee_id;
        $leave->update($data);

        if ($request->status == 'Approved') {
            $leave_balance = LeaveBalance::where('employee_id', $leave->employee_id)->first();

            if ($leave->leave_type == 'full_day') {
                if ($leave_balance->paid_total > $leave_balance->paid_used) {
                    $leave_balance->paid_used = $leave_balance->paid_used + $leave->total_days;
                } else {
                    $leave_balance->unpaid_used =  $leave_balance->unpaid_used + $leave->total_days;
                }
            } else {
                $leave_balance->half_day = $leave_balance->half_day + 1;
            }

            $leave_balance->save();
        }


        return redirect()->route('dashboard')->with('success', 'Leave request processed successfully.');
    }

    public function employeeData($id)
    {

        $team_leaves = LeaveRequest::leftjoin('users as employee', 'employee.employee_id', 'leave_requests.employee_id')
            ->where('leave_requests.employee_id', $id)
            ->get([
                'leave_requests.id',
                'employee.employee_id',
                'employee.name as name',
                'leave_type',
                'start_date',
                'end_date',
                'total_days',
                'status'
            ]);
        return view('leaves::employee', compact('team_leaves'));
    }
}
