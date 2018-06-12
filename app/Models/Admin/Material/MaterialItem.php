<?php

namespace App\Models\Admin\Material;

use App\Http\Controllers\GlobalVariableController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Admin\Material\MaterialItem
 *
 * @property int $id
 * @property int $type_id
 * @property int $published_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Admin\Material\MaterialItemVersion $approvedGlobalDetails
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Material\MaterialItemLocalPriceVersion[] $approvedLocalPrices
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Material\MaterialItemVersion[] $globalDetails
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Material\MaterialItemLocalPrice[] $localPrices
 * @property-read \App\Models\Admin\PublishedStatus $published
 * @property-read \App\Models\Admin\Material\MaterialItemVersion $waitingGlobalDetails
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Material\MaterialItemLocalPriceVersion[] $waitingLocalPrices
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItem wherePublishedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItem whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MaterialItem extends Model
{
//    use SoftDeletes;
    private $publishedStatus = '';
    protected $guarded = [];
    protected $table = 'material';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->publishedStatus = GlobalVariableController::$publishedStatus;
    }

    //Published Status
    public function published()
    {
        return $this->belongsTo('App\Models\Admin\PublishedStatus', 'published_id');
    }

    //All Global Waiting and Approved Global Price
    public function globalDetails()
    {
        return $this->hasMany('App\Models\Admin\Material\MaterialItemVersion', 'material_id');
    }

    //Approved GlobalPrice
    public function approvedGlobalDetails()
    {
        return $this->hasOne('App\Models\Admin\Material\MaterialItemVersion', 'material_id')
            ->with('type')
            ->where('published_id', $this->publishedStatus['approved'])
            ->orderBy('updated_at', 'DESC');
    }

    //Waiting GlobalPrice
    public function waitingGlobalDetails()
    {
        return $this->hasOne('App\Models\Admin\Material\MaterialItemVersion', 'material_id')
            ->with('type')
            ->where('published_id', $this->publishedStatus['waiting'])
            ->orderBy('updated_at', 'DESC');
    }

    //Local Prices
    public function localPrices()
    {
        return $this->hasMany('App\Models\Admin\Material\MaterialItemLocalPrice', 'material_id');
    }
    //Approved Local Prices
    public function approvedLocalPrices()
    {
        return $this->hasManyThrough('App\Models\Admin\Material\MaterialItemLocalPriceVersion',
            'App\Models\Admin\Material\MaterialItemLocalPrice', 'material_id',
            'local_price_id', 'id', 'id')
            ->with('province','amphoe','district')
            ->where('published_id',$this->publishedStatus['approved'])
            ->orderBy('updated_at','DESC');
    }

    //Waiting Local Prices
    public function waitingLocalPrices(){
        return $this->hasManyThrough('App\Models\Admin\Material\MaterialItemLocalPriceVersion',
            'App\Models\Admin\Material\MaterialItemLocalPrice', 'material_id',
            'local_price_id', 'id', 'id')
            ->with('province','amphoe','district')
            ->where('published_id',$this->publishedStatus['waiting'])
            ->orderBy('updated_at','DESC');
    }
}
