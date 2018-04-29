<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\GlobalVariableController;
use App\Models\Admin\Material\MaterialItemLocalPrice;
use App\Models\Admin\Project\Porlor4;
use App\Models\Admin\Project\Porlor4Job;
use App\Models\Admin\Project\Porlor4JobItem;
use Carbon\Carbon;
use function foo\func;
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
            $namePerUnit = $request->input('name') . '(คิดต่อ 1' . ' ' . $unit . ' )';
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
            'group_item_per_unit' => $request->input('group_item_per_unit')
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
            foreach ($request->input('items') as $item) {
                //เลือกจัดการเฉพาะ item ที่มีการเลือก material_item
                if ($item['material_item'] != '') {
                    //Update Material Item Local Price
                    $newLocalPrice = MaterialItemLocalPrice::firstOrCreate([
                        'material_id' => $item['material_item']['id']
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
                    $input = collect([
                        'page_number' => $request->input('page_number'),
                        'porlor_4_job_id' => $request->input('child_job')['id'], //id ของจ๊อบที่เป็นกลุ่มย่อยที่เป็น leaf เลยใช่ child job id
                        'quantity' => $item['quantity'],
                        'material_id' => $item['material_item']['id'],
                        'local_price' => $item['local_price'],
                        'local_wage' => $item['local_wage'],
                        'unit' => $item['unit'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    //นำแต่ละ item มาเก็บไว้กับ array itemInputs
                    $itemInputs->push($input);
                }
            }
            $result = Porlor4JobItem::insert($itemInputs->toArray());
            return $result;
        });
        return response()->json($result);


    }

    //Add Child Job Items V2
    public function addChildJobItemsV2(Request $request, $porlor_4_id)
    {
        $result = DB::transaction(function () use ($request, $porlor_4_id) {
            $jobParent = Porlor4Job::where('id', $request->input('child_job')['id'])->first();
            $projectDetails = $request->input('project_details');
            $approvedStatus = GlobalVariableController::$publishedStatus['approved'];
            $jobInputs = collect([]);
            $itemInputs = collect([]);
            //วนลูปเก็บรายละเอียด items แต่ละอัน
            foreach ($request->input('items') as $item) {
                //เลือกจัดการเฉพาะ item ที่มีการเลือก material_item
                if ($item['material_item'] != '') {
                    //Update Material Item Local Price
                    $newLocalPrice = MaterialItemLocalPrice::firstOrCreate([
                        'material_id' => $item['material_item']['id']
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
                    //Input for Porlor 4 job
                    $newJob = $jobParent->children()->create([
                        'job_order_number' => 0,
                        'porlor_4_id' => $porlor_4_id,
                        'name' => $item['material_item']['approved_global_details']['name'],
                        'page_number' => $request->input('page_number'),
                        'quantity_factor' => 0,
                        'unit' => 0,
                        'name_per_unit' => '',
                        'group_item_per_unit' => 0,
                        'is_item' => $request->input('is_item')
                    ]);
                    //Input สำหรับ porlor 4 job Items
                    $itemInput = $newJob->item()->create([
                        'quantity' => $item['quantity'],
                        'material_id' => $item['material_item']['id'],
                        'local_price' => $item['local_price'],
                        'local_wage' => $item['local_wage'],
                        'unit' => $item['unit']
                    ]);
                }
            }
        });
        return response()->json($result);


    }

    //Add Child Job With Details
    public function addChildJobWithDetails()
    {

    }

    //Edit Child Job
    public function editChildJob(Request $request, $porlor_4_id, $root_job_id)
    {
        $quantityFactor = 0;
        $unit = '';
        $namePerUnit = '';
        //หากมีการระบุเป็น group_for_item ให้ทำการระบุ unit และ namePerUnit
        if ($request->input('group_for_item')) {
            $quantityFactor = $request->input('quantity_factor');
            $unit = $request->input('unit');
            $namePerUnit = $request->input('name') . '(คิดต่อ 1' . ' ' . $unit . ' )';
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
            'group_item_per_unit' => $request->input('group_item_per_unit')
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
        $jobs = Porlor4Job::with(['descendants', 'ancestors', 'items.details.approvedGlobalDetails'])
            ->withDepth()->descendantsOf($root_job_id);
        $groupJobs = $jobs->groupBy('page_number');
        $total_page = $jobs->max('page_number');
        $result = collect([]);
        //แยกรายการตามหัวข้อ
        foreach ($groupJobs as $key => $child_jobs) {

            $page_sum_price_wage = collect([ //ตัวแปร ผลรวม ของทุกกลุ่ม ในแต่ละหน้า
                'total_price_wage' => 0,
                'groups' => collect([])
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
                    $item->chk_item = false;
                }
                //คำนวนเฉพาะกลุ่มที่มี item
                if ($child_job->items->count() > 0) {
                    //ผลรวมทั้งหมดก่อนปัด
                    $child_job->sum_total_price = $child_job->items->sum('total_price');
                    $child_job->sum_total_wage = $child_job->items->sum('total_wage');
                    $child_job->sum_total_price_wage = $child_job->sum_total_price + $child_job->sum_total_wage;
                    //ผลรวมทั้งหมดหลังปัดเศษ โดยปัดที่หลักร้อยลง เช่น 2197 เป็น 2100 ปัดหลักร้อยลงเป็นเลข 00
                    $child_job->round_down_sum_total_price = floor($child_job->sum_total_price / 100) * 100;
                    $child_job->round_down_sum_total_wage = floor($child_job->sum_total_wage / 100) * 100;
                    $child_job->round_down_sum_total_price_wage = floor($child_job->sum_total_price_wage / 100) * 100;
                    //ผลรวมราคาหลังปัดเศษลง x จำนวน quantity_factor (สรุปกลุ่มงาน .2)
                    $child_job->leaf_job_total_price = $child_job->round_down_sum_total_price * $child_job->quantity_factor;
                    $child_job->leaf_job_total_wage = $child_job->round_down_sum_total_wage * $child_job->quantity_factor;
                    $child_job->leaf_job_sum_total_price_wage = $child_job->leaf_job_total_price + $child_job->leaf_job_total_wage;
                    //เก็บผลรวมแยกตามกลุ่ม
                    $page_sum_price_wage['groups']->push([
                        'job_order_number' => $child_job->job_order_number,
                        'total_leaf_job_sum_price_wage' => $child_job->leaf_job_sum_total_price_wage
                    ]);
                }
                $child_job->chk_job = false;
            }
            //บันทึกผลรวมของทุกกลุ่มที่อยู่ในหน้าเดียวกัน
            $page_sum_price_wage['total_price_wage'] = $child_jobs->sum('leaf_job_sum_total_price_wage');

            $job = [
                'page' => $key,
                'jobs' => $child_jobs,
                'total_page' => $total_page,
                'page_sum_price_wage' => $page_sum_price_wage
            ];
            $result->push($job);
        }
//        $result->put('total_page',$result->max('page'));
        //เรียงจากน้อยไปมาก
        $result = $result->sortBy('page')->values();
        return response()->json($result);
    }

    //Get All Child Jobs without Items
    public function getAllChildJobsWithOutItems($porlor_4_id, $job_root_id)
    {
        $parents = Porlor4Job::descendantsOf($job_root_id)
            ->where('is_item', 0)
            ->toFlatTree();
        return response()->json($parents);
    }

    public function getAllChildJobsV2($porlor_4_id, $root_job_id)
    {
        $result = collect([]);
        $sumPrice = 0;
        $jobs = Porlor4Job::with(['descendants', 'ancestors', 'item.details.approvedGlobalDetails'])
            ->withDepth()->descendantsOf($root_job_id)->toTree();
        $jobsFlatTree = collect([]);
        $groupJobsByPage = collect([]);
        //Recursion ด้วย anonymous function
        //&$jobs , &$parent คือ การ send by reference ค่าจะเปลี่ยนให้เองใน function
        $calculatePrice = function (&$jobs, &$parent = '') use (&$calculatePrice, $result) {
            //Recursive with for
            /*
            for($i=0;$i<$jobs->count();$i++){
                //is_item คือ หากเป็นรายการวัสดุจะมีการคำนวณราคา
                if ($jobs[$i]->is_item) {
                    //เช็คจำนวน item ทั้งหมดในกลุ่ม
                    //เป็นการบวกกันใน lv ลูก แต่อัพเดทค่าไปยัง sumPrice ของแม่
                    $jobs[$i]->item->total_price = $jobs[$i]->item->local_price * $jobs[$i]->item->quantity;
                    $parent->sum_total_price += $jobs[$i]->item->total_price;
                }
                $calculatePrice($jobs[$i]->children, $jobs[$i]);

                //การทำงานหลังจาก function recursive เสร็จแล้ว $job ตรงส่วนนี้ คือ $parent ของส่วนด้านบน
                //depth > 1 คือ ทำเมื่อไม่ใช่งานแรก
                if ($jobs[$i]->is_item == 0 && $jobs[$i]->depth > 1) {
                    //ถ้าเป็นกลุ่มรายการสินค้าที่แยกคิดต่อหน่วย ก่อนรวม
                    if ($jobs[$i]->group_item_per_unit) {
                        //ถ้าราคารวมมากกว่า 100 ปัดราคาหลักสิบลง เป็น 00
                        if (floor($jobs[$i]->sum_total_price / 100) * 100 > 100) {
                            $jobs[$i]->round_down_sum_total_price = floor($jobs[$i]->sum_total_price / 100) * 100;

                        }
                        //ถ้าน้อยกว่า 100 ปัด หลักหน่วยลง เป็น 0
                        else {
                            $jobs[$i]->round_down_sum_total_price = floor($jobs[$i]->sum_total_price / 10) * 10;
                        }
                        $jobs[$i]->group_item_per_unit_total_price = $jobs[$i]->round_down_sum_total_price * $jobs[$i]->quantity_factor;
                        $parent->sum_total_price += $jobs[$i]->group_item_per_unit_total_price;

                    } else {
                        $parent->sum_total_price += $jobs[$i]->sum_total_price;
                    }

                }
            }
            */
            //With Foreach
            foreach ($jobs as $job) {
                //เก็บจำนวนลูกทั้งหมดเพื่อใช้ไปเปรียบเทียบตอนจับกลุ่มด้วยหมายเลขหน้า
                $job->total_children_number = $job->children->count();
                //is_item คือ หากเป็นรายการวัสดุจะมีการคำนวณราคา
                if ($job->is_item) {
                    //ถ้าหากเป็น item ให้ปรับสถานะกลุ่มแม่ เป็น 1 เพื่อบอกว่าเป็นกลุ่มของ item
                    $parent->has_items = 1;
                    //เช็คจำนวน item ทั้งหมดในกลุ่ม
                    //เป็นการบวกกันใน lv ลูก แต่อัพเดทค่าไปยัง sumPrice ของแม่
                    $job->item->total_price = $job->item->local_price * $job->item->quantity;
                    $parent->sum_total_price += $job->item->total_price;
                }
                $calculatePrice($job->children, $job);

                //การทำงานหลังจาก function recursive เสร็จแล้ว $job ตรงส่วนนี้ คือ $parent ของส่วนด้านบน
                //depth > 1 คือ ทำเมื่อไม่ใช่งานแรก
                if ($job->is_item == 0 && $job->depth > 1) {
                    //ถ้าเป็นกลุ่มรายการสินค้าที่แยกคิดต่อหน่วย ก่อนรวม
                    if ($job->group_item_per_unit) {
                        //ถ้าราคารวมมากกว่า 100 ปัดราคาหลักสิบลง เป็น 00
                        if (floor($job->sum_total_price / 100) * 100 > 100) {
                            $job->round_down_sum_total_price = floor($job->sum_total_price / 100) * 100;

                        }
                        //ถ้าน้อยกว่า 100 ปัด หลักหน่วยลง เป็น 0
                        else {
                            $job->round_down_sum_total_price = floor($job->sum_total_price / 10) * 10;
                        }
                        $job->group_item_per_unit_total_price = $job->round_down_sum_total_price * $job->quantity_factor;
                        $parent->sum_total_price += $job->group_item_per_unit_total_price;

                    } else {
                        $parent->sum_total_price += $job->sum_total_price;
                    }

                }
            }

        };

        //Recursive function เพื่อแปลงข้อมูลให้อยู่ใน Flat array คือทุก lv อยู่ในระดับเดียวกัน
        $toFlatTree = function($jobs,$order_number ='') use(&$toFlatTree,$jobsFlatTree){
            foreach ($jobs as $key=>$job){
                if($job->depth==1){
                    $job->order_number=$key+1;
                }else{
                    $job->order_number=$order_number.'.'.($key+1);
                }
                $jobsFlatTree->push($job);
                $toFlatTree($job->children,$job->order_number);
            }
        };

        $calculatePrice($jobs);
        $toFlatTree($jobs);

        //แบ่งกลุ่มตามหมายเลขหน้า
        $groupJobsByPage = $jobsFlatTree->groupBy('page_number')->values();
        $totalResult = collect([
            'data' => $jobs,
            'result' => $result,
            'flat' => $jobsFlatTree,
            'groupJobsByPage'=>$groupJobsByPage
        ]);

        return response()->json($totalResult);
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
        $parents = Porlor4Job::descendantsOf($job_root_id)
            ->where('is_item', 0)
            ->toFlatTree();
        $parents = $parents->prepend($main);
        return response()->json($parents);
    }

    //Delete Item
    public function deleteItem($porlor_4_id, $item_id)
    {
        $result = Porlor4JobItem::destroy($item_id);
        return response()->json($result);
    }

    //Delete Child Job
    public function deleteChildJob($porlor_4_id, $child_job_id)
    {
        $root = Porlor4Job::with('items')->descendantsAndSelf($child_job_id)->toTree()->first();
        //ถ้า มี root มี items ลบ items ของ root
        $root->items()->delete();
        //วบลูปลบ items ของ ลูกๆทั้งหมด
        foreach ($root->children as $child) {
            $child->items()->delete();
        }
        //ลบ root โดยจะลบ descendant ทั้งหมดของ root ไปด้วย
        $root->delete();
        return response()->json($root);
    }
}
