<?php

namespace App\Http\Controllers\Admin\Project\Porlor5;

use App\Http\Controllers\Admin\Project\Porlor4JobController;
use App\Http\Controllers\GlobalVariableController;
use App\Models\Admin\Project\Porlor4;
use App\Models\Admin\Project\Porlor4Job;
use App\Models\Admin\Project\ProjectOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Porlor5Controller extends Controller
{
    public function getPorlor5($project_order_id)
    {
        $project = $this->calculatePorlor5($project_order_id);
        return response()->json($project);
    }

    //Calculate Porlor5
    public function calculatePorlor5($project_order_id)
    {
        $porlor4JobController = new Porlor4JobController();
        $project = ProjectOrder::with('porlor4.part', 'province', 'amphoe', 'district')->where('id', $project_order_id)->first();
        //Calculate Porlor5
        foreach ($project->porlor4 as $index => $porlor4) {
            $root_jobs = $porlor4->jobs()->where('parent_id', null)->get();
            $porlor4->root_jobs = $root_jobs;
            foreach ($porlor4->root_jobs as $root_job) {
                $calculatedChildJobs = $porlor4JobController->calculatePorlor4ChildJob($root_job->id);
                $root_job->job_after_calculate = $calculatedChildJobs;
                $root_job->sum_total_price = $calculatedChildJobs->sum('sum_total_price');
                $root_job->sum_total_wage = $calculatedChildJobs->sum('sum_total_wage');
                //ใช้ ทศนิยม 2 ตำแหน่ง
                $root_job->sum_total_price_wage = round($calculatedChildJobs->sum('sum_total_price_wage'), 2);
                //Sum Total Price Wage = job cost = ค่างานต้นทุน
                //ค่าก่อสร้าง = construction cost
                $root_job->job_cost = $root_job->sum_total_price_wage;
                $root_job->factor_f = 1.2710;
                //ใช้ ทศนิยม 2 ตำแหน่ง
                $root_job->construction_cost = round($root_job->job_cost * $root_job->factor_f, 2);
            }
            $porlor4->sum_construction_cost = $porlor4->root_jobs->sum('construction_cost');
            if ($index == 0) {
                $porlor4->previous_part = null;
                $porlor4->previous_sum_construction_cost = 0;
                $porlor4->total_sum_construction_cost = $porlor4->sum_construction_cost;
            } else {
                $porlor4->previous_part = $project->porlor4[$index - 1]->part;
                $porlor4->previous_sum_construction_cost = $project->porlor4[$index - 1]->total_sum_construction_cost;
                $porlor4->total_sum_construction_cost = $porlor4->previous_sum_construction_cost + $porlor4->sum_construction_cost;
            }
        }
        $porlor5 = collect([]);
        //$project->porlor5 = $project->porlor4->groupBy('page_number');
        //จัดกลุ่ม Parts แยกตามหน้า
        $porlor5GroupByPage = $project->porlor4->groupBy('page_number');
        foreach ($porlor5GroupByPage as $page => $parts) {
            $pageItem = collect([
                'page' => $page,
                'th_page' => GlobalVariableController::getThaiAlphabetByNumber($page),
                'parts' => $parts
            ]);
            $porlor5->push($pageItem);
        }
        $project->porlor5 = $porlor5;
        return $project;
    }

    //Move to Previous Page
    public function moveToPreviousPage($project_order_id,$porlor4_id){
        $part = Porlor4::where('id',$porlor4_id)->first();
        if($part->page_number >1 ){
            $part->page_number--;
            $part->save();
        }
        return response()->json($part);
    }

    //Move to Next Page
    public function moveToNextPage($project_order_id,$porlor4_id){
        $part = Porlor4::where('id',$porlor4_id)->first();
            $part->page_number++;
            $part->save();
        return response()->json($part);
    }
}
