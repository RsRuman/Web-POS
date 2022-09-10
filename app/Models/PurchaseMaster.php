<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseMaster extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'purchase_masters';

    const Status = [
        'Active' => 1,
        'Inactive' => 2
    ];

    protected $fillable = [
        'bus_org_id',
        'supplier_id',
        'invoice_no',
        'purchase_date',
        'total_qty',
        'sub_total',
        'discount_amount',
        'due_amount',
        'status'
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

    #Purchase Item
    public function purchase_items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_master_id', 'id');
    }

    #Supplier
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
