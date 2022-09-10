<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessOrganizationResource extends JsonResource
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
            'businessName' => $this->bus_name,
            'businessPhoneNo' => $this->bus_phone_no,
            'businessEmail' => $this->bus_email,
            'businessType' => $this->bus_type,
            'businessTypeLabel' => $this->business_type_label,
            'districtId' => $this->district_id,
            'upazilaId' => $this->upazila_id,
            'postalCode' => $this->postal_code,
            'status' => $this->status,
            'statusLabel' => $this->status_label,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
