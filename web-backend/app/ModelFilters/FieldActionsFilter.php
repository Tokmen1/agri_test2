<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\Auth;

class FieldActionsFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    protected $orderColumn = 'id';
    protected $orderDestination = 'desc';

    public function setup()
    {
        $this->order();
    }

    public function search($value)
    {
        $this->where(function ($query) use ($value) {
            $query->orWhere('action_type', 'LIKE', "%$value%");
            $query->orWhere('cost', 'LIKE', "%$value%");
            // $query->orWhere('other', 'LIKE', "%$value%");
        });
    }
    public function thisSpecificField($value)
    {
        $this->where(function ($query) use ($value) {
            $query->orWhere('fields_id', 'LIKE', "%$value%");
        });
    }

    protected function order()
    {
        $this->where('user_id', 'LIKE', Auth::user()->id);
        if ($this->input('sort_field')) {
            $this->orderColumn = $this->input('sort_field');
        }
        if ($this->input('sort_order')) {
            $this->orderDestination = $this->input('sort_order');
        }
        $this->orderBy($this->orderColumn, $this->orderDestination);
    }
}
