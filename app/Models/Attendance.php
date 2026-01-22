<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'employee_id',
        'date',
        'check_in_time',
        'status',
        'source_ip'
    ];

    public $timestamps = true;
}
