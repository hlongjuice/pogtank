<?php

namespace App\Models\Admin\Content;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Models\Admin\Content\ContentCategory
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $title
 * @property string|null $body
 * @property int $_lft
 * @property int $_rgt
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Admin\Content\ContentCategory[] $children
 * @property-read \App\Models\Admin\Content\ContentCategory|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory allFlatCategories($parentTitle)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory d()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Content\ContentCategory whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class ContentCategory extends Model
{
    use NodeTrait;
    protected $table='content_categories';
    protected $guarded=[];

    public function contents(){
        return $this->hasMany('App\Models\Admin\Content\Content','category_id');
    }

    public function latestContent(){
        return $this->hasOne('App\Models\Admin\Content\Content','category_id')
            ->with('images')->orderBy('id');
    }

}
