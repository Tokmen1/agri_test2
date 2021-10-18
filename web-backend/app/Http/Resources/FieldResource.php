<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
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
            'field_name' => $this->field_name,
            // 'created_at' => $this->formatDateTime($this->created_at),
            // 'updated_at' => $this->formatDateTime($this->updated_at)
        ];
        return $return;
    }
}
