<?php

namespace App\Models\City;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\City\Province
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $name_eng
 * @property int $GEO_ID
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City\Amphoe[] $amphoes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\Province whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\Province whereGEOID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City\Province whereNameEng($value)
 * @mixin \Eloquent
 */
class Province extends Model
{
    protected $table = 'provinces';

    public function amphoes(){
        return $this->hasMany('App\Models\City\Amphoe','province_id');
    }
}
