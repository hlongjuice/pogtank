<?php

namespace App\Http\Controllers\Admin\Project\Porlor6;

use App\Http\Controllers\Admin\Project\Porlor5\Porlor5Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Porlor6Controller extends Controller
{
    //Calculate Porlor 6
    public function calculatePorlor6($project_order_id){
        $porlor5Controller = new Porlor5Controller();
        $project = $porlor5Controller->calculatePorlor5($project_order_id);

    }
}
