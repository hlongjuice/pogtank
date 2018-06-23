<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class CreateImageController extends Controller
{
    public function createImage(){
        Excel::create('test',function(LaravelExcelWriter $excel){
            $excel->sheet('1',function(LaravelExcelWorksheet $sheet){
                // Generate an image
                $gdImage = @imagecreatetruecolor(120, 20) or die('Cannot Initialize new GD image stream');
                $textColor = imagecolorallocate($gdImage, 255, 255, 255);
                imagestring($gdImage, 1, 5, 5,  'Created with PhpSpreadsheet', $textColor);

// Add a drawing to the worksheet
                $drawing = new \PHPExcel_Worksheet_MemoryDrawing();
                $drawing->setName('Sample image');
                $drawing->setDescription('Sample image');
                $drawing->setImageResource($gdImage);
                $drawing->setRenderingFunction(\PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
                $drawing->setMimeType(\PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
                $drawing->setHeight(36);
                $drawing->setWorksheet($sheet);
            });

        })->export('xls');

    }
}
