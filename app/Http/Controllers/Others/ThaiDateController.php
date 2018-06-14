<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThaiDateController extends Controller
{
    //Base on ISO 8601
    private static $month = [
        "มกรามก", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
    ];
    private $short_month =[
        "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."
    ];
    private $day=[
        "จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์","อาทิตย์"
    ];
    private $short_day=[
        "จ.","อ.","พ.","พฤ.","ศ.","ส.","อา."
    ];

    public static function getMonthByName ($mothName){
        return self::$month[0];
    }
    public function test(){
        echo 'Yo';
    }

}
