<?php

namespace App\Models\Admin\Material;

use App\Http\Controllers\GlobalVariableController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class MaterialItemVersion extends Model
{
//    use SoftDeletes;
    protected $table = 'material_version';
    protected $guarded = [];
    private $publishedStatus='';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->publishedStatus=GlobalVariableController::$publishedStatus;
    }
    //Type
    public function type()
    {
        return $this->belongsTo('App\Models\Admin\Material\MaterialType', 'type_id');
    }

    //Published Status
    public function published()
    {
        return $this->belongsTo('App\Models\Admin\PublishedStatus', 'published_id');
    }

    //Material
    public function material()
    {
        return $this->belongsTo('App\Models\Admin\Material\MaterialItem', 'material_id');
    }

    //Local Prices
    public function localPrices()
    {
        return $this->hasMany('App\Models\Admin\Material\MaterialItemLocalPrice', 'material_id', 'material_id');
    }

    //approvedGlobal
    public function approvedGlobalDetails()
    {
        return $this->hasOne('App\Models\Admin\Material\MaterialItemVersion','id','id')
            ->where('published_id',$this->publishedStatus['approved'])
            ->orderBy('updated_at','DESC');
    }

    //Waiting GlobalPrice
    public function waitingGlobalDetails()
    {
        return  $this->hasOne('App\Models\Admin\Material\MaterialItemVersion','id','id')
            ->where('published_id', $this->publishedStatus['waiting'])
            ->orderBy('updated_at','DESC');
    }

    //Vendor
    public function vendor(){
        return $this->belongsTo('App\Models\Admin\Material\Vendor','vendor_id');
    }
}
