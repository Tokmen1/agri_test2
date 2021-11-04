<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FirldActionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $return = [
            'id' => $this->id,
            'action_type' => $this->action_type,
            'date_from' => $this->created_at->format('m/d/Y H:i:s'),
            'date_to' => $this->updated_at//->format('m/d/Y H:i:s')
        ];
        return $return;
    }
}
