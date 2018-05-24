<?php

namespace App\Http\Controllers\Admin\Project\Porlor5;

use App\Http\Controllers\Admin\Project\Porlor4JobController;
use App\Models\Admin\Project\Porlor4;
use App\Models\Admin\Project\Porlor4Job;
use App\Models\Admin\Project\ProjectOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Porlor5Controller extends Controller
{
    public function getPorlor5($project_order_id){
        $porlor4JobController = new Porlor4JobController();
        $project = ProjectOrder::with('porlor4.jobs')->where('id',$project_order_id)->first();
        foreach ($project->porlor4 as $porlor4){
            $root_jobs = $porlor4->jobs()->where('parent_id',null)->get();
            $porlor4->root_jobs= $root_jobs;
            foreach ($porlor4->root_jobs as $root_job){
                $root_job->job_after_calculate = $porlor4JobController->calculatePorlor4ChildJob($root_job->id);
            }
//            $porlor4->root_job = $root_job;
//            $porlor4->job_after_calculate = $porlor4JobController->calculatePorlor4Job($porlor4->root_job->id);
        }
        return response()->json($project);
    }
}
