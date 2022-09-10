<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasPermissionsTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait, HasFilter;

    const IsVerified = [
        'Verified' => 1,
        'Unverified' => 2,
    ];

    const Status = [
        'Active' => 1,
        'Inactive' => 2
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bus_org_id',
        'name',
        'email',
        'phone_no',
        'is_verified',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getStatusLabelAttribute(){
        return array_flip(self::Status)[$this->attributes['status']];
    }

    #Business Organization
    public function business_organization()
    {
        return $this->belongsTo(BusinessOrganization::class,  'bus_org_id', 'id');
    }

    #Investment
    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class, 'user_id', 'id');
    }

    #Withdraw
    public function withdraws(): HasMany
    {
        return $this->hasMany(Withdraw::class, 'user_id', 'id');
    }
}
