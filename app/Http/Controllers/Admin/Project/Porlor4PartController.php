<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Admin\Project\Porlor4Part;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Porlor4PartController extends Controller
{
    //index
    public function index()
    {
        return view('admin.porlor_4_part.index');
    }

    //Add New Part
    public function addNewPart(Request $request)
    {
        $latestPosition = Porlor4Part::max('position');
        $result = Porlor4Part::create([
            'name' => $request->input('part_name'),
            'position' => $latestPosition + 1
        ]);
        return response()->json($result);
    }

    public function getAll()
    {
        $parts = Porlor4Part::orderBy('id', 'ASC')->get();
        return response()->json($parts);
    }
}
