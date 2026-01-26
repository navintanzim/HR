<script>
async function generateLeaveCount() {
    const from = document.getElementById('fromDate').value;
    const to   = document.getElementById('toDate').value;

    if (!from || !to) {
        alert('Please select both dates');
        return;
    }

    const response = await fetch(
        `/leaves/{{ $id }}/leave-count?from_date=${from}&to_date=${to}`
    );

    const data = await response.json();

    document.getElementById('leaveCountResult').textContent =
        `Total leaves taken: ${data.count}`;
}
</script>



<x-layout>
    <s-page>

        <s-section>
            @if(Auth::user()->role =='101')
            <s-text type="strong" style="margin-bottom: 8px;" tone="success">All Leave Requests For this Employee</s-text>
            <s-table>

                <s-table-header-row>

                    <s-table-header>Leave Type</s-table-header>
                    <s-table-header>Start Date</s-table-header>
                    <s-table-header>End Date</s-table-header>
                    <s-table-header>Total Days</s-table-header>
                    <s-table-header>Status</s-table-header>
                    <s-table-header>Reason</s-table-header>

                </s-table-header-row>

                <s-table-body>
                    @forelse($team_leaves as $lr)
                    <s-table-row>
                        <s-table-cell>{{ $lr->leave_type }}</s-table-cell>
                        <s-table-cell>{{ \Carbon\Carbon::parse($lr->start_date)->format('Y-m-d') }}</s-table-cell>
                        <s-table-cell>{{ \Carbon\Carbon::parse($lr->end_date)->format('Y-m-d') }}</s-table-cell>
                        <s-table-cell>{{ $lr->total_days }}</s-table-cell>
                        <s-table-cell>{{ ucfirst($lr->status) }}</s-table-cell>
                        <s-table-cell>

                            <s-button commandFor="modal-{{ $lr->id }}">View Reason</s-button>

                            <s-modal id="modal-{{ $lr->id }}" heading="Leave Reason">
                            <s-paragraph>{{ $lr->reason }}</s-paragraph>

                            <s-button slot="secondary-actions" commandFor="modal-{{ $lr->id }}" command="--hide">
                                Close
                            </s-button>
                            
                            </s-button>
                            </s-modal>
                            
                        </s-table-cell>

                    </s-table-row>
                    @empty
                    <s-table-row>
                        <s-table-cell colspan="5" style="text-align: center;">No leave requests found.</s-table-cell>
                    </s-table-row>
                    @endforelse
                </s-table-body>
            </s-table>

            <s-text type="strong" style="margin-bottom: 8px;" tone="success">Pending Leave Requests For this Employee</s-text>
            <s-table>

                <s-table-header-row>

                    <s-table-header>Leave Type</s-table-header>
                    <s-table-header>Start Date</s-table-header>
                    <s-table-header>End Date</s-table-header>
                    <s-table-header>Total Days</s-table-header>
                    <s-table-header>Status</s-table-header>
                    <s-table-header>Reason</s-table-header>
                    <s-table-header>Action</s-table-header>

                </s-table-header-row>

                <s-table-body>
                    @forelse($pending_leaves as $pending)
                    <s-table-row>
                        <s-table-cell>{{ $pending->leave_type }}</s-table-cell>
                        <s-table-cell>{{ \Carbon\Carbon::parse($pending->start_date)->format('Y-m-d') }}</s-table-cell>
                        <s-table-cell>{{ \Carbon\Carbon::parse($pending->end_date)->format('Y-m-d') }}</s-table-cell>
                        <s-table-cell>{{ $pending->total_days }}</s-table-cell>
                        <s-table-cell>{{ ucfirst($pending->status) }}</s-table-cell>
                        <s-table-cell>

                            <s-button commandFor="modal-{{ $pending->id }}">View Reason</s-button>

                            <s-modal id="modal-{{ $pending->id }}" heading="Leave Reason">
                            <s-paragraph>{{ $pending->reason }}</s-paragraph>

                            <s-button slot="secondary-actions" commandFor="modal-{{ $pending->id }}" command="--hide">
                                Close
                            </s-button>
                            
                            </s-button>
                            </s-modal>
                            
                        </s-table-cell>
                        <s-table-cell>
                        <s-button
                            size="slim"
                            variant="primary"
                            onClick="window.location.href='{{ route('leaves.process.form', $pending->id) }}'">
                            Process
                        </s-button>
                        </s-table-cell>

                    </s-table-row>
                    @empty
                    <s-table-row>
                        <s-table-cell colspan="5" style="text-align: center;">No leave requests found.</s-table-cell>
                    </s-table-row>
                    @endforelse
                </s-table-body>
            </s-table>


            <s-stack gap="400" align="end">
                <s-date-field id="fromDate" label="From date"></s-date-field>
                <s-date-field id="toDate" label="To date"></s-date-field>
                <div style="padding-top: 10px;">
                    <s-button variant="primary" onclick="generateLeaveCount()" >
                    Generate
                </s-button>
                </div>
                
            </s-stack>

            <s-text id="leaveCountResult" type="strong"></s-text>

           
            @endif

        </s-section>
    </s-page>
</x-layout>
