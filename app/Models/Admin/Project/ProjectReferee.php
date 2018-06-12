<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Project\ProjectReferee
 *
 * @property int $id
 * @property int $project_order_id
 * @property int $position
 * @property string|null $rank
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectReferee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectReferee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectReferee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectReferee wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectReferee whereProjectOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectReferee whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\ProjectReferee whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectReferee extends Model
{
    protected $table='project_referee';
    protected $guarded=[];
}
