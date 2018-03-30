<?php

namespace App\Http\Controllers\Admin\City;

use App\Models\City\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function getProvinces()
    {
        $provinces = Province::with(['amphoes' => function ($query) {
            $query->orderBy('name', 'ASC');
        }])->orderBy('name', 'ASC')->get();
        return response()->json($provinces);
    }
}
