<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\ModelFilters\ResidenceFilter;
use EloquentFilter\Filterable;

class Harvest extends Model
{
    use HasFactory, Filterable;

    protected $table = 'harvest';
    protected $attributes = [
        'quantity' => null,
        'sell_price' => null,
        'date_from' => null,
        'date_to' => null,
        'field_id' => null,
    ];
    protected $fillable = [
        'id',
        'quantity',
        'sell_price',
        'date_from',
        'date_to',
        'field_id',
    ];
    protected $hidden = [];
    protected $casts = [];
    protected $appends = [];
}
