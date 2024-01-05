<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'organization_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'area_id', 'id');
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
                $organizationId = $user->organization_id === null
                    ? $user->id
                    : $user->organization_id;
                $model->organization_id = $organizationId;
                $model->save();
            }
        });
    }
}
