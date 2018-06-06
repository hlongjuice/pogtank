<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Admin\Project\Porlor4;
use App\Models\Admin\Project\Porlor4Job;
use App\Models\Admin\Project\ProjectOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Project;
use DB;

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
        $porlor4_parts= Porlor4::where('project_order_id',$order_id)->get();
        $max_position = $porlor4_parts->max('position');
        $page_count = $porlor4_parts->max('page_number');
        $result = Porlor4::create([
            'project_order_id' => $order_id,
            'part_id' => $request->input('part')['id'],
            'page_number'=>$page_count+1,
            'position'=>$max_position+1
        ]);
        return response()->json($result);
    }

    //Get All Project Porlor4  Part
    public function getAllParts($order_id)
    {
        $parts = Porlor4::with('part')
            ->where('project_order_id', $order_id)
            ->orderBy('position')
            ->get();
        // Sort By Part Position ของ Part Relation
//        $newParts = $parts->sortBy(function($item){
//            return $item->part->position;
//        })->values()->all(); //ต้อง ใช้ method values ด้วยทุกครั้งที่มีการ sortBy โดย method all แปลงจาก collection เป็น array
        return response()->json($parts);
    }

    //Get Project Details
    public function getProjectDetails($order_id)
    {
        $details = ProjectOrder::with(['province', 'amphoe', 'district'])
            ->where('id', $order_id)->first();
        return response()->json($details);
    }
    //Delete Single Porlor 4
    public function deletePart($porlor_4_id){
        $result=DB::transaction(function() use ($porlor_4_id){
            $porlor4_part = Porlor4::where('id',$porlor_4_id)->first();
            //เลือก records ที่มีหมายเลขหน้ามากกว่ารายการที่เลือก
            $all_project_parts= Porlor4::where('project_order_id',$porlor4_part->project_order_id)->get();
            $next_records_by_page = $all_project_parts->where('page_number','>',$porlor4_part->page_number);
            $next_records_by_position = $all_project_parts->where('position','>',$porlor4_part->position);
            //วนลูป records by page ที่พบทั้งหมด จากนั้น page_number มา -1
            foreach ($next_records_by_page as $record){
                $record->page_number--;
                $record->save();
            }
            //วนลูป records by position ที่พบทั้งหมด และ ทำการ -1 ทุก position
            foreach ($next_records_by_position as $item){
                $item->position--;
                $item->save();
            }

            Porlor4::where('id',$porlor_4_id)->delete();
        });
        return response()->json($result);
    }

    //Update Part
    public function updatePart(Request $request){
        $result=DB::transaction(function () use($request){
            Porlor4::where('id',$request->input('porlor_4_id'))
                ->update([
                   'part_id'=>$request->input('part')['id']
                ]);
        });
        return response()->json($result);
    }
}
