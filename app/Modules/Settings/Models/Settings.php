<?php

namespace App\Modules\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settings extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',
        'value',
    ];
    protected $casts = [
        'value' => 'array',
    ];
}
