<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\ModelFilters\ResidenceFilter;
use EloquentFilter\Filterable;

class FieldAddOns extends Model
{
    use HasFactory, Filterable;

    protected $table = 'field_add_ons';
    protected $attributes = [
        'type' => null,
        'name' => null,
        'amount_per_ha' => null,
        'unit_of_measure' => null,
        'cost' => null,
        'date_from' => null,
        'date_to' => null,
        'field_id' => null,
    ];
    protected $fillable = [
        'id',
        'type',
        'name',
        'amount_per_ha',
        'unit_of_measure',
        'cost',
        'date_from',
        'date_to',
        'field_id',
    ];
    protected $hidden = [];
    protected $casts = [];
    protected $appends = [];
}
