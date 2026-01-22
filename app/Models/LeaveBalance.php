<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $table = 'leave_balances';

    protected $fillable = [
        'employee_id',
        'year',
        'paid_total',
        'paid_used',
        'unpaid_total',
        'unpaid_used',
    ];

    public $timestamps = true;
}
