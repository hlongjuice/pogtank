<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Models\Admin\Project\Porlor4Job
 *
 * @property int $id
 * @property int $porlor_4_id
 * @property int|null $parent_id
 * @property string|null $job_order_number
 * @property string $name
 * @property int|null $group_item_per_unit
 * @property int $is_item
 * @property int|null $is_item_per_unit
 * @property int|null $quantity_factor
 * @property string|null $unit
 * @property string|null $name_per_unit
 * @property int|null $page_number
 * @property int $_lft
 * @property int $_rgt
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Admin\Project\Porlor4Job[] $children
 * @property-read \App\Models\Admin\Project\Porlor4JobItem $item
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Project\Porlor4JobItem[] $items
 * @property-read \App\Models\Admin\Project\Porlor4Job|null $parent
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job d()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereGroupItemPerUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereIsItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereIsItemPerUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereJobOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereNamePerUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job wherePageNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job wherePorlor4Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereQuantityFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Job whereUpdatedAt($value)
 */
class Porlor4Job extends Model
{
    use NodeTrait;
    protected $table='porlor_4_job';
    protected $guarded=[];

    public function items(){
        return  $this->hasMany('App\Models\Admin\Project\Porlor4JobItem','porlor_4_job_id');
    }
    public function item(){
        return $this->hasOne('App\Models\Admin\Project\Porlor4JobItem','porlor_4_job_id');
    }
}
