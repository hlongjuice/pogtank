<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Project\Porlor4Part
 *
 * @property int $id
 * @property string $name
 * @property int $position
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Project\Porlor4[] $porlor4
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Part whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Part whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Part whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Part wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4Part whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Porlor4Part extends Model
{
    protected $table='porlor_4_parts';
    protected $guarded=[];

    public function porlor4 (){
        return $this->hasMany('App\Models\Admin\Project\Porlor4','part_id');
    }
}
