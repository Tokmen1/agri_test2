<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FieldActionsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $collectss = FieldActionsResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
        // return parent::toArray($request);
    }
}
