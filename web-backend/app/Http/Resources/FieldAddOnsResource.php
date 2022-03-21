<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldAddOnsResource extends JsonResource
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
            'type' => $this->type,
            'name' => $this->name,
            'amount_per_ha' => $this->amount_per_ha,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i:s'),
            'field_id' => $this->field_id,
            'actions' => [
                'view' => $user->can('view', Fields::class),
                'update' => $user->can('update', Fields::class),
                'delete' => $user->can('delete', Fields::class),
            ]
        ];
        return $return;
    }
}
