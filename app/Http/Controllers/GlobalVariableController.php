<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalVariableController extends Controller
{
    public static $publishedStatus=[
      'waiting'=>1,
      'approved'=>2,
      'reject'=>3
    ];
    public static function getThaiAlphabetByNumber($number){
        $thaiAlphabet=collect([
            'ก','ข','ค','ง','จ','ฉ','ช','ซ','ฌ','ญ','ฐ','ฑ','ฒ'
            ,'ณ','ด','ต','ถ','ท','ธ','น','บ','ป','ผ','ฝ','พ','ฟ','ภ','ม','ย','ร','ล'
            ,'ว','ศ','ษ','ส','ห','ฬ','อ','ฮ'
        ]);
        if($number<=44){
            return $thaiAlphabet[$number-1];
        }
        return $number;
    }

}
