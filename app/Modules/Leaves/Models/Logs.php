<?php

namespace App\Modules\Leaves\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'error',
        'source',
    ];

    public $timestamps = true;
}
