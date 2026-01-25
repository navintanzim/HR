@php
$presentCount = $attendance->where('status', '!=', 'Absent')->count();
$absentCount = $attendance->where('status', 'Absent')->count();
@endphp

<x-layout>
  <s-page>
    <s-section>
      <h1 class="text-xl font-bold mb-4">Employee Info</h1>

      @if(Auth::user()->role =='505')


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
      <s-text type="strong">Too late for attendance checkin</s-text>
      @endif

      @else

      <s-table>
        <s-table-header-row>
          
            <s-table-header>Employee ID</s-table-header>
            <s-table-header>Date</s-table-header>
            <s-table-header>Check-in Time</s-table-header>
            <s-table-header>Status</s-table-header>
            <s-table-header>Source</s-table-header>
          
        </s-table-header-row>

        <s-table-body>
          @forelse ($employee_attendance as $attendance)
          <s-table-row>
            <s-table-cell>{{ $attendance->employee_id }}</s-table-cell>
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
</x-layout>