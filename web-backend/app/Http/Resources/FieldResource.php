<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

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
        $user = $request->user();
        $return = [
            'id' => $this->id,
            'field_name' => $this->field_name,
            'area' => $this->area,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i:s'),
            // 'created_at' => $this->formatDateTime($this->created_at),
            // 'updated_at' => $this->formatDateTime($this->updated_at)
            'actions' => [
                'view' => $user->can('view', [$this->resource]),
                'update' => $user->can('update', $this->resource),
                'delete' => $user->can('delete', [$this->resource]),
            ]
        ];
        return $return;
    }
}
