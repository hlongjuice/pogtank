<?php

namespace App\Models\Admin\Material;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Material\MaterialItemLocalPriceVersion
 *
 * @property int $id
 * @property int|null $local_price_id
 * @property int $published_id
 * @property int $province_id
 * @property int $amphoe_id
 * @property int $district_id
 * @property float $cost
 * @property float $price
 * @property float $wage
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\City\Amphoe $amphoe
 * @property-read \App\Models\City\District $district
 * @property-read \App\Models\Admin\Material\MaterialItemLocalPrice|null $parent
 * @property-read \App\Models\City\Province $province
 * @property-read \App\Models\Admin\PublishedStatus $published
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion whereAmphoeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion whereLocalPriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion wherePublishedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemLocalPriceVersion whereWage($value)
 * @mixin \Eloquent
 */
class MaterialItemLocalPriceVersion extends Model
{
    protected $table='material_local_price_version';
    protected $guarded=[];

    //Published Status
    public function published(){
        return $this->belongsTo('App\Models\Admin\PublishedStatus','published_id');
    }
    //Province
    public function province(){
        return $this->belongsTo('App\Models\City\Province','province_id');
    }
    //Amphoe
    public function amphoe(){
        return $this->belongsTo('App\Models\City\Amphoe','amphoe_id');
    }
    //District
    public function district(){
        return $this->belongsTo('App\Models\City\District','district_id');
    }
    //parent or LocalPrice
    public function parent(){
        return $this->belongsTo('App\Models\Admin\Material\MaterialItemLocalPrice','local_price_id');
    }

}
