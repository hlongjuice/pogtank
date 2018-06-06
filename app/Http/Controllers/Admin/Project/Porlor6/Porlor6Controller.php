<?php

namespace App\Http\Controllers\Admin\Project\Porlor6;

use App\Http\Controllers\Admin\Project\Porlor5\Porlor5Controller;
use App\Http\Controllers\Others\NumberThaiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Porlor6Controller extends Controller
{
    //Get Porlor 6
    public function getPorlor6($project_order_id){
        $project = $this->calculatePorlor6($project_order_id);
        return response()->json($project);
    }
    //Calculate Porlor 6
    public function calculatePorlor6($project_order_id){
        $porlor5Controller = new Porlor5Controller();
        $project = $porlor5Controller->calculatePorlor5($project_order_id);
        $construction_cost = 0;
        foreach ($project->porlor5 as $porlor5_page){
            foreach ($porlor5_page['parts'] as $part){
                $construction_cost+=$part['sum_construction_cost'];
            }
        }
        //ถ้าผลรวมมากกว่าหลัก 1000 ขึ่นไป
        if(floor($construction_cost / 1000) * 1000 > 1000){
            $round_down_construction_cost =  floor($construction_cost / 1000) * 1000;
        }elseif (floor($construction_cost / 100) * 100 > 100){
            $round_down_construction_cost =  floor($construction_cost / 100) * 100; //ถ้าต่ำกว่า 1000 ปัดหลัก 100
        }else{
            $round_down_construction_cost =  floor($construction_cost / 10) * 10;//ถ้าต่ำกว่า 100 ปัดหลัก 10
        }

        $numberThai = new NumberThaiController();
        $round_down_construction_cost_text = $numberThai->convertToBaht($round_down_construction_cost);


        $porlor6=collect([
            'construction_cost'=>$construction_cost,
            'round_down_construction_cost' =>$round_down_construction_cost,
            'round_down_construction_cost_text'=>$round_down_construction_cost_text
        ]);
        $project->porlor6=$porlor6;
        return $project;

    }
}
