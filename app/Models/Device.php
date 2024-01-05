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
        'organization_id',
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

    public function details()
    {
        return $this->hasMany(DeviceDetail::class, 'mac_address', 'mac_address');
    }

    public static function booted()
    {
        parent::booted();

        static::created(function ($model) {
            /**
             * @var \App\Models\User $user
             */
            $user = auth()->user();
            if ($user) {
                $organizationId = $user->organization_id === null ? $user->id : $user->organization_id;
                $model->organization_id = $organizationId;
                $model->save();
            }
        });
    }
}
