<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;

class Porlor4Part extends Model
{
    protected $table='porlor_4_parts';
    protected $guarded=[];

    public function porlor4 (){
        return $this->hasMany('App\Models\Admin\Project\Porlor4','part_id');
    }
}
