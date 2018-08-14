<?php

namespace App\Models\Admin\Content;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table='contents';
    protected $guarded=[];

    public function category(){
        return $this->belongsTo('App\Models\Admin\Content\ContentCategory','category_id');
    }
}
