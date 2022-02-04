<?php

namespace App\Http\Controllers;

use App\Models\Sowing;
use Illuminate\Http\Request;
use App\Http\Resources\SowingResource;
use App\Http\Resources\SowingCollection;
use App\Http\Requests\SowingRequest;
use App\Http\Requests\SowingListRequest;

class SowingController extends Controller
{
    public function index(SowingListRequest $request)
    {
        $sowing = Sowing::filter($request->validated())->paginate(5);
        return new SowingCollection($sowing);
    }

    public function create()
    {
        return [];
    }

    public function store(SowingRequest $request)
    {
        $sowing = Sowing::create($request->validated());
        return SowingResource::make($sowing);
    }

    public function show(Sowing $sowing)
    {
        return SowingResource::make($sowing->load([]));
    }

    public function edit($id)
    {
        $sowing = Sowing::where('id', $id)->first();
        return [
            'sowing' => SowingResource::make($sowing->load([]))
        ];
    }

    public function update($id, SowingRequest $request)
    {
        $sowing = Sowing::where('id', $id)->first();
        $sowing->update($request->validated());
        return SowingResource::make($sowing);
    }

    public function delete($id)
    {
        $sowing = Sowing::where('id', $id)->first();
        $sowing->delete();
        return ['deleted' => true];
    }
}
