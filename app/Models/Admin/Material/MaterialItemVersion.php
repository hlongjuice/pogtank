<?php

namespace App\Models\Admin\Material;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialItemVersion extends Model
{
    use SoftDeletes;
    protected $table='material_version';
    protected $guarded=[];

    //Type
    public function type(){
        return $this->belongsTo('App\Models\Admin\Material\MaterialType','type_id');
    }
    //Published Status
    public function published(){
        return $this->belongsTo('App\Models\Admin\PublishedStatus','published_id');
    }
}
