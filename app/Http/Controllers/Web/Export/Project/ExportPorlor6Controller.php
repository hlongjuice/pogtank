<?php

namespace App\Http\Controllers\Web\Export\Project;

use App\Http\Controllers\Admin\Project\Porlor6\Porlor6Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ExportPorlor6Controller extends Controller
{
    public function exportExcel($project_order_id){
        $porlor6Controller = new Porlor6Controller();
        $project = $porlor6Controller->calculatePorlor6($project_order_id);
//        Excel::create('ปร.5', function (LaravelExcelWriter $excel) use ($project) {
//            $excel->sheet('ปร.5', function (LaravelExcelWorksheet $sheet) use ($project) {
//                $row = 1;
//                $this->setSheetStyles($sheet);
//                foreach ($project['porlor5'] as $porlor5) {
//                    $this->setHeaders($sheet, $project, $porlor5, $row);
//                    $this->setTableContents($sheet, $project, $porlor5, $row);
//                    $row++;
//                }
//            });
//        })->export('xls');
        return response()->json($project);
    }
    //Set Headers
    public function setHeaders(LaravelExcelWorksheet $sheet,$project){

    }
    //Set Table Headers
    public function setTableHeaders(){

    }
    //Set Table Contents
    public function setTableContents(){

    }

}
