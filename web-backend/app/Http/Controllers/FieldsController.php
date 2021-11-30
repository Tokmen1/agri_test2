<?php

namespace App\Http\Controllers;

use App\Http\Resources\FieldResource;
use App\Http\Resources\FieldCollection;
use App\Models\Fields;
use Illuminate\Http\Request;
use App\Http\Requests\FieldRequest;
use App\Http\Requests\FieldListRequest;
use Illuminate\Support\Facades\Auth;

class FieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FieldListRequest $request)
    {
        // dd($request->all());
        if(!$user = Auth::user())
        {
            return "i'm not authenticated!!!";
        }
        $fields = Fields::filter($request->validated())->paginate(5);
        return new FieldCollection($fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FieldRequest $request)
    {
        $fields = Fields::create($request->validated());
        return FieldResource::make($fields);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function show(Fields $fields)
    {
        return FieldResource::make($fields->load([]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fields = Fields::where('id', $id)->first();
        return [
            'field' => FieldResource::make($fields->load([]))
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function update(Fields $fields, FieldRequest $request, $id)
    {
        $fields = Fields::where('id', $id)->first();
        $fields->update($request->validated());
        return FieldResource::make($fields);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function delete(Fields $fields, $id)
    {
        $fields = Fields::where('id', $id)->first();
        $fields->delete();
        return ['deleted' => true];
    }
}
