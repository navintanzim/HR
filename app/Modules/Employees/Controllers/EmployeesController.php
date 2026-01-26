<?php

namespace App\Modules\Employees\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\Auth;
use App\Modules\Settings\Models\Settings;

class EmployeesController extends Controller
{
    public function index()
    {

        $timezone = Settings::where('key', 'Timezone')->first()->value;
        $now = Carbon::now($timezone);

        $currentTime = $now->format('H:i');
        $attendanceWindows = Settings::where('key', 'attendance_windows')->first()->value;
        $checkInLabel = null;

        foreach ($attendanceWindows as $label => $window) {
            if (isset($window['before']) && $currentTime < $window['before']) {
                $checkInLabel = "Check in, " . ucfirst(str_replace('_', ' ', $label));
                break;
            }

            if (isset($window['from'], $window['to']) && $currentTime >= $window['from'] && $currentTime <= $window['to']) {
                $checkInLabel = "Check in, " . ucfirst(str_replace('_', ' ', $label));
                break;
            }

            if (isset($window['after']) && $currentTime > $window['after']) {
                $checkInLabel = null;
            }
        }
        
        $startOfMonth = Carbon::now()->subMonth()->startOfDay();
        $startOfWeek = Carbon::now()->subWeek()->startOfDay();
        $attendance_monthly = Attendance::where('employee_id', Auth::user()->employee_id)
        ->where('created_at', '>=', $startOfMonth)
        ->get();
        $attendance_weekly = Attendance::where('employee_id', Auth::user()->employee_id)
        ->where('created_at', '>=', $startOfWeek)
        ->get();

        $attendance = Attendance::where('employee_id', Auth::user()->employee_id)->get();
        $employee_attendance = Attendance::get();
        
        return view('employees::index', compact('attendance','checkInLabel','employee_attendance','attendance_monthly','attendance_weekly'));
    }
}
