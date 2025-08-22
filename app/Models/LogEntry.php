<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'ip_address',
        'root_cause',
        'status',
        'timestamp',
    ];

    public $timestamps = true;
}
