<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes, HasFilter;
    protected $table = 'brands';

    const Status = [
        'Active' => 1,
        'Inactive' => 2
    ];

    protected $fillable = [
        'bus_org_id',
        'brand_name',
        'brand_slug',
        'status'
    ];

    public function getStatusLabelAttribute(){
        return array_flip(self::Status)[$this->attributes['status']];
    }

    #Business Organization
    public function business_organization(): BelongsTo
    {
        return $this->belongsTo(BusinessOrganization::class, 'bus_org_id',  'id');
    }

    #Product
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id',  'id');
    }
}
