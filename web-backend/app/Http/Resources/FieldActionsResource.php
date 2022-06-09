<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldActionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $user = $request->user();
        $return = [
            'id' => $this->id,
            'action_type' => $this->action_type,
            'cost' => $this->cost,
            'date_from' => $this->date_from,// ->format('m/d/Y'),
            'date_to' => $this->date_to,//->format('m/d/Y H:i:s')
            'user_id' => $this->user_id,
            'fields_id' => $this->fields_id,
            'actions' => [
                'view' => $user->can('view', [$this->resource]),
                'update' => $user->can('update', $this->resource),
                'delete' => $user->can('delete', [$this->resource]),
            ]
        ];
        return $return;
    }
}
