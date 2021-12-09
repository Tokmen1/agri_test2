<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\ModelFilters\ResidenceFilter;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Auth;

class Fields extends Model
{
    use HasFactory, Filterable;

    protected $table = 'fields';
    protected $attributes = [
        'field_name' => null,
        'area' => null,
        'user_id' => null,
        // 'is_active' => true
    ];
    protected $fillable = [
        'id',
        'field_name',
        'area',
        'user_id',
        'created_at',
        'updated_at'
        
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
