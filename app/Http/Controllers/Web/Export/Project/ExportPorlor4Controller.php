<?php

namespace App\Http\Controllers\Web\Export\Project;


use App\Http\Controllers\Admin\Project\Porlor4JobController;
use App\Models\Admin\Project\Porlor4;
use App\Models\Admin\Project\Porlor4Job;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ExportPorlor4Controller extends Controller
{

    public function exportByRootID($porlor4_id,$root_job_id){

        $rootJob = Porlor4Job::where('id',$root_job_id)->first();
        $rootJob->calculated_child_job = (new Porlor4JobController)->getAllChildJobs($porlor4_id,$root_job_id);
        Excel::create('test',function(LaravelExcelWriter $excel) use ($rootJob){
            dd('Exel',$excel);
            $excel->sheet($rootJob->name,function($sheet) use ($rootJob){
                $this->setSheetStyles($sheet);
                foreach($rootJob->calculated_child_job as $childJob){
                    $this->setHeaders($sheet,$rootJob,$childJob);
                }
            });
        })->export('xls');
        return response()->json($rootJob);
    }
    public function setHeaders(LaravelExcelWorksheet $sheet,$rootJob,$childJob){
        //Header Table
        //Porlor 4 Page
        $sheet->mergeCells('A1:J1');
        $sheet->cell('J1', function ($cell) use($childJob){
            $cell->setValue('แบบ ปร.4 แผ่นที่ '.$childJob['page'].'/'.$childJob['total_page']);
        });
        //ถ้าเป็นแผ่นแรก
        if($childJob['page'] == 1){
//            $sheet->mergeCells('A2:J2');
            $sheet->cell('A2',function($cell) use ($childJob){
//                $cells->setBackground('#000000');
                dd($cell);
            });
        }
    }
    public function setContents(){

    }
    public function setSheetStyles($sheet){
        $rowHeight = collect([]);
        for ($i = 1; $i <= 8; $i++) {
            $rowHeight->push(25);
        }
        $sheet->setHeight($rowHeight->toArray());
        //Sheet Setting
        $sheet->setOrientation('landscape');
        $sheet->setPageMargin(array(
            0.25, 0.30, 0.25, 0.30
        ));
    }
}
