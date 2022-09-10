<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'supplierCode' => $this->supplier_code,
            'supplierName' => $this->supplier_name,
            'supplierPhone' => $this->supplier_phone,
            'supplierEmail' => $this->supplier_email,
            'supplierAddress' => $this->supplier_address,
            'supplierDue' => $this->supplier_due,
            'supplierAdvance' => $this->supplier_advance,
            'status' => $this->status,
            'statusLabel'=> $this->status_lable,
        ];
    }
}
