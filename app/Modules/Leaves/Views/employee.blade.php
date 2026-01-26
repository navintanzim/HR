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

                </s-table-header-row>

                <s-table-body>
                    @forelse($team_leaves as $lr)
                    <s-table-row>
                        <s-table-cell>{{ $lr->leave_type }}</s-table-cell>
                        <s-table-cell>{{ \Carbon\Carbon::parse($lr->start_date)->format('Y-m-d') }}</s-table-cell>
                        <s-table-cell>{{ \Carbon\Carbon::parse($lr->end_date)->format('Y-m-d') }}</s-table-cell>
                        <s-table-cell>{{ $lr->total_days }}</s-table-cell>
                        <s-table-cell>{{ ucfirst($lr->status) }}</s-table-cell>

                    </s-table-row>
                    @empty
                    <s-table-row>
                        <s-table-cell colspan="5" style="text-align: center;">No leave requests found.</s-table-cell>
                    </s-table-row>
                    @endforelse
                </s-table-body>
            </s-table>
            @endif

        </s-section>
    </s-page>
</x-layout>