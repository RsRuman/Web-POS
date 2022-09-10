<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'customerCode' => $this->customer_code,
            'customerName' => $this->customer_name,
            'customerPhone' => $this->customer_phone,
            'customerEmail' => $this->customer_email,
            'customerAddress' => $this->customer_address,
            'customerDue' => $this->customer_due,
            'customerAdvance' => $this->customer_advance,
            'status' => $this->status,
            'statusLabel' => $this->status_label
        ];
    }
}
