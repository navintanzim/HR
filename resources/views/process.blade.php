<x-layout>
    <s-page>
        <s-section>
            <h2>Process Leave Request</h2>

            <p><strong>Employee:</strong> {{ $leave->user_name }}</p>
            <p><strong>Contact:</strong> {{ $leave->user_email }}</p>
            <p><strong>Leave Type:</strong>  @if($leave->leave_type=='full_day') Full day @else Half day @endif</p>
            <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($leave->start_date)->format('Y-m-d') }}</p>
            <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($leave->end_date)->format('Y-m-d') }}</p>

            <form method="POST" action="{{ route('leave.process', $leave->id) }}">
                @csrf
                <s-select name="status" label="Action">
                    <s-option value="Approved">Approve</s-option>
                    <s-option value="Rejected">Reject</s-option>
                </s-select>

                <s-text-field name="admin_note" label="Admin Note" multiline style="margin-top:8px;"></s-text-field>

                <s-button type="submit" size="slim" variant="primary" style="margin-top:12px;">
                    Submit
                </s-button>
            </form>
        </s-section>
    </s-page>
</x-layout>
