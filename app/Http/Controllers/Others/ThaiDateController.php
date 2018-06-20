<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThaiDateController extends Controller
{
    //Base on ISO 8601
    private  $thai_months;
    private  $short_thai_months;
    private  $thai_days;
    private  $short_thai_days;

    private  $eng_months;
    private  $short_eng_months;
    private  $eng_days;
    private  $short_eng_days;



    public function __construct(){
        //Thai
        $this->thai_months = collect([
            "มกรามก", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ]);
        $this->short_thai_months = collect([
            "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."
        ]);
        $this->thai_days=collect([
            "จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์","อาทิตย์"
        ]);
        $this->short_thai_days = collect([
            "จ.","อ.","พ.","พฤ.","ศ.","ส.","อา."
        ]);

        //Eng
        $this->eng_months = collect(["January","February","March","April","May","June","July",
            "August","September","October","November","December"]);

        $this->short_eng_months = collect(["Jan","Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"]);

        $this->eng_days=collect(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);

        $this->short_eng_days = collect(["Mon","Tues","Wed","thurs","Fri","Sat","Sun"]);
    }

    //****** Month
    //Get Full Month By Eng Name ทั้งแบบเต็มและแบบย่อ
    public function getMonthByEngName ($mothName){
        $monthIndex = $this->eng_months->search(function($month,$index) use($mothName){
            return $month ==$mothName || $this->short_eng_months[$index] == $mothName ;
        });
        return $this->thai_months[$monthIndex];
    }
    //Get Short Month By Name
    public function getShortMonthByEngName ($mothName){
        $monthIndex = $this->eng_months->search(function($month,$index) use($mothName){
            return $month ==$mothName || $this->short_eng_months[$index] == $mothName ;
        });
        return $this->short_thai_months[$monthIndex];

    }
    //Get Full Month By Number
    public function getMonthByNumber($number){
        return $this->thai_months[$number-1];
    }
    //Get Short Month By Number
    public function getShortMonthByNumber($number){
        return $this->short_thai_months[$number-1];
    }

    //*********Day
    public function getDayByEngName($dayName){
        $dayIndex = $this->eng_days->search(function($day,$index) use($dayName){
           return $day == $dayName || $this->thai_days[$index] == $dayName;
        });
        return $this->thai_days[$dayIndex];
    }
    public function getShortDayByEngName($dayName){
        $dayIndex = $this->eng_days->search(function($day,$index) use($dayName){
           return $day == $dayName || $this->thai_days[$index] == $dayName;
        });
        return $this->short_thai_days[$dayIndex];
    }

    public function toBuddhistYear($christianYear){
        return $christianYear+543;
    }


}
