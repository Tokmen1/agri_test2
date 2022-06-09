<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class SowingFilter extends ModelFilter
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
            $query->orWhere('name', 'LIKE', "%$value%");
            $query->orWhere('breed', 'LIKE', "%$value%");
            $query->orWhere('pre_plant', 'LIKE', "%$value%");
            $query->orWhere('sowing_rate', 'LIKE', "%$value%");
            $query->orWhere('cost', 'LIKE', "%$value%");
            $query->orWhere('date_from', 'LIKE', "%$value%");
            $query->orWhere('date_to', 'LIKE', "%$value%");
        });
    }

    public function startDateSearch($value)
    {
        $endDateSearch = $this->input('endDateSearch');
        $startDateSearch = $this->input('startDateSearch');
        // whereBetween('date_from', [$value, '2022-06-10']);
        // dd($startDateSearch);
        $this->where(function ($query) use ($value) {
            // $query->orWhere('date_from', 'LIKE', "%$value%");
            $query->orWhereBetween('date_from', [$startDateSearch, $endDateSearch]);
            // $query->whereBetween('date_to', [$value.from, $value.to]);
        });
    }

    protected function order()
    {
        $field_id = $this->input('field_id');
        $this->where('field_id', 'LIKE', "%$field_id%");
        if ($this->input('sort_field')) {
            $this->orderColumn = $this->input('sort_field');
        }
        if ($this->input('sort_order')) {
            $this->orderDestination = $this->input('sort_order');
        }
        $this->orderBy($this->orderColumn, $this->orderDestination);
    }
}
