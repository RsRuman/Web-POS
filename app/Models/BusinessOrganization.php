<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessOrganization extends Model
{
    use HasFactory, SoftDeletes, HasFilter;
    protected $table = 'business_organizations';

    const Status = [
        'Active' => 1,
        'Inactive' => 2,
    ];

    const BusinessType = [
        'Retailer' => 1,
        'WholeSeller' => 2,
        'Manufacturer' => 3
    ];

    protected $fillable = [
        'bus_name',
        'bus_phone_no',
        'bus_email',
        'bus_type',
        'district_id',
        'upazila_id',
        'postal_code',
        'status'
    ];

    public function getBusinessTypeLabelAttribute()
    {
        return array_flip(self::BusinessType)[$this->attributes['bus_type']];
    }

    public function getStatusLabelAttribute()
    {
        return array_flip(self::Status)[$this->attributes['status']];
    }

    #User
    public function users()
    {
        return $this->hasMany(User::class, 'bus_org_id', 'id');
    }

    #Suppliers
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class, 'bus_org_id', 'id');
    }

    #Investment
    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class, 'bus_org_id', 'id');
    }

    #Withdraw
    public function withdraws(): HasMany
    {
        return $this->hasMany(Withdraw::class, 'bus_org_id', 'id');
    }

    #Utility Head
    public function utility_heads(): HasMany
    {
        return $this->hasMany(UtilityHead::class, 'bus_org_id', 'id');
    }

    #Customer
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'bus_org_id', 'id');
    }

    #Category
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'bus_org_id', 'id');
    }

    #Brand
    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class, 'bus_org_id', 'id');
    }

    #Product
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'bus_org_id', 'id');
    }

    #Purchase Master
    public function purchase_masters(): HasMany
    {
        return $this->hasMany(PurchaseMaster::class, 'bus_org_id', 'id');
    }

    #Sell Master
    public function sell_masters(): HasMany
    {
        return $this->hasMany(SellMaster::class, 'bus_org_id', 'id');
    }

}
