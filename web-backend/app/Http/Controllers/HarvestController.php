<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
use Illuminate\Http\Request;
use App\Http\Resources\HarvestResource;
use App\Http\Resources\HarvestCollection;
use App\Http\Requests\HarvestRequest;
use App\Http\Requests\HarvestListRequest;

class HarvestController extends Controller
{
    public function index(HarvestListRequest $request)
    {
        $harvest = Harvest::filter($request->validated())->paginate(5);
        return new HarvestCollection($harvest);
    }

    public function create()
    {
        return [];
    }

    public function store(HarvestRequest $request)
    {
        $harvest = Harvest::create($request->validated());
        return HarvestResource::make($harvest);
    }

    public function show(Harvest $harvest)
    {
        return HarvestResource::make($harvest->load([]));
    }

    public function edit($id)
    {
        $harvest = Harvest::where('id', $id)->first();
        return [
            'harvest' => HarvestResource::make($harvest->load([]))
        ];
    }

    public function update($id, HarvestRequest $request)
    {
        $harvest = Harvest::where('id', $id)->first();
        $harvest->update($request->validated());
        return HarvestResource::make($harvest);
    }

    public function delete($id)
    {
        $harvest = Harvest::where('id', $id)->first();
        $harvest->delete();
        return ['deleted' => true];
    }
}
