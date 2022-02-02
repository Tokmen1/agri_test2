<?php

namespace App\Http\Controllers;

use App\Models\FieldActions;
use Illuminate\Http\Request;
use App\Http\Requests\FieldActionsRequest;
use App\Http\Requests\FieldActionsListRequest;
use App\Http\Resources\FieldActionsResource;
use App\Http\Resources\FieldActionsCollection;

class FieldActionsController extends Controller
{
    public function index(FieldActionsListRequest $request)
    {
        $fieldactions = FieldActions::filter($request->validated())->paginate(5);
        return new FieldActionsCollection($fieldactions);
    }

    public function create()
    {
        return [];
    }

    public function store(FieldActionsRequest $request)
    {
        $fieldactions = FieldActions::create($request->all());
        return FieldActionsResource::make($fieldactions);
    }

    public function show(FieldActions $fieldactions)
    {
        return FieldActionsResource::make($fieldactions->load([]));
    }

    public function edit($id, FieldActions $fieldactions)
    {
        // dd($fieldactions);
        // $this->authorize('view', $fieldactions);
        $fieldactions = FieldActions::where('id', $id)->first();
        return [
            'fieldactions' => FieldActionsResource::make($fieldactions->load([]))
        ];
    }

    public function update(FieldActionsRequest $request, $id)
    {
        $fieldactions = FieldActions::where('id', $id)->first();
        $fieldactions->update($request->validated());
        return FieldActionsResource::make($fieldactions);
    }

    public function delete($id)
    {
        $fieldactions = FieldActions::where('id', $id)->first();
        $fieldactions->delete();
        return ['deleted' => true];
    }
}
