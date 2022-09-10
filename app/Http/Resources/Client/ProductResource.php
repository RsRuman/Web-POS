<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'productName' => $this->product_name,
            'productCode' => $this->product_code,
            'productSlug' => $this->product_slug,
            'productPrice' => $this->product_price,
            'productStockQty' => $this->product_stock_qty,
            'lowStock' => $this->low_stock,
            'productDetails' => $this->product_details,
            'productBarcode' => $this->product_barcode,
            'isVariant' => $this->is_variant,
            'isVariantLabel' => $this->is_variant_label,
            'status' => $this->status,
            'statusLabel' => $this->status_label,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'unit' => new UnitResource($this->whenLoaded('unit')),
            'color' => new ColorResource($this->whenLoaded('color')),
            'size' => new SizeResource($this->whenLoaded('size')),
            'productImage' => new ProductImageResource($this->whenLoaded('product_image'))
        ];
    }
}
