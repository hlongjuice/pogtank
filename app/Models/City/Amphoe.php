<?php

namespace App\Models\City;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\City\Amphoe
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $name_eng
 * @property int $GEO_ID
 * @property int $province_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City\District[] $districts
 * @property-read \App\Models\City\Province $province
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\Amphoe whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\Amphoe whereGEOID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\Amphoe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\Amphoe whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\Amphoe whereNameEng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\Amphoe whereProvinceId($value)
 * @mixin \Eloquent
 */
class Amphoe extends Model
{
    protected $table='amphoes';

    //District
    public function districts(){
        return $this->hasMany('App\Models\City\District','amphoe_id');
    }
    //Province
    public function province(){
        return $this->belongsTo('App\Models\City\Province','province_id');
    }
}
