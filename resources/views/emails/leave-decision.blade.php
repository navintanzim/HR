<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Leave Request Update</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333">

    <h2>Leave Request {{ $status }}</h2>

    <p>Dear Employee,</p>

    <p>
        Your leave request has been
        <strong>{{ strtolower($status) }}</strong>.
    </p>

    <p>
        <strong>Leave Type:</strong> {{ $leave->leave_type ?? '-' }}<br>
        <strong>Total Days:</strong> {{ $leave->total_days ?? '-' }}<br>
        @if(!empty($leave->time))
        <strong>Time:</strong> {{ $leave->time ?? '-' }}<br>
        @endif
        <strong>Decision Date:</strong> {{ now()->format('d M Y') }}
    </p>

    @if(!empty($leave->admin_note))
        <p>
            <strong>Admin Note:</strong><br>
            {{ $leave->admin_note }}
        </p>
    @endif

    <p>
        If you have any questions, please contact HR.
    </p>

    <p>
        Regards,<br>
        HR Department
    </p>

</body>
</html>
