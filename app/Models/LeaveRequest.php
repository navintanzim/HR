<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leave_requests';

    protected $fillable = [
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'total_days',
        'time',
        'reason',
        'status',
        'admin_note',
        'submitted_at',
        'decided_at',
        'decided_by',
    ];

    protected $casts = [
    'start_date' => 'datetime',
    'end_date'   => 'datetime',
];

    public $timestamps = true;
}
