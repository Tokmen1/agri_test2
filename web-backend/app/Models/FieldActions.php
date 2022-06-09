<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\ModelFilters\ResidenceFilter;
use EloquentFilter\Filterable;

class FieldActions extends Model
{
    use HasFactory, Filterable;

    protected $table = 'fields_action';
    protected $attributes = [
        'action_type' => null,
        'cost' => null,
        'date_from' => null,
        'date_to' => null,
        'user_id' => null,
        'fields_id' => null,
        // 'is_active' => true
    ];
    protected $fillable = [
        'id',
        'action_type',
        'cost',
        'date_from',
        'date_to',
        'user_id',
        'fields_id',
    ];
    protected $hidden = [
        // 'password',
    ];
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        // 'is_active' => 'boolean'
    ];
    protected $appends = [];

    public function save(array $options = array())
    {
        if( ! $this->user_id)
        {
            $this->user_id = Auth::user()->id;
        }

        parent::save($options);
    }
}
