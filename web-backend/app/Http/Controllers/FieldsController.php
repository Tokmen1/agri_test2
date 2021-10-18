<?php

namespace App\Http\Controllers;

use App\Http\Resources\FieldResource;
use App\Http\Resources\FieldCollection;
use App\Models\Fields;
use Illuminate\Http\Request;
use App\Http\Requests\FieldRequest;
use App\Http\Requests\FieldListRequest;


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
        // dd($request->validated());
        // $fields = Fields::filter(["field_name" => "asd"])->paginate(20);
        $fields = Fields::filter($request->validated())->paginate(20);
        // $fields = Fields::latest()->paginate(5);
        return new FieldCollection($fields);
        // return view('products.index',compact('products'))
        //     ->with('i', (request()->input('page', 1) - 1) * 5);
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
    public function store(Request $request)
    {
        $field = Fields::create($request->validated());
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
    public function edit(Fields $fields)
    {
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
    public function update(Request $request, Fields $fields)
    {
        $fields->update($request->validated());
        return FieldResource::make($fields);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fields $fields)
    {
        $fields->delete();
        return ['deleted' => true];
    }
}
