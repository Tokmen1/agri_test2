<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\ModelFilters\ResidenceFilter;
use EloquentFilter\Filterable;

class Fields extends Model
{
    use HasFactory, Filterable;

    protected $table = 'fields';
    protected $attributes = [
        'field_name' => null,
        'area' => null,
        // 'is_active' => true
    ];
    protected $fillable = [
         'field_name',
         'area'
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
