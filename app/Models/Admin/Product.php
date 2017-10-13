<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Product extends Model
{
    use NodeTrait;
    protected $table='products';
    protected $fillable=['name'];

}
