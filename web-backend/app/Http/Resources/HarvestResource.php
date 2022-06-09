<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HarvestResource extends JsonResource
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
            'quantity' => $this->quantity,
            'sell_price' => $this->sell_price,
            'cost' => $this->cost,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i:s'),
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
