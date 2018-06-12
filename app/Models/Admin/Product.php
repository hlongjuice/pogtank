<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Models\Admin\Product
 *
 * @property int $id
 * @property string $name
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Product whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Product whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Product whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $table='products';
    protected $guarded=[];
}
