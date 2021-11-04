<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\ModelFilters\ResidenceFilter;
use EloquentFilter\Filterable;

class FieldActions extends Model
{
    use HasFactory, Filterable;

    protected $table = 'fields_action';
    protected $attributes = [
        'action_type' => null,
        'date_from' => null,
        'date_to' => null,
        // 'is_active' => true
    ];
    protected $fillable = [
        'id',
        'action_type',
        'date_from',
        'date_to',
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
