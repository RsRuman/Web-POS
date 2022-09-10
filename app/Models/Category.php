<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasFilter;
    protected $table = 'categories';

    const Status = [
        'Active' => 1,
        'Inactive' => 2,
    ];

    protected $fillable = [
        'bus_org_id',
        'parent_id',
        'category_name',
        'category_slug',
        'icon',
        'status'
    ];

    public function scopeIsActive($query)
    {
        return $query->where('status', self::Status['Active']);
    }

    public function getStatusLabelAttribute(){
        return array_flip(self::Status)[$this->attributes['status']];
    }

    #Business Organization
    public function business_organization(): BelongsTo
    {
        return $this->belongsTo(BusinessOrganization::class, 'bus_org_id', 'id');
    }

    #Product
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
