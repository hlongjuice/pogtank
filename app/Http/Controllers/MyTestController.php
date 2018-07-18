<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyTestController extends Controller
{
    public function getText(){
        $text = collect([
            "location" => '/your/uploaded/image/file'
        ]);
        return json_encode(['location' => '/uploaded/image/path/image.png']);
    }
}
