<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\GlobalVariableController;
use App\Models\Admin\Material\MaterialItemLocalPrice;
use App\Models\Admin\Project\Porlor4;
use App\Models\Admin\Project\Porlor4Job;
use App\Models\Admin\Project\Porlor4JobItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class Porlor4JobController extends Controller
{
    public function index($porlor_4_id)
    {
        $porlor4 = Porlor4::with('projectDetails', 'part')->where('id', $porlor_4_id)->first();
        return view('admin.project_order.porlor_4.porlor_4_job.porlor_4_job_index')
            ->with('porlor4', $porlor4);
    }

    //Add New Jobs
    public function addRootJob(Request $request, $id)
    {
        $result = Porlor4Job::create([
            'porlor_4_id' => $id,
            'name' => $request->input('root_job_name'),
        ]);
        return response()->json($result);
    }

    //Add Child Job
    public function addChildJob(Request $request, $porlor_4_id, $root_job_id)
    {
        $quantityFactor = 0;
        $unit = '';
        $namePerUnit = '';
        //หากมีการระบุเป็น group_for_item ให้ทำการระบุ unit และ namePerUnit
        if ($request->input('group_item_per_unit')) {
            $quantityFactor = $request->input('quantity_factor');
            $unit = $request->input('unit');
            $namePerUnit = $request->input('name') . '(คิดต่อ 1'. ' ' . $unit . ' )';
        }
        //ถ้าเป็นรายการหลัก parent จะเป็นหมวดหมู่ใหญ่สุด
        if ($request->input('parent')['id'] == 0) {
            $parent = Porlor4Job::where('id', $root_job_id)->first();
        } else { //ถ้าไม่ใช้ parent ก็จะเป็นตามรายการที่เลือก
            $parent = Porlor4Job::where('id', $request->input('parent')['id'])->first();
        }
        $result = $parent->children()->create([
            'job_order_number' => $request->input('job_order_number'),
            'porlor_4_id' => $porlor_4_id,
            'name' => $request->input('name'),
            'page_number' => $request->input('page_number'),
            'quantity_factor' => $quantityFactor,
            'unit' => $unit,
            'name_per_unit' => $namePerUnit,
            'group_item_per_unit'=>$request->input('group_item_per_unit')
        ]);
        return response()->json($result);
    }

    //Add Child Job Items
    public function addChildJobItems(Request $request, $porlor_4_id)
    {
        $result = DB::transaction(function () use ($request, $porlor_4_id) {
            $projectDetails = $request->input('project_details');
            $approvedStatus = GlobalVariableController::$publishedStatus['approved'];
            $itemInputs = collect([]);
            //วนลูปเก็บรายละเอียด items แต่ละอัน
            foreach($request->input('items') as $item){
                //เลือกจัดการเฉพาะ item ที่มีการเลือก material_item
                if($item['material_item'] != ''){
                    //Update Material Item Local Price
                    $newLocalPrice = MaterialItemLocalPrice::firstOrCreate([
                       'material_id'=>$item['material_item']['id']
                    ]);
                    $newLocalPrice->priceDetails()->create([
                        'published_id' => $approvedStatus,
                        'local_price_id' => $newLocalPrice->id,
                        'province_id' => $projectDetails['province']['id'],
                        'amphoe_id' => $projectDetails['amphoe']['id'],
                        'district_id' => $projectDetails['district']['id'],
                        'cost' => 0,
                        'price' => $item['local_price'],
                        'wage' => $item['local_wage']
                    ]);
                    //End Update Local Price
                    $input =collect([
                        'page_number'=>$request->input('page_number'),
                        'porlor_4_job_id' => $request->input('child_job')['id'], //id ของจ๊อบที่เป็นกลุ่มย่อยที่เป็น leaf เลยใช่ child job id
                        'quantity' => $item['quantity'],
                        'material_id' => $item['material_item']['id'],
                        'local_price' => $item['local_price'],
                        'local_wage' => $item['local_wage'],
                        'unit' => $item['unit'],
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now()
                    ]);
                    //นำแต่ละ item มาเก็บไว้กับ array itemInputs
                    $itemInputs->push($input);
                }
            }
            $result=Porlor4JobItem::insert($itemInputs->toArray());
            return $result;
        });
        return response()->json($result);


    }

    //Add Child Job With Details
    public function addChildJobWithDetails()
    {

    }

    //Edit Child Job
    public function editChildJob(Request $request,$porlor_4_id,$root_job_id){
        $quantityFactor = 0;
        $unit = '';
        $namePerUnit = '';
        //หากมีการระบุเป็น group_for_item ให้ทำการระบุ unit และ namePerUnit
        if ($request->input('group_for_item')) {
            $quantityFactor = $request->input('quantity_factor');
            $unit = $request->input('unit');
            $namePerUnit = $request->input('name') . '(คิดต่อ 1'. ' ' . $unit . ' )';
        }
        //ถ้าเป็นรายการหลัก parent จะเป็นหมวดหมู่ใหญ่สุด
        if ($request->input('parent')['id'] == 0) {
            $parent = Porlor4Job::where('id', $root_job_id)->first();
        } else { //ถ้าไม่ใช้ parent ก็จะเป็นตามรายการที่เลือก
            $parent = Porlor4Job::where('id', $request->input('parent')['id'])->first();
        }
        $result = $parent->children()->create([
            'job_order_number' => $request->input('job_order_number'),
            'porlor_4_id' => $porlor_4_id,
            'name' => $request->input('name'),
            'page_number' => $request->input('page_number'),
            'quantity_factor' => $quantityFactor,
            'unit' => $unit,
            'name_per_unit' => $namePerUnit,
            'group_item_per_unit'=>$request->input('group_item_per_unit')
        ]);
        return response()->json($result);
    }
    //Get All Root Jobs
    public function getAllRootJobs($id)
    {
        //Get Only Root Jobs
        $jobs = Porlor4Job::where('porlor_4_id', $id)->whereIsRoot()->get();
        return response()->json($jobs);
    }
    //Get All Child Jobs
    //แบ่งกลุ่มงานย่อยตาม หน้า ปร.4
    public function getAllChildJobs($porlor_4_id, $root_job_id)
    {
        $jobs = Porlor4Job::with(['descendants','ancestors', 'items.details.approvedGlobalDetails'])
            ->withDepth()->descendantsOf($root_job_id);
        $groupJobs = $jobs->groupBy('page_number');
        $total_page = $jobs->max('page_number');
        $result = collect([]);
        //แยกรายการตามหัวข้อ
        foreach ($groupJobs as $key => $child_jobs) {

            $page_sum_price_wage =collect([ //ตัวแปร ผลรวม ของทุกกลุ่ม ในแต่ละหน้า
                'total_price_wage'=>0,
                'groups'=>collect([])
            ]);
            //วนลูป child_jobs เพื่อจะเข้าถึง items ในแต่ละ job
            foreach ($child_jobs as $child_job) {
                //วนลูป items เพื่อคำนวนรายการค่าใช้จ่ายต่อรายการ
                foreach ($child_job->items as $item) {
                    //ผลรวมค่าวัสดุ
                    $item->total_price = $item->quantity * $item->local_price;
                    //ผลรวมค่าแรง
                    $item->total_wage = $item->quantity * $item->local_wage;
                    $item->sum_total_price_wage = $item->total_price + $item->total_wage;
                    //For Check Box
                    $item->chk_item=false;
                }
                //คำนวนเฉพาะกลุ่มที่มี item
                if($child_job->items->count() > 0){
                    //ผลรวมทั้งหมดก่อนปัด
                    $child_job->sum_total_price = $child_job->items->sum('total_price');
                    $child_job->sum_total_wage = $child_job->items->sum('total_wage');
                    $child_job->sum_total_price_wage = $child_job->sum_total_price + $child_job->sum_total_wage;
                    //ผลรวมทั้งหมดหลังปัดเศษ โดยปัดที่หลักร้อยลง เช่น 2197 เป็น 2100 ปัดหลักร้อยลงเป็นเลข 00
                    $child_job->round_down_sum_total_price = floor($child_job->sum_total_price/100)*100;
                    $child_job->round_down_sum_total_wage = floor($child_job->sum_total_wage/100)*100;
                    $child_job->round_down_sum_total_price_wage = floor($child_job->sum_total_price_wage/100)*100;
                    //ผลรวมราคาหลังปัดเศษลง x จำนวน quantity_factor (สรุปกลุ่มงาน .2)
                    $child_job->leaf_job_total_price = $child_job->round_down_sum_total_price * $child_job->quantity_factor;
                    $child_job->leaf_job_total_wage = $child_job->round_down_sum_total_wage * $child_job->quantity_factor;
                    $child_job->leaf_job_sum_total_price_wage = $child_job->leaf_job_total_price + $child_job->leaf_job_total_wage;
                    //เก็บผลรวมแยกตามกลุ่ม
                    $page_sum_price_wage['groups']->push([
                        'job_order_number'=>$child_job->job_order_number,
                        'total_leaf_job_sum_price_wage'=>$child_job->leaf_job_sum_total_price_wage
                    ]);
                }
                $child_job->chk_job=false;
            }
            //บันทึกผลรวมของทุกกลุ่มที่อยู่ในหน้าเดียวกัน
            $page_sum_price_wage['total_price_wage']=$child_jobs->sum('leaf_job_sum_total_price_wage');

            $job = [
                'page' => $key,
                'jobs' => $child_jobs,
                'total_page' => $total_page,
                'page_sum_price_wage'=>$page_sum_price_wage
            ];
            $result->push($job);
        }
//        $result->put('total_page',$result->max('page'));
        //เรียงจากน้อยไปมาก
        $result = $result->sortBy('page')->values();
        return response()->json($result);
    }

    //Get All Child Jobs without Items
    public function getAllChildJobsWithOutItems($porlor_4_id, $job_root_id){
        $parents = Porlor4Job::descendantsOf($job_root_id)->toFlatTree();
        return response()->json($parents);
    }

    public function getAllChildJobsV2($porlor_4_id,$root_job_id){
        $jobs = Porlor4Job::with(['descendants','ancestors', 'items.details.approvedGlobalDetails'])
            ->withDepth()->descendantsOf($root_job_id);
        $groupJobs = $jobs->groupBy('page_number');
        $total_page = $jobs->max('page_number');
        $result = collect([]);
        //แยกรายการตามหัวข้อ
        foreach ($groupJobs as $key => $child_jobs) {
            $page_sum_price_wage =collect([ //ตัวแปร ผลรวม ของทุกกลุ่ม ในแต่ละหน้า
                'total_price_wage'=>0,
                'groups'=>collect([])
            ]);
            //วนลูป child_jobs เพื่อจะเข้าถึง items ในแต่ละ job
            foreach ($child_jobs as $child_job) {
                //วนลูป items เพื่อคำนวนรายการค่าใช้จ่ายต่อรายการ
                foreach ($child_job->items as $item) {
                    //ผลรวมค่าวัสดุ
                    $item->total_price = $item->quantity * $item->local_price;
                    //ผลรวมค่าแรง
                    $item->total_wage = $item->quantity * $item->local_wage;
                    $item->sum_total_price_wage = $item->total_price + $item->total_wage;
                    //For Check Box
                    $item->chk_item=false;
                }
                //คำนวนเฉพาะกลุ่มที่มี item
                if($child_job->items->count() > 0){
                    //ผลรวมทั้งหมดก่อนปัด
                    $child_job->sum_total_price = $child_job->items->sum('total_price');
                    $child_job->sum_total_wage = $child_job->items->sum('total_wage');
                    $child_job->sum_total_price_wage = $child_job->sum_total_price + $child_job->sum_total_wage;
                    //ผลรวมทั้งหมดหลังปัดเศษ โดยปัดที่หลักร้อยลง เช่น 2197 เป็น 2100 ปัดหลักร้อยลงเป็นเลข 00
                    $child_job->round_down_sum_total_price = floor($child_job->sum_total_price/100)*100;
                    $child_job->round_down_sum_total_wage = floor($child_job->sum_total_wage/100)*100;
                    $child_job->round_down_sum_total_price_wage = floor($child_job->sum_total_price_wage/100)*100;
                    //ผลรวมราคาหลังปัดเศษลง x จำนวน quantity_factor (สรุปกลุ่มงาน .2)
                    $child_job->leaf_job_total_price = $child_job->round_down_sum_total_price * $child_job->quantity_factor;
                    $child_job->leaf_job_total_wage = $child_job->round_down_sum_total_wage * $child_job->quantity_factor;
                    $child_job->leaf_job_sum_total_price_wage = $child_job->leaf_job_total_price + $child_job->leaf_job_total_wage;
                    //เก็บผลรวมแยกตามกลุ่ม
                    $page_sum_price_wage['groups']->push([
                        'job_order_number'=>$child_job->job_order_number,
                        'total_leaf_job_sum_price_wage'=>$child_job->leaf_job_sum_total_price_wage
                    ]);
                }
                $child_job->chk_job=false;
            }
            //บันทึกผลรวมของทุกกลุ่มที่อยู่ในหน้าเดียวกัน
            $page_sum_price_wage['total_price_wage']=$child_jobs->sum('leaf_job_sum_total_price_wage');

            $job = [
                'page' => $key,
                'jobs' => $child_jobs,
                'total_page' => $total_page,
                'page_sum_price_wage'=>$page_sum_price_wage
            ];
            $result->push($job);
        }
//        $result->put('total_page',$result->max('page'));
        //เรียงจากน้อยไปมาก
        $result = $result->sortBy('page')->values();
        return response()->json($result);
    }

    //Get Leaf Job
    //กลุ่มงานย่อยหน่วยสุดท้าย ซึ่งจะมีรายการวัสดุเป็นสมาชิกในกลุ่ม
    public function getAllLeafJobs($porlor_4_id, $root_job_id)
    {
        $leafJobs = Porlor4Job::whereIsLeaf()
            ->descendantsOf($root_job_id);
        return response()->json($leafJobs);
    }

    //Get Part Details
    public function getPartDetails($id)
    {
        $porlor4 = Porlor4::with('part')
            ->where('id', $id)->first();
        $part = $porlor4->part;
        return response()->json($part);
    }

    //Get All Job Parents
    public function getParentJobs($porlor_4_id, $job_root_id)
    {
        $main = collect([
            'id' => 0,
            'name' => 'รายการหลัก'
        ]);
        $parents = Porlor4Job::descendantsOf($job_root_id)->toFlatTree();
//        dd($parents->toJson());
        $parents = $parents->prepend($main);
        return response()->json($parents);
    }
    //Delete Item
    public function deleteItem($porlor_4_id,$item_id){
        $result = Porlor4JobItem::destroy($item_id);
        return response()->json($result);
    }
    //Delete Child Job
    public function deleteChildJob($porlor_4_id,$child_job_id){
        $root = Porlor4Job::with('items')->descendantsAndSelf($child_job_id)->toTree()->first();
        //ถ้า มี root มี items ลบ items ของ root
        $root->items()->delete();
        //วบลูปลบ items ของ ลูกๆทั้งหมด
        foreach ($root->children as $child){
            $child->items()->delete();
        }
        //ลบ root โดยจะลบ descendant ทั้งหมดของ root ไปด้วย
        $root->delete();
        return response()->json($root);
    }
}
