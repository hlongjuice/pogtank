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
                $this->setSheetStyles($sheet);
                foreach ($project['porlor5'] as $porlor5) {
                    $this->setHeaders($sheet, $project, $porlor5, $row);
                    $row++;
                }
            });
        })->export('xls');
//        return response()->json($project);
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
            $refereeCalculatedDate = Carbon::createFromFormat('Y-m-d',$project->referee_calculated_date)
                ->format('d/m/Y');
            $cell->setValue('คำนวนราคากลางเมื่อวันที่ : ' .$refereeCalculatedDate);
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
                    'startcolor' => ['rgb' => ExcelStyleController::tableHeaderColor['green']]
                ],
                ''
            ]);
        $sheet->getRowDimension($row)->setRowHeight(36);
    }
    //Table Content
    public function setTableContents(LaravelExcelWorksheet $sheet,$project,$porlor5,&$row){
        $row++;

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
