<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Admin\Project\Porlor4;
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

    //เลือกเฉพาะ Part ที่ยังไม่ได้ใช้ในโปรเจค
    public function getAvailablePart($project_order_id,$porlor_4_id){
        //เลือก part_id ของโปรเจคทุกอันยกเว้น อันที่ระบุ porlor_4_id เพื่อใช้กรอง part_id ที่ยังว่าง
        $partIDs = Porlor4::where('project_order_id',$project_order_id)
            ->where('id','!=',$porlor_4_id)
            ->get()
            ->pluck('part_id')
            ->toArray();
        //จากนั้นเลือก เอาเฉพาะ part_id ที่ไม่ได้อยู่ในกลุ่มด้านบน
        $availableParts = Porlor4Part::whereNotIn('id',$partIDs)->get();
        return response()->json($availableParts);
    }
}
