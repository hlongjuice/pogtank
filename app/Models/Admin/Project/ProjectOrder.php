<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectOrder extends Model
{
    protected $table='project_orders';
    protected $guarded=[];

    public function porlor4(){
        return $this->hasMany('App\Models\Admin\Project\Porlor4','project_order_id');
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
}
