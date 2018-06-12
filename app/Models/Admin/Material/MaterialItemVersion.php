<?php

namespace App\Models\Admin\Material;

use App\Http\Controllers\GlobalVariableController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

/**
 * App\Models\Admin\Material\MaterialItemVersion
 *
 * @property int $id
 * @property int $material_id
 * @property string $code
 * @property int $published_id
 * @property \App\Models\Admin\Material\Vendor $vendor
 * @property string $name
 * @property string|null $details
 * @property int $type_id
 * @property float|null $global_price
 * @property float|null $global_cost
 * @property float|null $global_wage
 * @property float|null $invoice_price
 * @property float|null $invoice_cost
 * @property float|null $invoice_wage
 * @property string|null $unit
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $deleted_at
 * @property-read \App\Models\Admin\Material\MaterialItemVersion $approvedGlobalDetails
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Material\MaterialItemLocalPrice[] $localPrices
 * @property-read \App\Models\Admin\Material\MaterialItem $material
 * @property-read \App\Models\Admin\PublishedStatus $published
 * @property-read \App\Models\Admin\Material\MaterialType $type
 * @property-read \App\Models\Admin\Material\MaterialItemVersion $waitingGlobalDetails
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereGlobalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereGlobalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereGlobalWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereInvoiceCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereInvoicePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereInvoiceWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion wherePublishedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Material\MaterialItemVersion whereVendor($value)
 * @mixin \Eloquent
 */
class MaterialItemVersion extends Model
{
//    use SoftDeletes;
    protected $table = 'material_version';
    protected $guarded = [];
    private $publishedStatus='';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->publishedStatus=GlobalVariableController::$publishedStatus;
    }
    //Type
    public function type()
    {
        return $this->belongsTo('App\Models\Admin\Material\MaterialType', 'type_id');
    }

    //Published Status
    public function published()
    {
        return $this->belongsTo('App\Models\Admin\PublishedStatus', 'published_id');
    }

    //Material
    public function material()
    {
        return $this->belongsTo('App\Models\Admin\Material\MaterialItem', 'material_id');
    }

    //Local Prices
    public function localPrices()
    {
        return $this->hasMany('App\Models\Admin\Material\MaterialItemLocalPrice', 'material_id', 'material_id');
    }

    //approvedGlobal
    public function approvedGlobalDetails()
    {
        return $this->hasOne('App\Models\Admin\Material\MaterialItemVersion','id','id')
            ->where('published_id',$this->publishedStatus['approved'])
            ->orderBy('updated_at','DESC');
    }

    //Waiting GlobalPrice
    public function waitingGlobalDetails()
    {
        return  $this->hasOne('App\Models\Admin\Material\MaterialItemVersion','id','id')
            ->where('published_id', $this->publishedStatus['waiting'])
            ->orderBy('updated_at','DESC');
    }

    //Vendor
    public function vendor(){
        return $this->belongsTo('App\Models\Admin\Material\Vendor','vendor_id');
    }
}
