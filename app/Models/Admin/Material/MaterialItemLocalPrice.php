<?php

namespace App\Models\Admin\Material;

use Illuminate\Database\Eloquent\Model;

class MaterialItemLocalPrice extends Model
{
    protected $table='material_local_prices';
    protected $guarded=[];

    //Province
    public function province(){
        return $this->belongsTo('App\Models\City\Province','province_id');
    }
    //Amphoe
    public function amphoe(){
        return $this->belongsTo('App\Models\City\Amphoe','amphoe_id');
    }
    //District
    public function district(){
        return $this->belongsTo('App\Models\City\District','district_id');
    }
}
