<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\ModelFilters\ResidenceFilter;
use EloquentFilter\Filterable;

class Sowing extends Model
{
    use HasFactory, Filterable;

    protected $table = 'sowing';
    protected $attributes = [
        'name' => null,
        'breed' => null,
        'pre_plant' => null,
        'sowing_rate' => null,
        'date_from' => null,
        'date_to' => null,
        'field_id' => null,
        // 'is_active' => true
    ];
    protected $fillable = [
        'id',
        'name',
        'breed',
        'pre_plant',
        'sowing_rate',
        'date_from',
        'date_to',
        'field_id',
    ];
    protected $hidden = [
        // 'password',
    ];
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        // 'is_active' => 'boolean'
    ];
    protected $appends = [];
}

