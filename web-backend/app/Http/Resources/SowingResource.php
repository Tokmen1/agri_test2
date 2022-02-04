<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SowingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $request->user();
        $return = [

            'id' => $this->id,
            'name' => $this->name,
            'breed' => $this->breed,
            'pre_plant' => $this->pre_plant,
            'sowing_rate' => $this->sowing_rate,
            'date_from' => $this->date_from,// ->format('m/d/Y'),
            'date_to' => $this->date_to,//->format('m/d/Y H:i:s')
            'field_id' => $this->field_id,
            'actions' => [
                'view' => $user->can('view', [$this->resource]),
                'update' => $user->can('update', $this->resource),
                'delete' => $user->can('delete', [$this->resource]),
            ]
        ];
        return $return;
    }
}
