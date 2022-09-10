<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellMaster extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sell_masters';

    const Status = [
        'Active' => 1,
        'Inactive' => 2
    ];

    protected $fillable = [
        'bus_org_id',
        'customer_id',
        'invoice_no',
        'total_qty',
        'sub_total_amount',
        'discount_amount',
        'total_amount',
        'due_amount',
        'status',
    ];

    public function getStatusLabelAttribute()
    {
        return array_flip(self::Status)[$this->attributes['status']];
    }

    #Business Organization
    public function business_organization(): BelongsTo
    {
        return $this->belongsTo(BusinessOrganization::class, 'bus_org_id', 'id');
    }

    #Customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    #Sell Item
    public function sell_items(): HasMany
    {
        return $this->hasMany(SellItem::class, 'sell_master_id', 'id');
    }
}
