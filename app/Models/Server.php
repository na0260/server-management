<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Server extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'ip_address',
        'provider',
        'status',
        'cpu_cores',
        'ram_mb',
        'storage_gb',
        'version',
    ];
}
