<?php

namespace App\Http\Controllers\Web\Export\Project;


use App\Http\Controllers\Exports\ExampleExport;
use App\Http\Controllers\Admin\Project\Porlor4JobController;
use App\Models\Admin\Project\Porlor4Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportPorlor4Controller extends Controller
{
    public function exportByRootID($porlor4_id,$root_job_id){

        $porlor4JobController  = new Porlor4JobController();
        $rootJob=Porlor4Job::where('id',$root_job_id)->first();
        $rootJob->calculated_child_job = $porlor4JobController->getAllChildJobs($porlor4_id,$root_job_id);
//        return Excel::download($rootJob, 'invoices.xlsx');
//        return response()->json(Porlor4Job::first());
        return Excel::download(new ExampleExport(),'test.xlsx');
    }
}
