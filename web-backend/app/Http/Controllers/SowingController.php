<?php

namespace App\Http\Controllers;

use App\Models\Sowing;
use App\Models\Fields;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Resources\SowingResource;
use App\Http\Resources\SowingCollection;
use App\Http\Requests\SowingRequest;
use App\Http\Requests\SowingListRequest;

class SowingController extends Controller
{
    public function index(SowingListRequest $request)
    {
        $fields = Fields::find($request->validated()["field_id"]);
        Gate::authorize('view', $fields);
   	    $sowing = Sowing::filter($request->validated())->paginate(5);
        return new SowingCollection($sowing);
    }

    public function create()
    {
        return [];
    }

    public function store(SowingRequest $request)
    {
        $fields = Fields::find($request->validated()["field_id"]);
        Gate::authorize('update', $fields);
        $sowing = Sowing::create($request->validated());
        return SowingResource::make($sowing);
    }

    public function show(Sowing $sowing)
    {
        $fields = Fields::find($harvest["field_id"]);
        Gate::authorize('view', $fields);
        return SowingResource::make($sowing->load([]));
    }

    public function edit($id)
    {
        $sowing = Sowing::where('id', $id)->first();
        $fields = Fields::find($sowing["field_id"]);
        Gate::authorize('update', $fields);
        return [
            'sowing' => SowingResource::make($sowing->load([]))
        ];
    }

    public function update($id, SowingRequest $request)
    {
        $fields = Fields::find($request->validated()["field_id"]);
        Gate::authorize('update', $fields);
        $sowing->update($request->validated());
        return SowingResource::make($sowing);
    }

    public function delete($id)
    {
        $sowing = Sowing::where('id', $id)->first();
        $fields = Fields::find($sowing["field_id"]);
        Gate::authorize('delete', $fields);
        $sowing->delete();
        return ['deleted' => true];
    }
}
