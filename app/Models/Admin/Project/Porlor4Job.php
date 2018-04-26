<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Porlor4Job extends Model
{
    use NodeTrait;
    protected $table='porlor_4_job';
    protected $guarded=[];

    public function items(){
        return  $this->hasMany('App\Models\Admin\Project\Porlor4JobItem','porlor_4_job_id');
    }
    public function item(){
        return $this->hasOne('App\Models\Admin\Project\Porlor4JobItem','porlor_4_job_id');
    }
}
