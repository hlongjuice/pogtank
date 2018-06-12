<?php

namespace App\Models\City;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\City\District
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $name_eng
 * @property int $amphoe_id
 * @property int $province_id
 * @property int $GEO_ID
 * @property-read \App\Models\City\Amphoe $amphoe
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\District whereAmphoeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\District whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\District whereGEOID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\District whereNameEng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\District whereProvinceId($value)
 * @mixin \Eloquent
 */
class District extends Model
{
    protected $table='districts';

    //Amphoe
    public function amphoe(){
        return $this->belongsTo('App\Models\City\Amphoe','amphoe_id');
    }
}
