<?php

namespace App\Models\City;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    public function amphoes(){
        return $this->hasMany('App\Models\City\Amphoe','province_id');
    }
}
