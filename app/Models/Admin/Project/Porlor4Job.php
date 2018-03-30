<?php

namespace App\Models\Admin\Project;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Porlor4Job extends Model
{
    use NodeTrait;
    protected $table='porlor_4_job';
    protected $guarded=[];
}
