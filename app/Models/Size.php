<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sizes';

    const Status = [
        'Active' => 1,
        'Inactive' => 2
    ];

    protected $fillable = [
        'size_name',
        'short_form',
        'status'
    ];

    public function getStatusLabelAttribute(){
        return array_flip(self::Status)[$this->attributes['status']];
    }
}
