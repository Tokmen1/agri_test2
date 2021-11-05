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
        //dd("mans id: ", $id);
        //dd($request->validated(['fields_id'=>1]));
        $fieldactions = FieldActions::filter($request->validated())->paginate(5);
        return new FieldActionsCollection($fieldactions);
        // $fields = Fields::filter($request->validated())->paginate(5);
        // return new FieldCollection($fields);
    }
    public function show(FieldActions $fields)
    {
        return FieldActionsResource::make($fields->load([]));
    }
}
