<?php

namespace App\Models\Admin\Material;

use Illuminate\Database\Eloquent\Model;

class MaterialItemLocalPriceVersion extends Model
{
    protected $table='material_local_price_version';
    protected $guarded=[];

    //Published Status
    public function published(){
        return $this->belongsTo('App\Models\Admin\PublishedStatus','published_id');
    }
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
    //parent or LocalPrice
    public function parent(){
        return $this->belongsTo('App\Models\Admin\Material\MaterialItemLocalPrice','local_price_id');
    }

}
