<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'busOrgId' => $this->bus_org_id,
            'parentId' => $this->parent_id,
            'categoryName' => $this->category_name,
            'categorySlug' => $this->category_slug,
            'status' => $this->status,
            'statusLabel' => $this->status_label
        ];
    }
}
