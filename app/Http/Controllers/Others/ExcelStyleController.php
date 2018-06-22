<?php

namespace App\Http\Controllers\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExcelStyleController extends Controller
{
    //Green
    const tableHeaderColor = 'CDD5B4';
    const tableTotalResultColor ='CDD5B4';
    const rowResultColor = 'DAE3C0';

    //Formatting
    const formatCode =[
      'accounting'=>  '_-* #,##0.00_-;-* #,##0.00_-;_-* "-"??_-;_-@_-'
    ];
}
