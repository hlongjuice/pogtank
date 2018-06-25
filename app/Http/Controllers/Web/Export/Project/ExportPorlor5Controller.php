<?php

namespace App\Http\Controllers\Web\Export\Project;

use App\Http\Controllers\Admin\Project\Porlor5\Porlor5Controller;
use App\Http\Controllers\Others\ExcelStyleController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writers\CellWriter;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ExportPorlor5Controller extends Controller
{
    public function exportExcel($project_order_id)
    {
        $porlor5Controller = new Porlor5Controller();
        $project = $porlor5Controller->calculatePorlor5($project_order_id);
        Excel::create('ปร.5', function (LaravelExcelWriter $excel) use ($project) {
            $excel->sheet('ปร.5', function (LaravelExcelWorksheet $sheet) use ($project) {
                $row = 1;
                $startRow = $row;
                foreach ($project['porlor5'] as $porlor5) {
                    $this->setHeaders($sheet, $project, $porlor5, $row);
                    $this->setTableContents($sheet, $project, $porlor5, $row);
//                    $row++;
                    $row+=2;
                }
                $endRow = $row;
                $this->setSheetStyles($sheet,$startRow,$endRow);
            });
        })->export('xls');
    }

    public function setHeaders(LaravelExcelWorksheet $sheet, $project, $porlor5, &$row)
    {
        //Porlor 5 Page
        $sheet->cell('F' . $row, function (CellWriter $cell) use ($porlor5) {
            $cell->setValue('แบบ ปร.5 (' . $porlor5['th_page'] . ')');
            $cell->setAlignment('right');
        });
        //Porlor 5 Header
        // -- Header Name
        $row++;
        $sheet->mergeCells('A' . $row . ':F' . $row);
        $sheet->cell('A' . $row, function (CellWriter $cell) {
            $cell->setValue('แบบสรุปค่าก่อนสร้าง');
            $cell->setAlignment('center');
        });
        // -- Address
        $row++;
        $sheet->mergeCells('A' . $row . ':F' . $row);
        $sheet->cell('A' . ($row), function (CellWriter $cell) use ($project) {
            $cell->setValue('เทศบาลตำบล' . $project->district->name .
                ' อำเภอ' . $project->amphoe->name .
                ' จังหวัด' . $project->province->name);
            $cell->setAlignment('center');
        });
        $row++;
        //If Page == 1 Set Project Details
        //Project Details
        //Project Name
        $row++;
        $sheet->cell('B' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue('โครงการ : ' . $project['project_name']);
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
        //Form Number
        $row++;
        $sheet->cell('B' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue('แบบเลขที่ : ' . $project->form_number);
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
        //Total Porlor 4 Pages
        $row++;
        $sheet->cell('B' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue('แบบ ปร.4 ที่แนบ : ' . '');
        });
        //Referee Calculated Date
        $row++;
        $sheet->cell('B' . $row, function (CellWriter $cell) use ($project) {
            $cell->setValue('คำนวนราคากลางเมื่อวันที่ : ' . $project->referee_calculated_date);
        });
        //Unit
        $row++;
        $sheet->cell('F' . $row, function (CellWriter $cell) {
            $cell->setValue('หน่วย : บาท');
            $cell->setAlignment('right');
        });

        $this->setTableHeader($sheet, $project, $porlor5, $row);
    }

    public function setTableHeader(LaravelExcelWorksheet $sheet, $project, $porlor5, &$row)
    {
        $row++;
        //Order Number
        $sheet->cell('A' . $row, 'ลำดับที่');
        //Order Name
        $sheet->cell('B' . $row, 'รายการ');
        //Job Cost
        $sheet->cell('C' . $row, 'ค่างานต้นทุน');
        //Factor F
        $sheet->cell('D' . $row, 'Factor F');
        //Construction Cost
        $sheet->cell('E' . $row, 'ค่าก่อสร้าง');
        //Etc..
        $sheet->cell('F' . $row, 'หมายเหตุ');
        //Row Styles
        $sheet->getStyle('A' . $row . ':F' . $row)
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

    //Table Content
    public function setTableContents(LaravelExcelWorksheet $sheet, $project, $porlor5, &$row)
    {
        $startRow = $row + 1;
        foreach ($porlor5['parts'] as $part_index => $porlor4) {
            //ถ้าไม่ใช่หน้าแรก(ก.) และ เป็นรายการแรก ให้แสดงยอดยกมา
            //ยอดยกมา
            if ($porlor5['page'] > 1 && $part_index == 0) {
                $row++;
                //B ยอดยกมา
                $sheet->cell('B' . $row, function (CellWriter $cell) use ($porlor5, $porlor4) {
                    // -- กรณีเป็นหน้า ข.
                    if ($porlor5['page'] == 2) {
                        $cell->setValue('ยอดยกมา ส่วนที่ 1');
                        $cell->setAlignment('right');
                    } elseif ($porlor5['page'] > 2) {
                        $cell->setValue('ยอดยกมา ส่วนที่ 1 - ' . $porlor4['position']);
                        $cell->setAlignment('right');
                    }
                });
                //E Previous Sum Construction Cost
                $sheet->cell('E' . $row, function (CellWriter $cell) use ($porlor4) {
                    $cell->setValue($porlor4['previous_sum_construction_cost']);
                    $cell->setAlignment('right');
                });
            }
            //หัวข้อ Part
            $row++;
            $sheet->cell('B' . $row, function (CellWriter $cell) use ($porlor4) {
                $cell->setValue('ส่วนที่ ' . $porlor4['position'] . ' ' . $porlor4['part']['name']);
                $cell->setAlignment('center');
            });
            //Part Jobs
            foreach ($porlor4['root_jobs'] as $index => $root_job) {
                $row++;
                //Number
                $sheet->cell('A' . $row, function (CellWriter $cell) use ($index) {
                    $cell->setValue($index + 1);
                    $cell->setAlignment('center');
                });
                //Root Job Name
                $sheet->cell('B' . $row, function (CellWriter $cell) use ($root_job) {
                    $cell->setValue($root_job['name']);
                });
                //Job Cost
                $sheet->cell('C' . $row, function (CellWriter $cell) use ($root_job) {
                    $cell->setValue($root_job['job_cost']);
                    $cell->setAlignment('right');
                });
                //Factor F
                $sheet->cell('D' . $row, function (CellWriter $cell) use ($root_job) {
                    $cell->setValue($root_job['factor_f']);
                    $cell->setAlignment('center');
                });
                //Construction Cost
                $sheet->cell('E' . $row, function (CellWriter $cell) use ($root_job) {
                    $cell->setValue($root_job['construction_cost']);
                    $cell->setAlignment('right');
                });
                //Etc...
                $sheet->cell('F' . $row, function (CellWriter $cell) use ($root_job) {

                });
            }
            //Sum of Construction Cost
            $row++;
            $sheet->mergeCells('A' . $row . ':D' . $row);
            //A-D
            $sheet->cell('A' . $row, function (CellWriter $cell) use ($porlor4) {
                $cell->setValue('รวม' . $porlor4['part']['name']);
                $cell->setAlignment('right');
            });
            //E
            $sheet->cell('E' . $row, function (CellWriter $cell) use ($porlor4) {
                $cell->setValue($porlor4['sum_construction_cost']);
                $cell->setAlignment('right');
                $cell->setBackground('#' . ExcelStyleController::rowResultColor);
            });
            //Sum of Page
            //ถ้าเป็น Part สุดท้ายของหน้า
            if ($part_index + 1 == count($porlor5['parts'])) {
                $row++;
                //A-D
                $sheet->mergeCells('A' . $row . ':D' . $row);
                $sheet->cell('A' . $row, function (CellWriter $cell) use ($porlor4) {
                    $cell->setValue('รวมส่วนที่ 1 - ' . $porlor4['position']);
                    $cell->setAlignment('right');
                });
                //E ผมรวม
                $sheet->cell('E' . $row, function (CellWriter $cell) use ($porlor4) {
                    $cell->setValue($porlor4['total_sum_construction_cost']);
                    $cell->setAlignment('right');
                    $cell->setBackground('#' . ExcelStyleController::rowResultColor);
                });
            }
        }
        $endRow = $row;
        //Set Content Styles
        $this->setContentStyles($sheet,$startRow,$endRow);

    }
    public function setContentStyles(LaravelExcelWorksheet $sheet,$startRow,$endRow){
        $cellRange ='A'.$startRow.':F'.$endRow;
        //Borders
        $sheet->getStyle($cellRange)
            ->getBorders()->getAllBorders()->setBorderStyle('thin');
        //Cell Format
        // -- Accounting
        // -- C
        $sheet->getStyle('C'.$startRow.':C'.$endRow)
            ->getNumberFormat()->setFormatCode(ExcelStyleController::formatCode['accounting']);
        // -- E
        $sheet->getStyle('E'.$startRow.':E'.$endRow)
            ->getNumberFormat()->setFormatCode(ExcelStyleController::formatCode['accounting']);
    }

    public function setSheetStyles(LaravelExcelWorksheet $sheet,$startRow,$endRow)
    {
//        $rowHeight = collect([]);
//        for ($i = 1; $i <= $endRow; $i++) {
//            $rowHeight->push(18);
//        }
//        $sheet->setHeight($rowHeight->toArray());
        //Sheet Setting
        $sheet->setOrientation('portrait');
        $sheet->setPageMargin(array(
            0.25, 0.30, 0.25, 0.30
        ));
    }
}
