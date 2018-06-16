<?php

namespace App\Http\Controllers\Web\Export\Project;


use App\Http\Controllers\Admin\Project\Porlor4JobController;
use App\Http\Controllers\Others\NumberThaiController;
use App\Http\Controllers\Others\ThaiDateController;
use App\Models\Admin\Project\Porlor4;
use App\Models\Admin\Project\Porlor4Job;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Classes\PHPExcel;
use Maatwebsite\Excel\Writers\CellWriter;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ExportPorlor4Controller extends Controller
{
    private $tableHeaderColor;
    private $tableResultColor;
    public function __construct()
    {
        $this->tableHeaderColor='CDD5B4';
        $this->tableResultColor='DAE3C0';
    }

    public function exportByRootID($porlor4_id, $root_job_id)
    {
        $rootJob = Porlor4Job::with([
            'porlor4.projectDetails.province',
            'porlor4.projectDetails.amphoe',
            'porlor4.projectDetails.district',
            'porlor4.part'
        ])->where('id', $root_job_id)->first();
        $rootJob->calculated_child_job = (new Porlor4JobController)->getAllChildJobs($porlor4_id, $root_job_id);
        Excel::create('test', function (LaravelExcelWriter $excel) use ($rootJob) {
            $excel->sheet($rootJob->name, function ($sheet) use ($rootJob) {
                $row =1;
                $this->setSheetStyles($sheet);
                foreach ($rootJob->calculated_child_job as $childJob) {
                    $this->setHeaders($sheet, $rootJob, $childJob,$row);
                    $this->setContents($sheet,$rootJob,$childJob,$row);
                    $row++;
                }
            });
        })->export('xls');
//        return response()->json($rootJob);
    }

    //Porlor 4 Header
    public function setHeaders(LaravelExcelWorksheet $sheet,$rootJob,$childJob,&$row){
        //Header Table
        //Porlor 4 Page
        $sheet->cell('J'.$row, function (CellWriter $cell) use ($childJob) {
            $cell->setAlignment('right');
            $cell->setValue('แบบ ปร.4 แผ่นที่ ' . $childJob['page'] . '/' . $childJob['total_page']);
        });
        //Project Header
        $row++;
        $sheet->mergeCells('A'.$row.':J'.$row);
        $sheet->cell('A'.$row, function (CellWriter $cell) use ($childJob) {
            $cell->setValue('แบบแสดงรายการ ปริมาณงานและราคา');
            $cell->setAlignment('center');
        });
        // -- Address
        $row++;
        $sheet->mergeCells('A'.$row.':J'.$row);
        $sheet->cell('A'.($row), function (CellWriter $cell) use ($rootJob) {
            $cell->setValue('เทศบาลตำบล' . $rootJob->porlor4->projectDetails->district->name .
                ' อำเภอ' . $rootJob->porlor4->projectDetails->amphoe->name .
                ' จังหวัด' . $rootJob->porlor4->projectDetails->province->name);
            $cell->setAlignment('center');
        });
        // -- ถ้าเป็นแผ่นแรก
        if ($childJob['page'] == 1) {
            //Part Name
            $row++;
            $sheet->mergeCells('A'.$row.':J'.$row);
            $sheet->cell('A'.$row,function(CellWriter $cell) use ($rootJob){
                $cell->setValue('('.$rootJob->porlor4->part->name.')');
                $cell->setAlignment('center');
            });
            //Project Details
            // -- Root Job Name
            $row++;
            $sheet->cell('A'.$row,function(CellWriter $cell){
                $cell->setValue('งาน : ');
            });
            $sheet->cell('B'.$row,function (CellWriter $cell) use($rootJob){
                $cell->setValue($rootJob->name);
            });
            // -- Project Name
            $row++;
            $sheet->cell('A'.$row,function(CellWriter $cell){
                $cell->setValue('โครงการ : ');
            });
            $sheet->cell('B'.$row,function(CellWriter $cell) use($rootJob){
                $cell->setValue($rootJob->porlor4->projectDetails->project_name);
            });
            // -- Project Address ,Form Number ,From Number Release
            $row++;
            // -- -- Project Address
            $sheet->mergeCells('A'.$row.':B'.$row);
            $sheet->cell('A'.$row,function(CellWriter $cell) use ($rootJob){
                $cell->setValue('สถานที่ก่อสร้าง : '
                    .$rootJob->porlor4->projectDetails->location
                    .' ต.'.$rootJob->porlor4->projectDetails->district->name
                    .' อ.'.$rootJob->porlor4->projectDetails->amphoe->name
                    .' จ.'.$rootJob->porlor4->projectDetails->province->name
                );
            });
            // -- -- Form Number
            $sheet->cell('E'.$row,function(CellWriter $cell){
                $cell->setValue('แบบเลขที่ : ');
            });
            $sheet->cell('F'.$row,function(CellWriter $cell) use($rootJob){
                $cell->setValue($rootJob->porlor4->projectDetails->form_number);
            });
            // -- -- Form Number Release
            $sheet->cell('I'.$row,function(CellWriter $cell){
                $cell->setValue('ออกเมื่อวันที่ : ');
            });
            $sheet->cell('J'.$row,function(CellWriter $cell) use($rootJob){
                $cell->setValue($rootJob->porlor4->projectDetails->form_number_release);
            });
            // -- Project Owner Name
            $row++;
            $sheet->mergeCells('A'.$row.':B'.$row);
            $sheet->cell('A'.$row,function(CellWriter $cell) use($rootJob){
                $cell->setValue('หน่วยงานเจ้าของโครงการ : '.$rootJob->porlor4->projectDetails->owner_name);
            });
            // -- Project Agency Name
            $row++;
            $sheet->mergeCells('A'.$row.':B'.$row);
            $sheet->cell('A'.$row,function(CellWriter $cell) use($rootJob){
                $cell->setValue('หน่วยงานประมาณการ : '.$rootJob->porlor4->projectDetails->agency_name);
            });
            // -- Project Referee Name ,Project Updated At
            // -- -- Project Referee Name
            $row++;
            $sheet->mergeCells('A'.$row.':B'.$row);
            $sheet->cell('A'.$row,function(CellWriter $cell) use($rootJob){
                $cell->setValue('คำนวนราคากลางโดย : '.$rootJob->porlor4->projectDetails->referee_name);
            });
            // -- -- Project Updated At
            $sheet->cell('E'.$row,function(CellWriter $cell){
                $cell->setValue('เมื่อวันที่ : ');
            });
            $sheet->cell('F'.$row,function(CellWriter $cell) use($rootJob){
                $date= Carbon::createFromFormat('Y-m-d H:i:s',$rootJob->porlor4->projectDetails->updated_at);
                $cell->setValue($date);
            });
            //Global Unit
            $row++;
            $sheet->cell('J'.$row,function(CellWriter $cell){
                $cell->setValue('หน่วย : บาท');
                $cell->setAlignment('right');
            });
        }
        $this->setTableHeaders($sheet,$rootJob,$childJob,$row);
    }
    // -- Porlor 4 Table Header
    public function setTableHeaders(LaravelExcelWorksheet $sheet,$rootJob,$childJob,&$row){
        $row++;
        //Order Number
        $sheet->mergeCells('A'.$row.':A'.($row+1));
        $sheet->cell('A'.$row,'ลำดับที่');
        //Job Name
        $sheet->mergeCells('B'.$row.':B'.($row+1));
        $sheet->cell('B'.$row,'รายการ');
        //Quantity
        $sheet->mergeCells('C'.$row.':C'.($row+1));
        $sheet->cell('C'.$row,'จำนวน');
        //Unit
        $sheet->mergeCells('D'.$row.':D'.($row+1));
        $sheet->cell('D'.$row,'หน่วย');
        //Item Price
        // -- Header
        $sheet->mergeCells('E'.$row.':F'.$row);
        $sheet->cell('E'.$row,'ค่าวัสดุ');
        // -- Price Per Unit
        $sheet->cell('E'.($row+1),'ราคา/หน่วย');
        // -- Total Price
        $sheet->cell('F'.($row+1),'จำนวนเงิน');
        //Wage
        // -- Header
        $sheet->mergeCells('G'.$row.':H'.$row);
        $sheet->cell('G'.$row,'ค่าแรงงาน');
        // -- Price Per Unit
        $sheet->cell('G'.($row+1),'ราคา/หน่วย');
        // -- Total Price
        $sheet->cell('H'.($row+1),'จำนวนเงิน');
        //Sum Total Price Wage
        $sheet->cell('I'.$row,'รวม');
        $sheet->cell('I'.($row+1),'ค่าวัสดุและค่าแรงงาน');
        //Etc..
        $sheet->mergeCells('J'.$row.':J'.($row+1));
        $sheet->cell('J'.$row,'หมายเหตุ');

        //Set Row and Row + 1 Style (Alignment , Background , Border)
        $sheet->getStyle('A'.$row.':J'.($row+1))
            ->applyFromArray([
                'alignment' => [
                    'horizontal'=>\PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'=>\PHPExcel_Style_Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'allborders' => ['style' => \PHPExcel_Style_Border::BORDER_THIN],
                ],
                'fill' => [
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => ['rgb' => $this->tableHeaderColor]
                ]
            ]);
    }
    //Porlor 4 Table Content
    public function setContents(LaravelExcelWorksheet $sheet,$rootJob,$childJob,&$row)
    {
        //Table Content แยกตามกลุ่มงานใน 1 หน้า
        foreach ($childJob['jobs'] as $job){
            $row++;
            //4. รายการผลรวมต่อหน้า
            if(isset($job['row_page_result']) && $job['row_page_result']==1){
                //ยอดยกไป
                if($job['page']<$job['total_page']){
                    $sheet->cell('B'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue('ยอดยกไป รายการที่ 1 - '.$job['last_job_order_number']);
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('F'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue($job['page_sum_total_price']);
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('H'.$row,function(CellWriter $cell) use($job){
                       $cell->setValue($job['page_sum_total_wage']);
                       $cell->setAlignment('right');
                    });
                    $sheet->cell('I'.$row,function(CellWriter $cell) use($job){
                       $cell->setValue($job['page_sum_total_price_wage']);
                       $cell->setAlignment('right');
                    });
                }
                //ผลรวมทั้งหมด
                else{
                    $sheet->cell('B'.$row,function(CellWriter $cell) use($job){
                       $cell->setValue('รวมราคารายการที่ 1 - '.$job['last_job_order_number']);
                       $cell->setAlignment('center');
                    });
                    $sheet->cell('F'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue($job['page_sum_total_price']);
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('H'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue($job['page_sum_total_wage']);
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('I'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue($job['page_sum_total_price_wage']);
                        $cell->setAlignment('right');
                    });
                }
            }
            //3. รายการผลรวมกลุ่ม
            else if(isset($job['row_group_result']) &&$job['row_group_result'] == 1){
                //Group Depth <= 2
                if($job['group_depth'] <=2){
                    $sheet->cell('B'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue('รวมราคารายการที่ '.$job['group_order_number']);
                        $cell->setAlignment('center');
                    });
                    $sheet->cell('F'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue($job['group_sum_total_price']);
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('H'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue($job['group_sum_total_wage']);
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('I'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue($job['group_sum_total_price_wage']);
                        $cell->setAlignment('right');
                    });
                    //Result Color Background
                    $sheet->getStyle('A'.$row.':J'.$row)
                        ->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB($this->tableResultColor);
                }
                //หากมากกว่า lv 2 ไม่ต้อง highlight สีเขียว
                else{
                    $sheet->cell('B'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue('รวมราคารายการที่ '.$job['group_order_number']);
                        $cell->setAlignment('center');
                    });
                    $sheet->cell('F'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue($job['group_sum_total_price']);
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('H'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue($job['group_sum_total_wage']);
                        $cell->setAlignment('right');
                    });
                    $sheet->cell('I'.$row,function(CellWriter $cell) use($job){
                        $cell->setValue($job['group_sum_total_price_wage']);
                        $cell->setAlignment('right');
                    });
                }
            }
            //2. ยอดยกมา
            else if(isset($job['bring_forward']) && $job['bring_forward'] == 1){
                $sheet->cell('B'.$row,function(CellWriter $cell) use($job){
                    $cell->setValue('ยอดยกไป รายการที่ 1 - '.$job['last_job_order_number']);
                    $cell->setAlignment('right');
                });
                $sheet->cell('F'.$row,function(CellWriter $cell) use($job){
                    $cell->setValue($job['page_sum_total_price']);
                    $cell->setAlignment('right');
                });
                $sheet->cell('H'.$row,function(CellWriter $cell) use($job){
                    $cell->setValue($job['page_sum_total_wage']);
                    $cell->setAlignment('right');
                });
                $sheet->cell('I'.$row,function(CellWriter $cell) use($job){
                    $cell->setValue($job['page_sum_total_price_wage']);
                    $cell->setAlignment('right');
                });
            }
            //1. รายการ job
            else{
                if(isset($job['group_item_per_unit']) && $job['group_item_per_unit'] == 1){
                    //A. Job Order Number
                    $sheet->cell('A'.$row,function(CellWriter $cell) use ($job){
                        $cell->setValue($job['job_order_number']);
                        $cell->setAlignment('center');
                    });
                    //B. Job Name
                    $sheet->cell('B'.$row,function(CellWriter $cell) use ($job){
                       $cell->setValue($job['name']);
                       $cell->setAlignment('left');
                    });
                    // เพิ่ม รายการ .1 รายการต่อ 1 หน่วย
                    $row++;
                    $sheet->cell('A'.$row,function (CellWriter $cell) use($job){
                       $cell->setValue($job['job_order_number'].'.1');
                       $cell->setAlignment('center');
                    });
                    $sheet->cell('B'.$row,function(CellWriter $cell) use ($job){
                       $cell->setValue($job['name_per_unit']);
                       $cell->setAlignment('left');
                    });
                }
            }
            //Table Content Row Style
            $sheet->getStyle('A'.$row.':J'.$row)
                ->getBorders()->getAllBorders()->setBorderStyle('thin');
        }

    }

    public function setSheetStyles(LaravelExcelWorksheet $sheet)
    {
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
