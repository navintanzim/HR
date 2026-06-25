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
  <div style="background-color: #eef6ff; min-height: 100vh; padding: 1rem;">
  <s-page>
    <s-section>
      <h1 class="text-xl font-bold mb-4">Employee Attendance Info</h1>

      @if(Auth::user()->role =='505')

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



      @if($checkInLabel)
      <form id="checkin-form" method="POST" action="{{ route('checkin') }}" style="display: inline;">
        @csrf
        <s-button
          size="slim"
          variant="primary"
          type="submit">
          {{ $checkInLabel }}
        </s-button>
      </form>
      @elseif($checkInLabel==null)
      <s-text tone="critical" type="strong">Too late for attendance checkin</s-text>
      @endif

      @else

      <s-badge>Todays attendances</s-badge>
      <s-table>
        <s-table-header-row>

          <s-table-header>Employee ID</s-table-header>
          <s-table-header>Employee Name</s-table-header>
          <s-table-header>Date</s-table-header>
          <s-table-header>Check-in Time</s-table-header>
          <s-table-header>Status</s-table-header>
          <s-table-header>Source</s-table-header>

        </s-table-header-row>

        <s-table-body>
          @forelse ($employee_attendance as $attendance)
          <s-table-row>
            <s-table-cell>{{ $attendance->employee_id }}</s-table-cell>
            <s-table-cell>{{ $attendance->name }}</s-table-cell>
            <s-table-cell>{{ $attendance->date }}</s-table-cell>
            <s-table-cell>{{ $attendance->check_in_time }}</s-table-cell>
            <s-table-cell>{{ $attendance->status }}</s-table-cell>
            <s-table-cell>{{ $attendance->source_ip }}</s-table-cell>
          </s-table-row>
          @empty
          <s-table-row>
            <s-table-cell colspan="5">
              <s-text>No attendance records found.</s-text>
            </s-table-cell>
          </s-table-row>
          @endforelse
        </s-table-body>
      </s-table>

      @endif


    </s-section>
  </s-page>
  </div>
</x-layout>
