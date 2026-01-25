@php
$presentCount = $attendance->where('status', '!=', 'Absent')->count();
$absentCount = $attendance->where('status', 'Absent')->count();
@endphp

<x-layout>
    <s-page>
        <s-section>
            <h1 class="text-xl font-bold mb-4">Employee Info</h1>

            

      @if ($leave)
      <s-stack>
        <s-text type="strong">Total attendance: {{ $presentCount }}</s-text>
        <s-text type="strong">Total absent days: {{ $absentCount }}</s-text>


        <s-text type="strong">Paid total: {{ $leave->paid_total }}</s-text>
        <s-text type="strong">Paid used: {{ $leave->paid_used }}</s-text>
        <s-text type="strong">Half days: {{ $leave->half_day }}</s-text>
        <s-text type="strong">Paid Remaining: {{ $paidRemaining}}</s-text>
        <s-text type="strong">Unpaid total: {{ $leave->unpaid_total }}</s-text>
        <s-text type="strong">Unpaid used: {{ $leave->unpaid_used }}</s-text>
        <s-text type="strong">Unpaid Remaining: {{ $leave->unpaid_total - $leave->unpaid_used}}</s-text>
      </s-stack>
      @endif

        </s-section>
    </s-page>
</x-layout>
