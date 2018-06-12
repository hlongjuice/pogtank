<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\PublishedStatus
 *
 * @property int $id
 * @property string $name
 * @property string $name_eng
 * @property string|null $color
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\PublishedStatus whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\PublishedStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\PublishedStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\PublishedStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\PublishedStatus whereNameEng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\PublishedStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PublishedStatus extends Model
{
    protected $table='published_status';
    protected $guarded=[];
}
