<?php
/*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/

namespace App\Traits;


use Carbon\Carbon;

trait HasFilter
{

    public function scopeNotDelete($query)
    {
        return $query->where('status', '!=', config('constant.delete'));
    }

    public function scopeIsActive($query)
    {
        return $query->where('status', config('constant.active'));
    }
}
