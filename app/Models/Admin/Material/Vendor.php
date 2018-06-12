<?php

namespace App\Models\Admin\Material;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Material\Vendor
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\Vendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\Vendor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\Vendor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Vendor extends Model
{
    protected $table = 'vendor';
    protected $guarded=[];
}
