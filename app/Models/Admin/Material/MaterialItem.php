<?php

namespace App\Models\Admin\Material;

use App\Http\Controllers\GlobalVariableController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialItem extends Model
{
    use SoftDeletes;
    protected $table='material';
    protected $guarded=[];
    private $publishedStatus='';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->publishedStatus=GlobalVariableController::$publishedStatus;
    }
    //Published Status
    public function published(){
        return $this->belongsTo('App\Models\Admin\PublishedStatus','published_id');
    }
    //All Global Waiting and Approved Global Price
    public function globalPriceDetails(){
        return $this->hasMany('App\Models\Admin\Material\MaterialItemVersion','material_id');
    }
    //Approved GlobalPrice
    public function approvedGlobalPrice(){
        return $this->hasOne('App\Models\Admin\Material\MaterialItemVersion','material_id')
            ->where('published_id',$this->publishedStatus['approved'])
            ->orderBy('updated_at','DESC');
    }
    //Waiting GlobalPrice
    public function waitingGlobalPrice(){
        return $this->hasOne('App\Models\Admin\Material\MaterialItemVersion','material_id')
            ->where('published_id',$this->publishedStatus['waiting'])
            ->orderBy('updated_at','DESC');
    }

    //Local Prices
    public function localPrices(){
        return $this->hasMany('App\Models\Admin\Material\MaterialItemLocalPrice','material_id');
    }
}
