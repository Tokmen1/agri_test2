<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
use App\Models\Fields;
use App\Models\Sowing;
use App\Models\FieldAddOns;
use App\Models\FieldActions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

use App\Http\Requests\HarvestListRequest;
use App\Http\Resources\HarvestCollection;

// use EloquentFilter\Filterable;

class ProfitLossController extends Controller
{
    // use Filterable;
    protected $orderColumn = 'id';
    protected $orderDestination = 'desc';

    public function index(HarvestListRequest $request)
    {
        $fields = Fields::find($request->validated()["field_id"]);
        Gate::authorize('view', $fields);
        // $sowing = DB::table('sowing')->addSelect('cost')->get();
        
        // $sowing = Sowing::select("*")
        //                 ->whereBetween('date_from', ["2022-06-07", "2022-06-07"])
        //                 ->get();
        $search_date_from = $request['search_date_from'] ? $request['search_date_from'] : '0000-01-01';
        $search_date_to = $request['search_date_to'] ? $request['search_date_to'] : '9999-12-12';
        $result = Sowing::join('fields', 'fields.id', '=', 'sowing.field_id')
                        ->where('date_from', '>=', $search_date_from)
                        ->where('date_to', '<=', $search_date_to)->get();
                            // ->join('field_add_ons', 'field_add_ons.field_id', '=', 'sowing.field_id')->get();
        $harvests = Harvest::join('fields', 'fields.id', '=', 'harvest.field_id')
                            ->where('date_from', '>=', $search_date_from)
                            ->where('date_to', '<=', $search_date_to)->get();
        $fieldAddOns = FieldAddOns::join('fields', 'fields.id', '=', 'field_add_ons.field_id')
                                    ->where('date_from', '>=', $search_date_from)
                                    ->where('date_to', '<=', $search_date_to)->get();
        $fieldActions = FieldActions::join('fields', 'fields.id', '=', 'fields_action.fields_id')
                                    ->where('date_from', '>=', $search_date_from)
                                    ->where('date_to', '<=', $search_date_to)->get();
        foreach($result as $oneResult) {
            $oneResult['whoIm'] = "Sēja";
            $result->add($oneResult);
        };
        foreach($harvests as $harvest) {
            $harvest['whoIm'] = "Raža";
            $harvest['name'] = "Novākšana";
            $result->add($harvest);
        };
        foreach($fieldAddOns as $fieldAddOn) {
            $fieldAddOn['whoIm'] = "Papildvielas pievienotas";
            $result->add($fieldAddOn);
        };
        foreach($fieldActions as $fieldAction) {
            $fieldAction['whoIm'] = "Cita darbība";
            $fieldAction['name'] = $fieldAction['action_type'];
            $result->add($fieldAction);
        };

        $value = $request['search'];
        // dd($value);
        if ($value != ''){
            $result = $result->where('name ', "Sēja") ->get();


        if ($request['sortField']) {
            $this->orderColumn = $request['sortField'];
        }
        // dd($request['sortField']);
        
        if($request['sort_order'] == "desc"){
            $result = $result->sortByDesc($request['sortField'])->values();
        }
        else {
            $result = $result->sortBy($request['sortField'])->values();
        }
        
            // $result->whereIn('date_from', "$value");// function ($query) use ($value) {
        //     $query->orWhere('name', 'LIKE', "%$value%");
        //     $query->orWhere('cost', 'LIKE', "%$value%");
        //     $query->orWhere('date_from', 'LIKE', "%$value%");
        //     $query->orWhere('date_to', 'LIKE', "%$value%");
        // });
        };
        // if ($request['sort_order']) {
        //     $this->orderDestination = $request['sort_order'];
            
        // }
        // dd($this->orderColumn);
        // dd([$this->orderColumn, $this->orderDestination]);
        
        
        // $result = $result1->values()->all();
        // $result = $result[11];
        // dd($result);

        // $result->where('date_from', '>=', '2022-06-08');
        // dd($sowing);
        // $harvest = Harvest::filter($request->validated())->paginate(5);
        return $result->toArray();
    }
    // public function search($value)
    // {
    //     $this->where(function ($query) use ($value) {
    //         $query->orWhere('name', 'LIKE', "%$value%");
    //         $query->orWhere('breed', 'LIKE', "%$value%");
    //         $query->orWhere('pre_plant', 'LIKE', "%$value%");
    //         $query->orWhere('sowing_rate', 'LIKE', "%$value%");
    //         $query->orWhere('cost', 'LIKE', "%$value%");
    //         $query->orWhere('date_from', 'LIKE', "%$value%");
    //         $query->orWhere('date_to', 'LIKE', "%$value%");
    //     });
    //     return $this;
    // }
    // protected function order()
    // {
    //     // $field_id = $this->input('field_id');
    //     // $this->where('field_id', 'LIKE', "%$field_id%");
    //     if ($request['sortField']) {
    //         $this->orderColumn = $request['sortField'];
    //     }
    //     if ($request['sort_order']) {
    //         $this->orderDestination = $request['sort_order'];
    //     }
    //     $request->orderBy($this->orderColumn, $this->orderDestination);
    // }
}
