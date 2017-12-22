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
}
