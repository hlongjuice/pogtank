<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;

class Porlor4JobItem extends Model
{
    protected $table='porlor_4_job_items';
    protected $guarded=[];

    public function details(){
        return $this->belongsTo('App\Models\Admin\Material\MaterialItem','material_id');
    }
}
