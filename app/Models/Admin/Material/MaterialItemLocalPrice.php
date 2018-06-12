<?php

namespace App\Models\Admin\Material;

use App\Http\Controllers\GlobalVariableController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Admin\Material\MaterialItemLocalPrice
 *
 * @property int $id
 * @property int $material_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Admin\Material\MaterialItemLocalPriceVersion $approvedPrice
 * @property-read \App\Models\Admin\Material\MaterialItem $material
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Material\MaterialItemLocalPriceVersion[] $priceDetails
 * @property-read \App\Models\Admin\PublishedStatus $published
 * @property-read \App\Models\Admin\Material\MaterialItemLocalPriceVersion $waitingPrice
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPrice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPrice whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
