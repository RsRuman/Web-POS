<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class SellItemResource extends JsonResource
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
            'productId' => $this->product_id,
            'productName' => $this->product_name,
            'unitId' => $this->unit_id,
            'unitForm' => $this->unit_form,
            'unitPrice' => $this->unit_price,
            'productType' => $this->product_type,
            'colorId' => $this->color_id,
            'variationSku' => $this->variation_sku,
            'itemQty' => $this->item_qty,
            'itemSubtotal' => $this->item_subtotal,
            'itemDiscount' => $this->item_discount,
            'itemTotal' => $this->item_total,
            'status' => $this->status,
            'statusLabel' => $this->status_label,
            'sellMaster' => new SellMasterResource($this->whenLoaded('sell_master')),
            'unit' => new UnitResource($this->whenLoaded('unit')),
            'color' => new ColorResource($this->whenLoaded('color')),
        ];
    }
}
