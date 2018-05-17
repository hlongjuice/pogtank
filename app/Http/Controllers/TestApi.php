<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestApi extends Controller
{
    //
    public function getItems(){

        return view('web.test_api.index');
    }
}
