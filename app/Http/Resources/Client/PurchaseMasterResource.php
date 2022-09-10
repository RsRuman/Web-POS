<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseMasterResource extends JsonResource
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
            'purchaseDate' => $this->purchase_date,
            'totalQty' => $this->total_qty,
            'subTotal' => $this->sub_total,
            'discountAmount' => $this->discount_amount,
            'dueAmount' => $this->due_amount,
            'status' => $this->status,
            'statusLabel' => $this->status_label,
            'purchaseItems' => PurchaseItemResource::collection($this->whenLoaded('purchase_items')),
            'businessOrganization' => new BusinessOrganizationResource($this->whenLoaded('business_organization')),
            'supplier' => new SupplierResource($this->whenLoaded('supplier'))
        ];
    }
}
