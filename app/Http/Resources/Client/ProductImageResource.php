<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
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
            'imageName' => $this->image_name,
            'imageOriginalName' => $this->image_original_name,
            'imagePath' => env('APP_URL').$this->image_path,
            'status' => $this->status,
            'statusLabel' => $this->status_label,
        ];
    }
}
