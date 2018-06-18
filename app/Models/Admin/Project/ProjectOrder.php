<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Project\ProjectOrder
 *
 * @property int $id
 * @property int|null $product_id
 * @property string $project_name
 * @property string|null $location
 * @property int $province_id
 * @property int|null $amphoe_id
 * @property int|null $district_id
 * @property string|null $owner_name
 * @property string|null $agency_name
 * @property string|null $referee_name
 * @property string|null $form_number
 * @property string|null $form_number_release
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\City\Amphoe|null $amphoe
 * @property-read \App\Models\City\District|null $district
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Project\Porlor4[] $porlor4
 * @property-read \App\Models\City\Province $province
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereAgencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereAmphoeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereFormNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereFormNumberRelease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereProjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereRefereeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectOrder extends Model
{
    protected $table='project_orders';
    protected $guarded=[];

    public function porlor4(){
        return $this->hasMany('App\Models\Admin\Project\Porlor4','project_order_id');
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
    //Referee
    public function referees(){
        return $this->hasMany('App\Models\Admin\Project\ProjectReferee','project_order_id');
    }
}
