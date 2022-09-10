<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes, HasFilter;
    protected $table = 'suppliers';

    const Status = [
        'Active' => 1,
        'Inactive' => 2,
    ];

    protected $fillable = [
        'bus_org_id',
        'supplier_code',
        'supplier_name',
        'supplier_phone',
        'supplier_email',
        'supplier_address',
        'supplier_due',
        'supplier_advance',
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

    #Purchase Master
    public function purchase_masters(): HasMany
    {
        return $this->hasMany(PurchaseMaster::class, 'supplier_id', 'id');
    }
}
