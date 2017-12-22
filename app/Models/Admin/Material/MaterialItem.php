<?php

namespace App\Models\Admin\Material;

use Illuminate\Database\Eloquent\Model;

class MaterialItem extends Model
{
    protected $table='materials';
    protected $guarded=[];

    //Type
    public function type(){
        return $this->belongsTo('App\Models\Admin\Material\MaterialType','type_id');
    }
    //Published Status
    public function published(){
        return $this->belongsTo('App\Models\Admin\PublishedStatus','published_id');
    }
    //Local Prices
    public function localPrices(){
        return $this->hasMany('App\Models\Admin\Material\MaterialItemLocalPrice','material_id');
    }
}
