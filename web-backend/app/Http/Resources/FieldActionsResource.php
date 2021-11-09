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
        $return = [
            'id' => $this->id,
            'action_type' => $this->action_type,
            'date_from' => $this->date_from,// ->format('m/d/Y'),
            'date_to' => $this->date_to,//->format('m/d/Y H:i:s')
            'fields_id' => $this->fields_id,
        ];
        return $return;
    }
}
