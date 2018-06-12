<?php

namespace App\Models\Admin\Material;

use App\Http\Controllers\GlobalVariableController;
use App\Models\Admin\PublishedStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Models\Admin\Material\MaterialType
 *
 * @property int $id
 * @property string $code_prefix
 * @property string $name
 * @property string|null $details
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Admin\Material\MaterialType[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Material\MaterialItemVersion[] $items
 * @property-read \App\Models\Admin\Material\MaterialType|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialType d()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialType whereCodePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialType whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialType whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialType whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialType whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MaterialType extends Model
{
    use NodeTrait;
    protected $table='material_types';
    protected $guarded=[];

    //Items
    public function items(){
        return $this->hasMany('App\Models\Admin\Material\MaterialItemVersion','type_id');
    }
}
