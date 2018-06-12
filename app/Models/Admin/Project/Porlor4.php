<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Project\Porlor4
 *
 * @property int $id
 * @property int $project_order_id
 * @property int $part_id
 * @property int $position
 * @property int $page_number
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Admin\Project\Porlor4Job[] $jobs
 * @property-read \App\Models\Admin\Project\Porlor4Part $part
 * @property-read \App\Models\Admin\Project\ProjectOrder $projectDetails
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4 wherePageNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4 wherePartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4 wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4 whereProjectOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4 whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Porlor4 extends Model
{
    protected $table='porlor_4';
    protected $guarded=[];

    //Part
    public function part(){
        return $this->belongsTo('App\Models\Admin\Project\Porlor4Part','part_id');
    }
    //Project Details
    public function projectDetails(){
        return $this->belongsTo('App\Models\Admin\Project\ProjectOrder','project_order_id');
    }
    //Jobs
    public function jobs(){
        return $this->hasMany('App\Models\Admin\Project\Porlor4Job','porlor_4_id');
    }
}
