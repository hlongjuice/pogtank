<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Project\Porlor4JobItem
 *
 * @property int $id
 * @property int $porlor_4_job_id
 * @property int $page_number
 * @property float $local_price
 * @property float $local_wage
 * @property string $unit
 * @property float $quantity
 * @property int $material_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Admin\Material\MaterialItem $details
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4JobItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4JobItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4JobItem whereLocalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4JobItem whereLocalWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4JobItem whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4JobItem wherePageNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4JobItem wherePorlor4JobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4JobItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4JobItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Project\Porlor4JobItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Porlor4JobItem extends Model
{
    protected $table='porlor_4_job_items';
    protected $guarded=[];

    public function details(){
        return $this->belongsTo('App\Models\Admin\Material\MaterialItem','material_id');
    }
}
