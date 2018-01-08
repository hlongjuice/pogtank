<?php

namespace App\Models\Admin\Material;

use App\Http\Controllers\GlobalVariableController;
use App\Models\Admin\PublishedStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class MaterialType extends Model
{
    use NodeTrait;
    protected $table='material_types';
    protected $guarded=[];

    //Items
    public function items(){
        return $this->hasMany('App\Models\Admin\Material\MaterialItemVersion','type_id');
    }
}
