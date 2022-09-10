<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes, HasFilter;
    protected $table = 'units';

    const Status = [
        'Active' => 1,
        'Inactive' => 2
    ];

    protected $fillable = [
        'unit_name',
        'short_form',
        'status'
    ];

    public function getStatusLabelAttribute(){
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
        return $this->hasMany(PurchaseItem::class, 'unit_id', 'id');
    }

    #Sell Item
    public function sell_items(): HasMany
    {
        return $this->hasMany(SellItem::class, 'unit_id', 'id');
    }
}
