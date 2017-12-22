<?php

namespace App\Models\City;

use Illuminate\Database\Eloquent\Model;

class Amphoe extends Model
{
    protected $table='amphoes';

    //District
    public function districts(){
        return $this->hasMany('App\Models\City\District','amphoe_id');
    }
    //Province
    public function province(){
        return $this->belongsTo('App\Models\City\Province','province_id');
    }
}
