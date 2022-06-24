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

class ProfitLossController extends Controller
{
    protected $orderColumn = 'id';
    protected $orderDestination = 'desc';

    public function index(HarvestListRequest $request)
    {
        $fields = Fields::find($request->validated()["field_id"]);
        Gate::authorize('view', $fields);
        $search_date_from = $request['search_date_from'] ? $request['search_date_from'] : '0000-01-01';
        $search_date_to = $request['search_date_to'] ? $request['search_date_to'] : '9999-12-12';
        if ($request['search_date_to']){
            $result = Sowing::join('fields', 'fields.id', '=', 'sowing.field_id')
                            ->where('date_from', '>=', $search_date_from)
                            ->where('date_to', '<=', $search_date_to)->get();
            $harvests = Harvest::join('fields', 'fields.id', '=', 'harvest.field_id')
                                ->where('date_from', '>=', $search_date_from)
                                ->where('date_to', '<=', $search_date_to)->get();
            $fieldAddOns = FieldAddOns::join('fields', 'fields.id', '=', 'field_add_ons.field_id')
                                        ->where('date_from', '>=', $search_date_from)
                                        ->where('date_to', '<=', $search_date_to)->get();
            $fieldActions = FieldActions::join('fields', 'fields.id', '=', 'fields_action.fields_id')
                                        ->where('date_from', '>=', $search_date_from)
                                        ->where('date_to', '<=', $search_date_to)->get();
        } else{
            $result = Sowing::join('fields', 'fields.id', '=', 'sowing.field_id')
                            ->where('date_from', '>=', $search_date_from)->get();
            $harvests = Harvest::join('fields', 'fields.id', '=', 'harvest.field_id')
                                ->where('date_from', '>=', $search_date_from)->get();
            $fieldAddOns = FieldAddOns::join('fields', 'fields.id', '=', 'field_add_ons.field_id')
                                        ->where('date_from', '>=', $search_date_from)->get();
            $fieldActions = FieldActions::join('fields', 'fields.id', '=', 'fields_action.fields_id')
                                        ->where('date_from', '>=', $search_date_from)->get();
        }
        foreach($result as $oneResult) {
            $oneResult['whoIm'] = "Sēja";
            $oneResult['quantity'] = $oneResult['sowing_rate'] * $oneResult['area'];
            $result->add($oneResult);
        };
        foreach($harvests as $harvest) {
            $harvest['whoIm'] = "Raža";
            $harvest['name'] = "Novākšana";
            $harvest['cost'] = $harvest['quantity'] * $harvest['sell_price'];
            $result->add($harvest);
        };
        foreach($fieldAddOns as $fieldAddOn) {
            if ($fieldAddOn['type'] == "mineral_fertilizer") {
                $fieldAddOn['whoIm'] = "Minerālmēslojums";
            }
            else if ($fieldAddOn['type'] == "lime") {
                $fieldAddOn['whoIm'] = "Kaļķis";
            }
            else if ($fieldAddOn['type'] == "AAL") {
                $fieldAddOn['whoIm'] = "AAL";
            }
            $fieldAddOn['quantity'] = $fieldAddOn['amount_per_ha'] * $fieldAddOn['area'];
            // $fieldAddOn['whoIm'] = "Papildvielas pievienotas";
            $result->add($fieldAddOn);
        };
        foreach($fieldActions as $fieldAction) {
            $fieldAction['whoIm'] = "Cita darbība";
            $fieldAction['name'] = $fieldAction['action_type'];
            $result->add($fieldAction);
        };
        // search
        $value = strtolower($request['search']);
        $searchResult = array(); 
        if ($value != ''){
            foreach($result as $elem) {
                if(strtolower($elem['name']) == $value) {
                    $searchResult[] = $elem;
                };
                if(strtolower($elem['field_name']) == $value) {
                    $searchResult[] = $elem;
                };
                if(strtolower($elem['name']) == $value) {
                    $searchResult[] = $elem;
                };
                if(strtolower($elem['whoIm']) == $value) {
                    $searchResult[] = $elem;
                };
                if(strtolower($elem['cost']) == $value) {
                    $searchResult[] = $elem;
                };
                if(strtolower($elem['date_from']) == $value) {
                    $searchResult[] = $elem;
                };
                if(strtolower($elem['date_to']) == $value) {
                    $searchResult[] = $elem;
                };
            }; 
            return $searchResult;
        };
        
        if($request['sort_order'] == "desc"){
            $result = $result->sortByDesc($request['sortField'])->values();
        }
        else {
            $result = $result->sortBy($request['sortField'])->values();
        }
        return $result->toArray();
    }
}
