<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyTestController extends Controller
{
    public function getText(){
        $text = 'Yooo!';
        return response()->json($text);
    }
}
