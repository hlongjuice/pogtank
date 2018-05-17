<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestApi extends Controller
{
    //
    public function getItems(){
        $test='';
        $test->count();
        return view('web.test_api.index');
    }
}
