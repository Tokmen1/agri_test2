<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
use App\Models\Fields;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Resources\HarvestResource;
use App\Http\Resources\HarvestCollection;
use App\Http\Requests\HarvestRequest;
use App\Http\Requests\HarvestListRequest;

class HarvestController extends Controller
{
    public function index(HarvestListRequest $request)
    {
        $fields = Fields::find($request->validated()["field_id"]);
        Gate::authorize('view', $fields);
        $harvest = Harvest::filter($request->validated())->paginate(5);
        return new HarvestCollection($harvest);
    }

    public function create()
    {
        return [];
    }

    public function store(HarvestRequest $request)
    {   
        $fields = Fields::find($request->validated()["field_id"]);
        Gate::authorize('update', $fields);
        $harvest = Harvest::create($request->validated());
        return HarvestResource::make($harvest);
    }

    public function show(Harvest $harvest)
    {
        $fields = Fields::find($harvest["field_id"]);
        Gate::authorize('view', $fields);
        return HarvestResource::make($harvest->load([]));
    }

    public function edit($id)
    {
        $harvest = Harvest::where('id', $id)->first();
        $fields = Fields::find($harvest["field_id"]);
        Gate::authorize('update', $fields);
        return [
            'harvest' => HarvestResource::make($harvest->load([]))
        ];
    }

    public function update($id, HarvestRequest $request)
    {
        $harvest = Harvest::where('id', $id)->first();
        $fields = Fields::find($harvest["field_id"]);
        Gate::authorize('update', $fields);
        $harvest->update($request->validated());
        return HarvestResource::make($harvest);
    }

    public function delete($id)
    {
        $harvest = Harvest::where('id', $id)->first();
        $fields = Fields::find($harvest["field_id"]);
        Gate::authorize('delete', $fields);
        $harvest->delete();
        return ['deleted' => true];
    }
}
