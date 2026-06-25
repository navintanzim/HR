@php
if(Auth::user()->role =='505'){
$paidTotal = $leave->paid_total;
    $paidUsed = $leave->paid_used;
    $halfDays = $leave->half_day;
    $paidRemaining = $paidRemaining;

    $unpaidTotal = $leave->unpaid_total;
    $unpaidUsed = $leave->unpaid_used;
    $unpaidRemaining = $leave->unpaid_total - $leave->unpaid_used;
}

@endphp
@if(Auth::user()->role =='505')
<script>
    window.leaveBarData = {
        paidTotal: {{ $paidTotal }},
        paidUsed: {{ $paidUsed }},
        halfDays: {{ $halfDays }},
        paidRemaining: {{ $paidRemaining }},
        unpaidTotal: {{ $unpaidTotal }},
        unpaidUsed: {{ $unpaidUsed }},
        unpaidRemaining: {{ $unpaidRemaining }},
    };
</script>
@endif
<x-layout>
  <div style="background-color: #eef6ff; min-height: 100vh; padding: 1rem;">
  <s-page>

    <s-section >
      <h1 class="text-xl font-bold mb-4">Leave Info</h1>
    
        @if(Auth::user()->role =='505')
        <s-text type="strong">Leave Summary</s-text>
        
        <div class="mt-4">
            <canvas id="leaveBarChart" height="120"></canvas>
        </div>
        @endif
      @if(Auth::user()->role =='505')
      <s-stack>
        
        <s-button
          size="slim"
          variant="primary"
          onclick="window.location.href='{{ route('leaves.apply') }}'">
          Apply for Leave
        </s-button>
        <h1><s-text tone="info" type="strong" style="margin-bottom: 8px;">Your Leave Requests</s-text></h1>
      </s-stack>
      
      @else
      <s-text type="strong" style="margin-bottom: 8px;" tone="success">Pending Leave Requests</s-text> 
      @endif
       
        <s-table>

        <s-table-header-row>
          @if(Auth::user()->role =='101')
          <s-table-header>Employee</s-table-header>
          @endif
          <s-table-header>Leave Type</s-table-header>
          <s-table-header>Start Date</s-table-header>
          <s-table-header>End Date</s-table-header>
          <s-table-header>Total Days</s-table-header>
          <s-table-header>Status</s-table-header>
          @if(Auth::user()->role =='101')
          <s-table-header>Action</s-table-header>
          @endif
        </s-table-header-row>

        <s-table-body>
          @forelse($leave_request as $lr)
          <s-table-row>
            @if(Auth::user()->role =='101')
            <s-table-cell>{{ $lr->name }}</s-table-cell>
            @endif
            <s-table-cell>{{ $lr->leave_type }}</s-table-cell>
            <s-table-cell>{{ \Carbon\Carbon::parse($lr->start_date)->format('Y-m-d') }}</s-table-cell>
            <s-table-cell>{{ \Carbon\Carbon::parse($lr->end_date)->format('Y-m-d') }}</s-table-cell>
            <s-table-cell>{{ $lr->total_days }}</s-table-cell>
            <s-table-cell>{{ ucfirst($lr->status) }}</s-table-cell>
            @if(Auth::user()->role =='101')
            <s-table-cell>
              <s-button
                size="slim"
                variant="primary"
                onClick="window.location.href='{{ route('leaves.process.form', $lr->id) }}'">
                Process
              </s-button>
            </s-table-cell>
            @endif
          </s-table-row>
          @empty
          <s-table-row>
            <s-table-cell colspan="5" style="text-align: center;">No leave requests found.</s-table-cell>
          </s-table-row>
          @endforelse
        </s-table-body>
        </s-table>
      
    </s-section>
    
     @if(Auth::user()->role =='101')

    <s-section>

     
      <s-text type="strong" style="margin-bottom: 8px;" tone="success">All Employees</s-text> 
      @if ($leave)
      
      <s-table>

        <s-table-header-row>
        
          <s-table-header>Employee</s-table-header>
          <s-table-header>Paid Leave Taken</s-table-header>
          <s-table-header>Paid Leave Used</s-table-header>
          <s-table-header>Unpaid Leave Taken</s-table-header>
          <s-table-header>Unpaid Leave Used</s-table-header>
          <s-table-header>Half day leaves</s-table-header>
          <s-table-header>Action</s-table-header>
          
        </s-table-header-row>

        <s-table-body>
          @forelse($leave as $employee)
          <s-table-row>
           
            <s-table-cell>{{ $employee->name }}</s-table-cell>
            <s-table-cell>{{ $employee->paid_total }}</s-table-cell>
            <s-table-cell>{{ $employee->paid_used }}</s-table-cell>
            <s-table-cell>{{ $employee->unpaid_total }}</s-table-cell>
            <s-table-cell>{{ $employee->unpaid_used }}</s-table-cell>
            <s-table-cell>{{ $employee->half_day }}</s-table-cell>
            <s-table-cell>
              <s-button
                size="slim"
                variant="primary"
                onClick="window.location.href='{{ route('leaves.employee', $employee->employee_id) }}'">
                View
              </s-button>
            </s-table-cell>
           
          </s-table-row>
          @empty
          <s-table-row>
            <s-table-cell colspan="5" style="text-align: center;">No employee records found.</s-table-cell>
          </s-table-row>
          @endforelse
        </s-table-body>
      </s-table>
      @endif
      
     

      

    </s-section>
     @endif

  </s-page>
  </div>
</x-layout>
