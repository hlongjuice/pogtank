<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Admin\Project\Porlor4;
use App\Models\Admin\Project\ProjectOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Project;

class Porlor4Controller extends Controller
{
    //index
    public function index($order_id)
    {
        $order = ProjectOrder::with('porlor4')
            ->where('id', $order_id)->first();
        return view('admin.project_order.porlor_4.index')
            ->with([
                'order' => $order
            ]);
    }

    //Add Part
    public function addNewPart(Request $request, $order_id)
    {
        $result = Porlor4::create([
            'project_order_id' => $order_id,
            'part_id' => $request->input('part')['id']
        ]);
        return response()->json($result);
    }

    //Get All Part
    public function getAllParts($order_id)
    {
        $parts = Porlor4::with('part')
            ->where('project_order_id', $order_id)
            ->get();
        // Sort By Part Position
        $newParts = $parts->sortBy(function($item){
            return $item->part->position;
        })->values()->all(); //ต้อง ใช้ method values ด้วยทุกครั้งที่มีการ sortBy โดย method all แปลงจาก collection เป็น array
        return response()->json($newParts);
    }

    //Get Project Details
    public function getProjectDetails($order_id)
    {
        $details = ProjectOrder::with(['province', 'amphoe', 'district'])
            ->where('id', $order_id)->first();
        return response()->json($details);
    }
}
