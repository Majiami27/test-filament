<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceDetail extends Model
{
    use HasFactory;

    // protected $table = 'devices';

    protected $fillable = [
        'mac_address',
        'port',
        'port_name',
        'status',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'status' => 'boolean',
        'updated_at' => 'datetime',
    ];

    public function devices()
    {
        return $this->belongsTo(Device::class, 'mac_address', 'mac_address');
    }
}
