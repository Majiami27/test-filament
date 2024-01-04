<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    // protected $table = 'devices';

    protected $fillable = [
        'mac_address',
        'name',
        'custom_id',
        'area_id',
        'ip',
        'ssid',
        'status',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
