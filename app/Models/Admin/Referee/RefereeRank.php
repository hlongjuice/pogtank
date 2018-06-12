<?php

namespace App\Models\Admin\Referee;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Referee\RefereeRank
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Referee\RefereeRank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Referee\RefereeRank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Referee\RefereeRank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Referee\RefereeRank whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RefereeRank extends Model
{
    protected $table = 'referee_ranks';
    protected $guarded = [];
}
