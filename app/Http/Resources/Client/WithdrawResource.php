<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\UserShortResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawResource extends JsonResource
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
            'withdrawDate' => $this->withdraw_date,
            'withdrawAmount' => $this->withdraw_amount,
            'note' => $this->note,
            'status' => $this->status,
            'statusLabel' => $this->status_label,
            'investor' => new UserShortResource($this->whenLoaded('investor')),
            'businessOrganization' => new BusinessOrganizationResource($this->whenLoaded('business_organization')),
        ];
    }
}
