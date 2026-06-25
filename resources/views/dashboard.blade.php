<x-layout>


  <div style="background-color: #eef6ff; min-height: 100vh; padding: 1rem;">
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


      <s-section>
        @if(Auth::user()->role =='505')
        <s-stack>
          <s-text type="strong" tone="info" style="margin-bottom: 8px;">Your Pending Leave Requests: {{count($leave_request)}}</s-text> &nbsp;
          <s-button
            size="slim"
            variant="primary"
            onclick="window.location.href='{{ route('leaves.apply') }}'">
            Apply for Leave
          </s-button> &nbsp;
        </s-stack>

        @else
        <s-text type="strong" style="margin-bottom: 8px;">Pending Leave Requests: {{count($leave_request)}}</s-text>

        <div style="margin: 10px;">

        <s-table>
        <s-table-header-row>

          <s-table-header>Employee ID</s-table-header>
          <s-table-header>Employee Name</s-table-header>
          <s-table-header>Email</s-table-header>
          <s-table-header>Action</s-table-header>

        </s-table-header-row>

        <s-table-body>
          @forelse ($employees as $employee)
          <s-table-row>
            <s-table-cell>{{ $employee->employee_id }}</s-table-cell>
            <s-table-cell>{{ $employee->name }}</s-table-cell>
            <s-table-cell>{{ $employee->email }}</s-table-cell>
            <s-table-cell>

            <s-button
              size="slim"
              variant="primary"
              onClick="window.location.href='{{ route('leaves.employee', $employee->employee_id) }}'">
               View Leave
            </s-button>
            <s-button
              size="slim"
              variant="primary"
              onclick="window.location.href='{{ route('admin.attendance',$employee->employee_id) }}'">
              View Attendance
            </s-button>

            </s-table-cell>
          </s-table-row>
          @empty
          <s-table-row>
            <s-table-cell colspan="4">
              <s-text>No records found.</s-text>
            </s-table-cell>
          </s-table-row>
          @endforelse
        </s-table-body>
      </s-table>

        </div>

        @endif

      </s-section>
    </s-section>
  </s-page>
  </div>


</x-layout>
