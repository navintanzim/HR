<?php

namespace App\Modules\Leaves\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\Auth;
use App\Mail\LeaveDecisionMail;
use App\Mail\LeaveRequestMail;
use App\Models\User;
use App\Modules\Leaves\Models\Logs;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class LeavesController extends Controller
{
    public function index()
    {
        $team_leaves = null;
        $paidRemaining = null;
        if (Auth::user()->role == '101') {
            $leave_request =  LeaveRequest::leftjoin('users as employee', 'employee.employee_id', 'leave_requests.employee_id')
                ->where('leave_requests.status', 'Pending')->get([
                    'leave_requests.id',
                    'employee.employee_id',
                    'employee.name as name',
                    'leave_type',
                    'start_date',
                    'end_date',
                    'total_days',
                    'leave_requests.status'
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
                    'leave_requests.status'
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
            'reason'     => 'required|string|max:500',
        ]);

        $start = Carbon::parse($request->input('start_date'));
        if ($data['leave_type'] == 'half_day') {
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

        $leave = LeaveRequest::create([
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

        $employee_mail = Auth::user()->email;
        $admins = User::where('role', '101')->get();

        try {
            foreach ($admins as $admin) {
                Mail::to($admin->email)
                    ->send(new LeaveRequestMail($leave, $employee_mail));
            }
        } catch (\Exception $e) {
            Logs::create([
                'error' => $e->getMessage(),
                'source' => 'LeavesController.store',
            ]);
            
        }

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
        $user = User::where('employee_id', $leave->employee_id)->first();
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

        try {

            Mail::to($user->email)
                ->send(new LeaveDecisionMail($leave, $request->status));
        } catch (\Exception $e) {
            Logs::create([
                'error' => $e->getMessage(),
                'source' => 'LeavesController.process',
            ]);
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
                'reason',
                'leave_requests.status'
            ]);
        $pending_leaves = LeaveRequest::leftjoin('users as employee', 'employee.employee_id', 'leave_requests.employee_id')
            ->where('leave_requests.employee_id', $id)
            ->where('leave_requests.status', 'Pending')
            ->get([
                'leave_requests.id',
                'employee.employee_id',
                'employee.name as name',
                'leave_type',
                'start_date',
                'end_date',
                'total_days',
                'reason',
                'leave_requests.status'
            ]);
        return view('leaves::employee', compact('team_leaves', 'id', 'pending_leaves'));
    }

    public function leaveCount(Request $request, $id)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ]);

        $from = Carbon::parse($request->from_date)->startOfDay();
        $to   = Carbon::parse($request->to_date)->endOfDay();

        $full_count = LeaveRequest::where('employee_id', $id)
            ->where('status', 'Approved')
            ->where('leave_type', 'full_day')
            ->where(function ($q) use ($from, $to) {
                $q->whereDate('start_date', '<=', $to)
                    ->whereDate('end_date', '>=', $from);
            })
            ->sum('total_days');
        $half_count = LeaveRequest::where('employee_id', $id)
            ->where('status', 'Approved')
            ->where('leave_type', 'half_day')
            ->where(function ($q) use ($from, $to) {
                $q->whereDate('start_date', '<=', $to)
                    ->whereDate('end_date', '>=', $from);
            })
            ->sum('total_days');

        $count = $full_count + floor($half_count / 2);

        return response()->json([
            'count' => $count,
        ]);
    }
}
