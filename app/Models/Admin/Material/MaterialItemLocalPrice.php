<?php

namespace App\Models\Admin\Material;

use App\Http\Controllers\GlobalVariableController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialItemLocalPrice extends Model
{
//    use SoftDeletes;
    protected $table='material_local_price';
    protected $guarded=[];
    private $publishedStatus='';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->publishedStatus=GlobalVariableController::$publishedStatus;
    }

    //All Local Price approvedPrices and waitingPrices
    public function priceDetails(){
        return $this->hasMany('App\Models\Admin\Material\MaterialItemLocalPriceVersion',
            'local_price_id');
    }
    //Approved Prices
    public function approvedPrice(){
        return $this->hasOne('App\Models\Admin\Material\MaterialItemLocalPriceVersion',
            'local_price_id')
            ->with('province.amphoes','amphoe.districts','district')
            ->where('published_id',$this->publishedStatus['approved'])
            ->orderBy('updated_at','DESC');
    }
    //Waiting Prices
    public function waitingPrice(){
        return $this->hasOne('App\Models\Admin\Material\MaterialItemLocalPriceVersion',
            'local_price_id')
            ->with('province.amphoes','amphoe.districts','district')
            ->where('published_id',$this->publishedStatus['waiting'])
            ->orderBy('updated_at','DESC');
    }
    //Published Status
    public function published(){
        return $this->belongsTo('App\Models\Admin\PublishedStatus','published_id');
    }

    //material
    public function material(){
        return $this->belongsTo('App\Models\Admin\Material\MaterialItem','material_id');
    }


}
