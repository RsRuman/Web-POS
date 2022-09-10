<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sell_items';

    const Status = [
        'Active' => 1,
        'Inactive' => 2
    ];

    protected $fillable = [
        'sell_master_id',
        'product_id',
        'product_name',
        'unit_id',
        'unit_form',
        'unit_price',
        'product_type',
        'color_id',
        'variation_sku',
        'item_qty',
        'item_subtotal',
        'item_discount',
        'item_total',
        'status'
    ];

    public function getStatusLabelAttribute()
    {
        return array_flip(self::Status)[$this->attributes['status']];
    }

    #Sell Master
    public function sell_master(): BelongsTo
    {
        return $this->belongsTo(SellMaster::class, 'sell_master_id', 'id');
    }

    #Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    #Unit
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
