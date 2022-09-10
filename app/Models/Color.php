<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory, SoftDeletes, HasFilter;
    protected $table = 'colors';

    const Status = [
        'Active' => 1,
        'Inactive' => 2
    ];

    protected $fillable = [
        'color_name',
        'color_code',
        'status'
    ];

    public function getStatusLabelAttribute(){
        return array_flip(self::Status)[$this->attributes['status']];
    }

    #Purchase item
    public function purchase_items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class, 'color_id', 'id');
    }
}
