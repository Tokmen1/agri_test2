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
            'created_at' => $this->created_at->format('m/d/Y H:i:s'),
            'updated_at' => $this->updated_at->format('m/d/Y H:i:s'),
            // 'created_at' => $this->formatDateTime($this->created_at),
            // 'updated_at' => $this->formatDateTime($this->updated_at)
            'actions' => [
                // 'create' => Gate::allows('create', [$this->resource]),
                // 'view' => Gate::allows('view', [$this->resource]),
                // 'update' => true,//$user->can('update', $this->resource),//Gate::allows('update', [$this->resource]),
                // 'delete' => Gate::allows('delete', [$this->resource]),
            ]
        ];
        return $return;
    }
}
