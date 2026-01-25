<x-layout>
  

  <s-page>
    <s-section>

      @if (session('success'))
      <s-banner tone="success">
        {{ session('success') }}
      </s-banner>
      @endif

      @if (session('error'))
      <s-banner tone="critical">
        {{ session('error') }}
      </s-banner>
      @endif

      <h1>Welcome, {{ Auth::user()->name }}!</h1>
      <p>This is your dashboard.</p>

      @if(Auth::user()->role =='505')

      <s-button
        size="slim"
        variant="primary"
        onclick="window.location.href='{{ route('leave.apply') }}'">
        Apply for Leave
      </s-button>

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


      @endif




      <s-section>
        @if(Auth::user()->role =='505')
        <s-text type="strong" style="margin-bottom: 8px;">Your Leave Requests</s-text>
        @else
        <s-text type="strong" style="margin-bottom: 8px;">Pending Leave Requests</s-text>
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
                  onClick="window.location.href='{{ route('leave.process.form', $lr->id) }}'">
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


      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
      </form>
    </s-section>
  </s-page>


</x-layout>