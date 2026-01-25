<x-layout>
    <s-page>
        <s-section>

            <h2> Leave Application</h2>

            <form method="POST" action="{{ route('leaves.store') }}">
                @csrf

                <s-stack spacing="tight">


                    <s-choice-list
                        label="Leave type"
                        name="leave_type"
                        id="leave_type">
                        <s-choice value="half_day">Half day</s-choice>
                        <s-choice value="full_day">Full day</s-choice>
                    </s-choice-list>


                    <s-date-field defaultView="2025-09" defaultValue="2025-09-01" label="Start date"
                        name="start_date"
                        required></s-date-field>



                    <s-date-field defaultView="2025-09" defaultValue="2025-09-01" label="End date"
                        name="end_date"
                        id="end_date"
                        style="display: none;"></s-date-field>

                    <s-choice-list
                        label="Time"
                        name="time"
                        id="time"
                        style="display: none;">
                        <s-choice value="before_lunch">Before Lunch</s-choice>
                        <s-choice value="after_lunch">After Lunch</s-choice>
                    </s-choice-list>

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

            if (type === 'full_day') {

                endDate.style.display = 'block';
                time.style.display = 'none';
            } else {
                endDate.style.display = 'none';
                time.style.display = 'block';
            }
        });
    </script>
</x-layout>