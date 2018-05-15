<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;

class Porlor4 extends Model
{
    protected $table='porlor_4';
    protected $guarded=[];

    //Part
    public function part(){
        return $this->belongsTo('App\Models\Admin\Project\Porlor4Part','part_id');
    }
    //Project Details
    public function projectDetails(){
        return $this->belongsTo('App\Models\Admin\Project\ProjectOrder','project_order_id');
    }
    //Jobs
    public function jobs(){
        return $this->hasMany('App\Models\Admin\Project\Porlor4Job','porlor_4_id');
    }
}
