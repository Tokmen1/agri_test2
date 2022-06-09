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
        'cost' => null,
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
        'cost',
        'date_from',
        'date_to',
        'field_id',
    ];
    protected $hidden = [];
    protected $casts = [];
    protected $appends = [];

    public function fields() {
        return $this->belongsTo(Fields::class);
    }
}

