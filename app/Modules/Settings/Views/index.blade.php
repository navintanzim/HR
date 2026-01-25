
<x-layout>
    <s-page>
        <s-section>
            <h1 class="text-xl font-bold mb-4">Settings</h1>

            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Timezone --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1" for="timezone">Timezone</label>
                    <input type="text" name="timezone" id="timezone" value="{{ $settings['timezone'] ?? 'Asia/Dhaka' }}" class="w-full p-2 border rounded">
                </div>

                {{-- Office Start Time --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1" for="office_start_time">Office Start Time</label>
                    <input type="time" name="office_start_time" id="office_start_time" value="{{ $settings['office_hours']['start_time'] ?? '09:00' }}" class="w-full p-2 border rounded">
                </div>

                {{-- Attendance Windows --}}
                <fieldset class="mb-4 border p-4 rounded">
                    <legend class="font-bold mb-2">Attendance Windows</legend>

                    <div class="mb-2">
                        <label>Early (before)</label>
                        <input type="time" name="attendance_windows[early][before]" value="{{ $settings['attendance_windows']['early']['before'] ?? '09:00' }}" class="w-full p-2 border rounded">
                    </div>

                    <div class="mb-2">
                        <label>On time (from - to)</label>
                        <div class="flex gap-2">
                            <input type="time" name="attendance_windows[on_time][from]" value="{{ $settings['attendance_windows']['on_time']['from'] ?? '09:00' }}" class="w-1/2 p-2 border rounded">
                            <input type="time" name="attendance_windows[on_time][to]" value="{{ $settings['attendance_windows']['on_time']['to'] ?? '09:05' }}" class="w-1/2 p-2 border rounded">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label>Late (from - to)</label>
                        <div class="flex gap-2">
                            <input type="time" name="attendance_windows[late][from]" value="{{ $settings['attendance_windows']['late']['from'] ?? '09:06' }}" class="w-1/2 p-2 border rounded">
                            <input type="time" name="attendance_windows[late][to]" value="{{ $settings['attendance_windows']['late']['to'] ?? '09:15' }}" class="w-1/2 p-2 border rounded">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label>Very late (from - to)</label>
                        <div class="flex gap-2">
                            <input type="time" name="attendance_windows[very_late][from]" value="{{ $settings['attendance_windows']['very_late']['from'] ?? '09:16' }}" class="w-1/2 p-2 border rounded">
                            <input type="time" name="attendance_windows[very_late][to]" value="{{ $settings['attendance_windows']['very_late']['to'] ?? '09:30' }}" class="w-1/2 p-2 border rounded">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label>Absent (after)</label>
                        <input type="time" name="attendance_windows[absent][after]" value="{{ $settings['attendance_windows']['absent']['after'] ?? '09:30' }}" class="w-full p-2 border rounded">
                    </div>
                </fieldset>

                {{-- Leave Policy --}}
                <fieldset class="mb-4 border p-4 rounded">
                    <legend class="font-bold mb-2">Leave Policy</legend>

                    <div class="mb-2">
                        <label>Paid leave per year</label>
                        <input type="number" name="leave_policy[paid_leave]" value="{{ $settings['leave_policy']['paid_leave'] ?? 14 }}" class="w-full p-2 border rounded">
                    </div>

                    <div class="mb-2">
                        <label>Unpaid leave cap</label>
                        <input type="number" name="leave_policy[unpaid_leave]" value="{{ $settings['leave_policy']['unpaid_leave'] ?? 5 }}" class="w-full p-2 border rounded">
                    </div>
                </fieldset>

                {{-- Submit --}}
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            </form>

        </s-section>
    </s-page>
</x-layout>
