<?php

namespace App\Models\Admin\Content;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Content\Content
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string|null $body
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Admin\Content\ContentCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\Content whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\Content whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\Content whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\Content whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\Content whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Content extends Model
{
    protected $table='contents';
    protected $guarded=[];

    public function category(){
        return $this->belongsTo('App\Models\Admin\Content\ContentCategory','category_id');
    }
    public function images(){
        return $this->hasMany('App\Models\Admin\Content\ContentImage','content_id');
    }
}
