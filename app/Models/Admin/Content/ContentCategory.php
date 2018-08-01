<?php

namespace App\Models\Admin\Content;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class ContentCategory extends Model
{
    use NodeTrait;
    protected $table='content_categories';
    protected $guarded=[];

}
