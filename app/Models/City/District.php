<?php

namespace App\Models\City;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table='districts';

    //Amphoe
    public function amphoe(){
        return $this->belongsTo('App\Models\City\Amphoe',amphoe_id);
    }
}
