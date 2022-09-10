<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdraw extends Model
{
    use HasFactory, SoftDeletes, HasFilter;
    protected $table = 'withdraws';

    const Status = [
        'Active' => 1,
        'Inactive' => 2,
    ];

    protected $fillable = [
        'bus_org_id',
        'user_id',
        'withdraw_date',
        'withdraw_amount',
        'note',
        'status'
    ];

    public function getStatusLabelAttribute(){
        return array_flip(self::Status)[$this->attributes['status']];
    }

    #User
    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    #Business Organization
    public function business_organization(): BelongsTo
    {
        return $this->belongsTo(BusinessOrganization::class, 'bus_org_id', 'id');
    }
}
