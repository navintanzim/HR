<x-layout>
    <s-page>
        <s-section>
            
            <h2> Leave Application</h2>

            <form method="POST" action="{{ route('leave.store') }}">
                @csrf

                <s-stack spacing="tight">


                    <s-choice-list
                        label="Leave type"
                        name="leave_type"
                        id="leave_type">
                        <s-choice value="full_day">Full day</s-choice>
                        <s-choice value="multiple_day">Multiple day</s-choice>
                    </s-choice-list>


                    <s-date-field defaultView="2025-09" defaultValue="2025-09-01" label="Start date"
                        name="start_date"
                        required></s-date-field>



                    <s-date-field defaultView="2025-09" defaultValue="2025-09-01" label="End date"
                        name="end_date"
                        id="end_date"
                        style="display: none;"></s-date-field>

                    <s-text-area
                        label="Reason"
                        name="reason">
                    </s-text-area>


                    <s-button type="submit" variant="primary" size="slim">
                        Submit Leave
                    </s-button>

                </s-stack>
            </form>
        </s-section>
    </s-page>

    <script>
        const leaveType = document.getElementById('leave_type');
        const endDate = document.getElementById('end_date');

        leaveType.addEventListener('change', (event) => {
            var type = event.currentTarget.values[0];

            if (type === 'multiple_day') {

                endDate.style.display = 'block';
            } else {
                endDate.style.display = 'none';
            }
        });
    </script>
</x-layout>