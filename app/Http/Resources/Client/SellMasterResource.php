<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class SellMasterResource extends JsonResource
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
            'invoiceNo' => $this->invoice_no,
            'totalQty' => $this->total_qty,
            'subTotal' => $this->sub_total_amount,
            'discountAmount' => $this->discount_amount,
            'totalAmount' => $this->total_amount,
            'dueAmount' => $this->due_amount,
            'status' => $this->status,
            'statusLabel' => $this->status_label,
            'sellItems' => SellItemResource::collection($this->whenLoaded('sell_items')),
            'businessOrganization' => new BusinessOrganizationResource($this->whenLoaded('business_organization')),
            'customer' => new CustomerResource($this->whenLoaded('customer'))
        ];
    }
}
