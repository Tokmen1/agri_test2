<?php

namespace App\Http\Controllers;

use App\Models\FieldAddOns;
use Illuminate\Http\Request;
use App\Http\Resources\FieldAddOnsResource;
use App\Http\Resources\FieldAddOnsCollection;
use App\Http\Requests\FieldAddOnsRequest;
use App\Http\Requests\FieldAddOnsListRequest;

class FieldAddOnsController extends Controller
{
    public function index(FieldAddOnsListRequest $request)
    {
        $fieldAddOns = FieldAddOns::filter($request->validated())->paginate(5);
        return new FieldAddOnsCollection($fieldAddOns);
    }

    public function create()
    {
        return [];
    }

    public function store(FieldAddOnsRequest $request)
    {
        $fieldAddOns = FieldAddOns::create($request->validated());
        return FieldAddOnsResource::make($fieldAddOns);
    }

    public function show(FieldAddOns $fieldAddOns)
    {
        return FieldAddOnsResource::make($fieldAddOns->load([]));
    }

    public function edit($id)
    {
        $fieldAddOns = FieldAddOns::where('id', $id)->first();
        return [
            'fieldAddOns' => FieldAddOnsResource::make($fieldAddOns->load([]))
        ];
    }

    public function update($id, FieldAddOnsRequest $request)
    {
        $fieldAddOns = FieldAddOns::where('id', $id)->first();
        $fieldAddOns->update($request->validated());
        return FieldAddOnsResource::make($fieldAddOns);
    }

    public function delete($id)
    {
        $fieldAddOns = FieldAddOns::where('id', $id)->first();
        $fieldAddOns->delete();
        return ['deleted' => true];
    }
}
