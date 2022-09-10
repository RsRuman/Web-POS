<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasFilter;

    protected $table = 'products';

    const Status = [
        'Active' => 1,
        'Inactive' => 2
    ];

    const Variant = [
        'Variant Product' => 1,
        'Non Variant Product' => 0
    ];

    protected $fillable = [
        'bus_org_id',
        'category_id',
        'brand_id',
        'unit_id',
        'color_id',
        'size_id',
        'product_name',
        'product_code',
        'product_slug',
        'product_price',
        'product_stock_qty',
        'low_stock',
        'product_details',
        'product_barcode',
        'is_variant',
        'status'
    ];

    public function getStatusLabelAttribute(){
        return array_flip(self::Status)[$this->attributes['status']];
    }
    public function getIsVariantLabelAttribute(){
        return array_flip(self::Variant)[$this->attributes['is_variant']];
    }

    public function scopeSearchBy($q, $request){
        return $q->where('product_name', 'LIKE', '%' .$request->search. '%');
    }

    #BusinessOrganization
    public function business_organization(): BelongsTo
    {
        return $this->belongsTo(BusinessOrganization::class, 'bus_org_id', 'id');
    }

    #Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    #Brand
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    #Unit
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class,  'unit_id', 'id');
    }

    #Color
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class,  'color_id', 'id');
    }

    #Size
    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class,  'size_id', 'id');
    }

    #Product Image
    public function product_image(): HasOne
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'id');
    }

    #Purchas Item
    public function purchase_items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class, 'product_id', 'id');
    }

    #Sell Item
    public function sell_items(): HasMany
    {
        return $this->hasMany(SellItem::class, 'product_id', 'id');
    }
}
