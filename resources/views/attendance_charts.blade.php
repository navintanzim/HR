@php
$early = $attendance->where('status', 'Early')->count();
$on_time = $attendance->where('status', 'On time')->count();
$late = $attendance->where('status', 'Late')->count();
$very_late = $attendance->where('status', 'Very late')->count();
$absentCount = $attendance->where('status', 'Absent')->count();

$early_attendance_monthly = $attendance_monthly->where('status', 'Early')->count();
$on_time_attendance_monthly = $attendance_monthly->where('status', 'On time')->count();
$late_attendance_monthly = $attendance_monthly->where('status', 'Late')->count();
$very_late_attendance_monthly = $attendance_monthly->where('status', 'Very late')->count();
$absent_attendance_monthly = $attendance_monthly->where('status', 'Absent')->count();

$early_attendance_weekly = $attendance_weekly->where('status', 'Early')->count();
$on_time_attendance_weekly = $attendance_weekly->where('status', 'On time')->count();
$late_attendance_weekly = $attendance_weekly->where('status', 'Late')->count();
$very_late_attendance_weekly = $attendance_weekly->where('status', 'Very late')->count();
$absent_attendance_weekly = $attendance_weekly->where('status', 'Absent')->count();

@endphp
<script>
    window.attendanceData = {
        early: {{ $early }},
        onTime: {{ $on_time }},
        late: {{ $late }},
        veryLate: {{ $very_late }},
        absent: {{ $absentCount }},
    };

      window.attendanceMonthlyData = {
        early: {{ $early_attendance_monthly }},
        onTime: {{ $on_time_attendance_monthly }},
        late: {{ $late_attendance_monthly }},
        veryLate: {{ $very_late_attendance_monthly }},
        absent: {{ $absent_attendance_monthly }},
    };

      window.attendanceWeeklyData = {
        early: {{ $early_attendance_weekly }},
        onTime: {{ $on_time_attendance_weekly }},
        late: {{ $late_attendance_weekly }},
        veryLate: {{ $very_late_attendance_weekly }},
        absent: {{ $absent_attendance_weekly }},
    };
</script>
<x-layout>
  <s-page>
    <s-section>
      <h1 class="text-xl font-bold mb-4">Employee Attendance Info for this employee</h1>

      @if(Auth::user()->role =='101')

      <s-section>
    <s-text type="strong">Attendance Summary (Toggle buttons to view more charts)</s-text>

    <!-- Dropdown buttons -->
    <div class="mt-2 flex gap-2">
        <s-button size="slim" variant="primary" id="toggleLifetimeBtn">Lifetime</s-button>
        <s-button size="slim" variant="primary" id="toggleWeeklyBtn">Weekly</s-button>
        <s-button size="slim" variant="primary" id="toggleMonthlyBtn">Monthly</s-button>
    </div>

    <div id="weeklyChartContainer" class="mt-4 max-w-lg mx-auto " style="display:none;">
        <s-text type="strong">Weekly Attendance Summary (Last 7 Days)</s-text>
        <canvas id="attendanceWeeklyBarChart" height="120"></canvas>
    </div>
    <div id="monthlyChartContainer" class="mt-4 max-w-lg mx-auto" style="display:show;">
        <s-text type="strong">Monthly Attendance Summary (Last 30 Days)</s-text>
        <canvas id="attendanceMonthlyBarChart" height="120"></canvas>
    </div>
    <div id="lifetimeChartContainer" class="mt-4 max-w-lg mx-auto" style="display:none;">
        <s-text type="strong">Attendance Summary (Lifetime)</s-text>
        <canvas id="attendanceBarChart" height="120"></canvas>
    </div>

   
</s-section>

      

      @endif


    </s-section>
  </s-page>
</x-layout>