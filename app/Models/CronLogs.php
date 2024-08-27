<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronLogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'last_run',
        'execute_time',
        'usage_memory',
        'created_at',
        'updated_at'
    ];
}
