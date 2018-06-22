<?php

namespace App\Http\Controllers\Web\Export\Project;

use App\Http\Controllers\Admin\Project\Porlor6\Porlor6Controller;
use App\Http\Controllers\Others\ExcelStyleController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writers\CellWriter;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ExportPorlor6Controller extends Controller
{
    public function exportExcel($project_order_id)
    {
        $porlor6Controller = new Porlor6Controller();
        $project = $porlor6Controller->calculatePorlor6($project_order_id);
        Excel::create('ปร.6', function (LaravelExcelWriter $excel) use ($project) {
            $excel->sheet('ปร.6', function (LaravelExcelWorksheet $sheet) use ($project) {
                $row = 1;
                $this->setSheetStyles($sheet);
                $this->setHeaders($sheet, $project, $row);
                $this->setTableContents($sheet, $project, $row);
            });
        })->export('xls');
//        return response()->json($project);
    }

    //Set Headers
    public function setHeaders(LaravelExcelWorksheet $sheet, $project, &$row)
    {
        //Porlor 6 Page
        $sheet->mergeCells('A' . $row . ':D' . $row);
        $sheet->cell('A' . $row, function (CellWriter $cell) {
            $cell->setValue('แบบ ปร.6 แผ่นที่ 1/1');
            $cell->setAlignment('right');
        });
        //Porlor 6 Header
        $row++;
        $sheet->mergeCells('A' . $row . ':D' . $row);
        $sheet->cell('A' . $row, function (CellWriter $cell) {
            $cell->setValue('แบบสรุปราคางานก่อสร้าง');
            $cell->setAlignment('center');
        });
        //Project Name
        $row++;
        $sheet->cell('B' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue('โครงการ : ' . $project->project_name);
        });
        //Project Address
        $row++;
        $sheet->cell('B' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue('สถานที่ก่อสร้าง : '
                . $project->location
                . ' ต.' . $project->district->name
                . ' อ.' . $project->amphoe->name
                . ' จ.' . $project->province->name
            );
        });
        //Owner Name
        $row++;
        $sheet->cell('B' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue('หน่วยงานเจ้าของโครงการ : ' . $project->owner_name);
        });
        //Agency Name
        $row++;
        $sheet->cell('B' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue('หน่วยงานประมาณการ : ' . $project->agency_name);
        });
        //Total Porlor 4 Porlor 5 Pages Number
        $row++;
        $sheet->cell('B' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue('แบบ ปร.4 และ ปร.5 ที่แนบมีจำนวน : ' . '');
        });
        //Referee Calculated Date
        $row++;
        $sheet->cell('B' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue('คำนวนราคากลางเมื่อวันที่ : ' . $project->referee_calculated_date);
        });

        //Table Headers
        $this->setTableHeaders($sheet, $project, $row);

    }

    //Set Table Headers
    public function setTableHeaders(LaravelExcelWorksheet $sheet, $project, &$row)
    {
        $row++;
        //Number
        $sheet->cell('A' . $row, 'ลำดับที่');
        //Order Name
        $sheet->cell('B' . $row, 'รายการ');
        //Construction Cost
        $sheet->cell('C' . $row, 'ค่าก่อสร้าง');
        //Etc..
        $sheet->cell('D' . $row, 'หมายเหตุ');

        //Row Styles
        $sheet->getStyle('A' . $row . ':D' . $row)
            ->applyFromArray([
                'alignment' => [
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'allborders' => ['style' => \PHPExcel_Style_Border::BORDER_THIN],
                ],
                'fill' => [
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => ['rgb' => ExcelStyleController::tableHeaderColor]
                ],
                ''
            ]);
        $sheet->getRowDimension($row)->setRowHeight(36);

    }

    //Set Table Contents
    public function setTableContents(LaravelExcelWorksheet $sheet, $project, &$row)
    {
        $row++;
        $startRow = $row;
        //Number
        $sheet->cell('A' . $row, function (CellWriter $cell) {
            $cell->setValue('1');
            $cell->setAlignment('center');
        });
        //Project Name
        $sheet->cell('B' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue($project->project_name);
        });
        //Total Construction Cost
        $sheet->cell('C' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue($project['porlor6']['construction_cost']);
        });

        $row += 6; // บวก Row ว่างๆ ไป 5 row

        //A สรุป
        $row++;
        $sheet->mergeCells('A'.$row.':A'.($row+2));
        $sheet->cell('A'.$row,function(CellWriter $cell){
           $cell->setValue('สรุป');
           $cell->setAlignment('center');
           $cell->setValignment('center');
        });
        // -- B รวม ค่าก่อสร้าง
        $sheet->cell('B'.$row,function(CellWriter $cell){
            $cell->setValue('รวมค่าก่อสร้าง');
            $cell->setAlignment('center');
        });
        // -- C Construction Cost
        $sheet->cell('C'.$row,function(CellWriter $cell) use ($project){
            $cell->setValue($project['porlor6']['construction_cost']);
            $cell->setAlignment('right');
        });
        //new Row
        $row++;
        // -- B ราคากลาง
        $sheet->cell('B'.$row,function(CellWriter $cell){
            $cell->setValue('ราคากลาง');
            $cell->setAlignment('center');
            $cell->setBackground(ExcelStyleController::rowResultColor);
        });
        // -- C Round Down Construction Cost
        $sheet->cell('C'.$row,function(CellWriter $cell) use ($project){
            $cell->setValue($project['porlor6']['round_down_construction_cost']);
            $cell->setAlignment('center');
            $cell->setBackground(ExcelStyleController::rowResultColor);
        });
        //new Row
        $row++;
        // -- B ราคากลาง (ตัวอักษร)
        $sheet->cell('B'.$row,function(CellWriter $cell){
            $cell->setValue('ราคากลาง(ตัวอักษร)');
            $cell->setAlignment('center');
        });
        // -- C Round Down Construction Cost Text
        $sheet->mergeCells('C'.$row.':D'.$row);
        $sheet->cell('C'.$row,function(CellWriter $cell) use ($project){
            $cell->setValue($project['porlor6']['round_down_construction_cost_text']);
            $cell->setAlignment('center');
        });

        $endRow = $row;
        $this->setContentStyles($sheet, $startRow, $endRow);

    }

    public function setContentStyles(LaravelExcelWorksheet $sheet, $startRow, $endRow)
    {
        $cellRange = 'A' . $startRow . ':D' . $endRow;
        //Borders
        $sheet->getStyle($cellRange)
            ->getBorders()->getAllBorders()->setBorderStyle('thin');
        //Cell Format
        // -- Accounting
        // -- C
        $sheet->getStyle('C' . $startRow . ':C' . $endRow)
            ->getNumberFormat()->setFormatCode(ExcelStyleController::formatCode['accounting']);
    }

    public function setSheetStyles(LaravelExcelWorksheet $sheet)
    {
//        $rowHeight = collect([]);
//        for ($i = 1; $i <= 8; $i++) {
//            $rowHeight->push(25);
//        }
//        $sheet->setHeight($rowHeight->toArray());
        //Sheet Setting
        $sheet->setOrientation('portrait');
        $sheet->setPageMargin(array(
            0.25, 0.30, 0.25, 0.30
        ));
    }

}
