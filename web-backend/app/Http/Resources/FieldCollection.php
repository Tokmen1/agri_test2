<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\FieldResource;
use App\Models\Fields;
use Illuminate\Support\Facades\Gate;

class FieldCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    // public static $wrap = 'field';
    public $collects = FieldResource::class;
    
    public function toArray($request)
    {
#        return parent::toArray($request);
        $user = $request->user();
        return [
            'data' => $this->collection,
            'actions' => [
                // 'create' => $request->user()->can('create', Fields::class)
                // 'create' => $user->can('create', $this->resource),
            ]
        ];
    }
}

