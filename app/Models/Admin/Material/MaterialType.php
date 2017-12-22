<?php

namespace App\Models\Admin\Material;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class MaterialType extends Model
{
    use NodeTrait;
    protected $table='material_types';
    protected $guarded=[];

    //Items
    public function items(){
        return $this->hasMany('App\Models\Admin\Material\MaterialItem','type_id');
    }
}
