<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TestItem
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TestItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TestItem extends Model
{
    protected $table='test_items';
    protected $guarded=[];
}
