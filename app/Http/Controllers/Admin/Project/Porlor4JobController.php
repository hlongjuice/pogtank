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
        $parent = '';
        //หากมีการระบุเป็น group_for_item ให้ทำการระบุ unit และ namePerUnit
        if ($request->input('group_item_per_unit')) {
            $quantityFactor = $request->input('quantity_factor');
            $unit = $request->input('unit');
            $namePerUnit = $request->input('name') . '(คิดต่อ 1' . ' ' . $unit . ' )';
        }
        //ถ้าเป็นรายการหลัก parent จะเป็นหมวดหมู่ใหญ่สุด
        if ($request->input('parent')['id'] == 0) {
            $parent = Porlor4Job::withDepth()->where('id', $root_job_id)->first();
        } else { //ถ้าไม่ใช้ parent ก็จะเป็นตามรายการที่เลือก
            $parent = Porlor4Job::withDepth()->where('id', $request->input('parent')['id'])->first();
        }
        $page_number = $this->setPageNumber($parent, $request->input('page_number'));
        $job_order_number = $this->setOrderNumber($parent);
        $result = $parent->children()->create([
            'job_order_number' => $job_order_number,
            'porlor_4_id' => $porlor_4_id,
            'name' => $request->input('name'),
            'page_number' => $page_number,
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


            $jobParent = Porlor4Job::withDepth()->where('id', $request->input('child_job')['id'])->first();

            $projectDetails = $request->input('project_details');
            $approvedStatus = GlobalVariableController::$publishedStatus['approved'];
            $page_number = $this->setPageNumber($jobParent, $request->input('page_number'));
            $jobInputs = collect([]);
            $itemInputs = collect([]);

            //วนลูปเก็บรายละเอียด items แต่ละอัน
            foreach ($request->input('items') as $item) {
                $job_order_number = $this->setOrderNumber($jobParent);
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
                        'job_order_number' => $job_order_number,
                        'porlor_4_id' => $porlor_4_id,
                        'name' => $item['material_item']['approved_global_details']['name'],
                        'page_number' => $page_number,
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

    public function setOrderNumber($jobParent)
    {
        $order_number = 0;
        $max_number = $max_number = $jobParent->children()->count();
        if ($jobParent->depth == 0) {
            $order_number = $max_number + 1;
        } else {
            $order_number = $jobParent->job_order_number . '.' . ($max_number + 1);
        }
        return $order_number;
    }

    public function setPageNumber($jobParent, $page_number)
    {

        //Check Page Number
        //เช็คจำนวนลูกๆ
        if ($jobParent->children()->count() > 0) {
            //หากมีลูกๆให้ เลือกหน้าที่สูงที่สุดในกลุ่มลูกๆ
            $latestPage = $jobParent->children()->max('page_number');
            $nextSiblingPage = '';

            //เช็คหน้าสูงสุดในกลุ่มเดียวกัน หากน้อยกว่า ก็ให้ = หน้าสูงสุด
            if ($page_number < $latestPage) {
                $page_number = $latestPage;
            } else {//หากหน้าที่ระบุมากกว่าหน้าสูงสุด ก็ให้ไปเช็คกับ sibling ตัวถัดไปของ parent โดยหากหน้าที่ต้องการมากกว่า sibling ก็ให้ไปใช้หน้าเเดียวกับ sibling ของ parent
                if ($jobParent->getNextSibling() && $jobParent->depth != 0) {
                    $nextSiblingPage = $jobParent->getNextSibling()->page_number;
                    if ($nextSiblingPage < $page_number) {
                        $page_number = $nextSiblingPage;
                    }
                }
            }
        }
        //หากผ่านทุกเงื่อนไข ก็จะได้หน้าตรงตาม input แต่หากไม่เลขหน้าก็จะเปลี่ยนไปตามเงื่อนไขให้ อัตโนมัติ
        return $page_number;
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
//                        'job_order_number' => $child_job->job_order_number,
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
        $parents = Porlor4Job::withDepth()
            ->descendantsOf($job_root_id)
            ->where('is_item', 0)
            ->toFlatTree();
        return response()->json($parents);
    }

    //ใส่ข้อมูลผลรวมของกลุ่มต่างๆไว้ที่ item ตัวสุดท้ายของกลุ่มนั้น เพราะตอนนำไปใช้งาน ส่ง nested ที่แปลงเป็น flat เรีนบร้อยแล้ว
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
            //With Foreach
            if ($parent != '') {
                //เก็บจำนวนลูกทั้งหมดเพื่อใช้ไปเปรียบเทียบตอนจับกลุ่มด้วยหมายเลขหน้า
                $parent->total_children_number = $parent->children->count();
            }
            foreach ($jobs as $key => $job) {
                $job->number = $key + 1;
                // สิ้นสุดการใส่ใหมายเลขลำดับ

                //การคำนวนในส่วนก่อน recursive เป็นการคำนวนราคาจาก job ที่เป็น item
                //is_item คือ หากเป็นรายการวัสดุจะมีการคำนวณราคา
                if ($job->is_item) {
                    //ถ้าหากเป็น item ให้ปรับสถานะกลุ่มแม่ เป็น 1 เพื่อบอกว่าเป็นกลุ่มของ item
                    $parent->has_items = 1;
                    //เป็นการบวกกันใน lv ลูก แต่อัพเดทค่าไปยัง sumPrice ของแม่
                    $job->item->total_price = $job->item->local_price * $job->item->quantity;
                    $job->item->total_wage = $job->item->local_wage * $job->item->quantity;
                    $job->item->sum_total_price_wage = $job->item->total_price + $job->item->total_wage;
                    $parent->sum_total_price += $job->item->total_price;
                    $parent->sum_total_wage += $job->item->total_wage;
                    $parent->sum_total_price_wage = $parent->sum_total_price + $parent->sum_total_wage;
                    //**น่าจะไม่ได้ใช้แล้ว รอ ลบ
                    if ($parent != '') {
                        //ถ้าเป้น item สุดท้ายในกลุ่ม
                        if ($job->number == $parent->total_children_number) {
                            $job->is_last_job = 1;
                            $job->parent_sum_total_price = $parent->sum_total_price;
                            $job->parent_sum_total_wage = $parent->sum_total_wage;
                            $job->parent_sum_total_price_wage = $parent->sum_total_price + $parent->sum_total_wage;
                            $job->parent_name = $parent->name;
                            $job->parent_order_number = $parent->job_order_number;
                            $job->parent_quantity_factor = $parent->quantity_factor;
                            $job->parent_unit = $parent->unit;
                            $job->parent_name_per_unit = $parent->name_per_unit;
                        }
                    }
                    //**รอลบ
                }
                //สมติข้อมูลเป็นดังนี้
                //1->1.1->1.1.1->1.1.2->
                //   1.2,->1.2.1->1.2.2->1.2.3->
                //   1.3->1.3.1->1.3.2
                //2->2.1 ...
                //ในส่วนการทำงาน ด้านบนที่เป็น Recursive นั้น การทำงานจะวน Recursive ไปจนถึง level ในสุดก่อน
                //โดยหากไม่มี level ที่ลึกว่านี้แล้ว ถึงจะขยับไป array ถัดไปใน level เดียวกัน
                //คือ โปรแกรมจะไล่จาก 1,1.1,1.1.1 ถ้าไม่มี level ต่อจาก  1.1.1 แล้วถึงจะไปแล้ว ถึงจะขยับไป 1.1.2
                $calculatePrice($job->children, $job);
                //เริ่ม 1.1.2 หลังจากออกจาก ลูปตรงนี้
                //และหากสิ้นสุด level นี้ที่ 1.1.2 ลำดับถัดไปก็จะเป็น 1.2,1.2.1 และทำแบบเดิมซ้ำไปกว่าจะหมด
                //ตั้งแต่บรรทันนี้คือ การขยับไปยัง Array ตัวถัดไป ใน level เดียวกันหลังจากผ่าน recursive ด้านบนแล้ว
                //และ Recursive ก็จะค่อยๆย้อนการทำงานกลับไปยัง level บนๆไปเรื่อยๆจนถึงการวน foreach สุดท้ายที่ level สูงสุด

                //******** คำนวนผลรวมรายการกลุ่มแยกต่อหน่วย และ นำผลรวมจากกลุ่มเล็กส่งไปกลุ่มแม่ ******************
                //ขั้นตอนด้านล่างเป็นการนำเอาผลรวมของกลุ่มลูกส่งไปยังกลุ่มแม่ที่ level สูงกว่า
                //การทำงานหลังจาก function recursive เสร็จแล้ว $job ตรงส่วนนี้ คือ $parent ของส่วนด้านบน
                //depth > 1 คือ ทำเมื่อไม่ใช่งานแรก
                if ($job->is_item == 0 && $job->depth > 1) {
                    //ถ้าเป็นกลุ่มรายการสินค้าที่แยกคิดต่อหน่วย ก่อนรวม
                    if ($job->group_item_per_unit) {

                        //ถ้าราคารวมมากกว่า 100 ปัดราคาหลักสิบลง เป็น 00
                        if (floor($job->sum_total_price / 100) * 100 > 100) {
                            $job->round_down_sum_total_price = floor($job->sum_total_price / 100) * 100;

                        } //ถ้าน้อยกว่า 100 ปัด หลักหน่วยลง เป็น 0
                        else {
                            $job->round_down_sum_total_price = floor($job->sum_total_price / 10) * 10;
                        }
                        //ถ้าราคารวมมากกว่า 100 ปัดราคาหลักสิบลง เป็น 00
                        if (floor($job->sum_total_wage / 100) * 100 > 100) {
                            $job->round_down_sum_total_wage = floor($job->sum_total_wage / 100) * 100;

                        } //ถ้าน้อยกว่า 100 ปัด หลักหน่วยลง เป็น 0
                        else {
                            $job->round_down_sum_total_wage = floor($job->sum_total_wage / 10) * 10;
                        }
                        //ผลรวม ราคา+ค่าแรง หลังปัดเศษ
                        $job->round_down_sum_total_price_wage = $job->round_down_sum_total_price + $job->round_down_sum_total_wage;

                        //นำผลรวม ราคา+ค่าแรง หลังปัดเศษ คูณกับ จำนวนหน่วยของกลุ่ม
                        $job->group_item_per_unit_sum_total_price = $job->round_down_sum_total_price * $job->quantity_factor;
                        $job->group_item_per_unit_sum_total_wage = $job->round_down_sum_total_wage * $job->quantity_factor;
                        $job->group_item_per_unit_sum_total_price_wage = $job->group_item_per_unit_sum_total_price + $job->group_item_per_unit_sum_total_wage;

                        //Set ผลลัพธ์ต่างๆไว้ที่ item ตัวสุดท้ายของกลุ่ม
                        $lastChildJob = $job->children->last();
                        $lastChildJob->parent_group_item_per_unit = 1;
                        $lastChildJob->parent_round_down_sum_total_price = $job->round_down_sum_total_price;
                        $lastChildJob->parent_round_down_sum_total_wage = $job->round_down_sum_total_wage;
                        $lastChildJob->parent_round_down_sum_total_price_wage = $job->round_down_sum_total_price_wage;
                        $lastChildJob->parent_group_item_per_unit_sum_total_price = $job->group_item_per_unit_sum_total_price;
                        $lastChildJob->parent_group_item_per_unit_sum_total_wage = $job->group_item_per_unit_sum_total_wage;
                        $lastChildJob->parent_group_item_per_unit_sum_total_price_wage = $job->group_item_per_unit_sum_total_price_wage;
                        //ส่งไป ผลบวกยัง parent
                        $parent->sum_total_price += $job->group_item_per_unit_sum_total_price;
                        $parent->sum_total_wage += $job->group_item_per_unit_sum_total_wage;
                        $parent->sum_total_price_wage = $parent->sum_total_price + $parent->sum_total_wage;

                    } else { // กรณีเป็นกลุ่มธรรมดา
                        $parent->sum_total_price += $job->sum_total_price;
                        $parent->sum_total_wage += $job->sum_total_wage;
                        $parent->sum_total_price_wage = $parent->sum_total_price + $parent->sum_total_wage;
                    }

                }
            }

        };

        //Recursive function เพื่อแปลงข้อมูลให้อยู่ใน Flat array คือทุก lv อยู่ในระดับเดียวกัน
//        $toFlatTree = function ($jobs, $order_number = '') use (&$toFlatTree, $jobsFlatTree) {
        $toFlatTree = function ($jobs, &$parent = '') use (&$toFlatTree, $jobsFlatTree) {
            $count = 0;
            foreach ($jobs as $key => $job) {
                $count++;
                $jobsFlatTree->push($job);

                $toFlatTree($job->children, $job);

                //นำหัวกลุ่มของแต่ละกลุ่มไปต่อท้ายลูกของตัวเอง เพื่อนใช้เป็น Row สำหรับสรุปผลการคำนวนเฉพาะกลุ่ม
                if ($parent != null) {
                    $parent->child_count = $count;
                    if ($parent->child_count == $parent->total_children_number) {
                        $sumGroup = collect([]);
                        //กรณีเป็นกลุ่ม แยกต่อหน่วย
                        if ($parent->group_item_per_unit) {
                            $sumGroup = collect([
                                'row_group_result' => 1,
                                'page_number' => $job->page_number,
                                'group_sum_total_price' => $parent->group_item_per_unit_sum_total_price,
                                'group_sum_total_wage' => $parent->group_item_per_unit_sum_total_wage,
                                'group_sum_total_price_wage' => $parent->group_item_per_unit_sum_total_price_wage,
                                'group_order_number' => $parent->job_order_number,
                                'group_depth' => $parent->depth,
                                'depth' => -1
                            ]);
                        } else {//กลุ่มปกติ
                            $sumGroup = collect([
                                'row_group_result' => 1,
                                'page_number' => $job->page_number,
                                'group_sum_total_price' => $parent->sum_total_price,
                                'group_sum_total_wage' => $parent->sum_total_wage,
                                'group_sum_total_price_wage' => $parent->sum_total_price_wage,
                                'group_order_number' => $parent->job_order_number,
                                'group_depth' => $parent->depth,
                                'depth' => -1 // -1 is special depth for result row
                            ]);
                        }
                        $jobsFlatTree->push($sumGroup);
                    }
                }
            }
        };

        $calculatePrice($jobs);
        $toFlatTree($jobs);

        //จำนวนหน้าทั้งหมด
        $total_page = $jobsFlatTree->max('page_number');
        //แบ่งกลุ่มตามหมายเลขหน้า
        $groupPages = $jobsFlatTree->groupBy('page_number');
        //คำนวนผลรวมภายใน 1 หน้า
        foreach ($groupPages as $page => $allJobs) {
            $page_sum = collect([]);

            $bringForward = collect([]);//ยอดยกมา
            $lastRowInPage = collect([]);
            $lastRowInPage['row_page_result'] = 1;
            $lastRowInPage['page_sum_total_price'] = 0;
            $lastRowInPage['page_sum_total_wage'] = 0;
            $lastRowInPage['page_sum_total_price_wage'] = 0;
            $lastRowInPage['last_job_order_number'] = '';
            $lastRowInPage['total_page'] = $total_page;
            $lastRowInPage['page'] = $page;


            foreach ($allJobs as $key => $job) {
                //ถ้าเป้น item เอาเฉพาะ item lv 2 มาคิด
                if ($job['depth'] == 2) {
                    if ($job->is_item) {
                        $lastRowInPage['page_sum_total_price'] += $job['item']['total_price'];
                        $lastRowInPage['page_sum_total_wage'] += $job['item']['total_wage'];
                        $lastRowInPage['page_sum_total_price_wage'] += $job['item']['sum_total_price_wage'];
                        $lastRowInPage['last_job_order_number'] = $job['job_order_number'];
                    }
                }
                //ถ้าเป็นกลุ่มเอาผมรวมของกลุ่ม level 2 มาคิด
                if ($job['group_depth'] == 2 && $job['row_group_result']) {
                    $lastRowInPage['page_sum_total_price'] += $job['group_sum_total_price'];
                    $lastRowInPage['page_sum_total_wage'] += $job['group_sum_total_wage'];
                    $lastRowInPage['page_sum_total_price_wage'] += $job['group_sum_total_price_wage'];
                    $lastRowInPage['last_job_order_number'] = $job['group_order_number'];
                }
                if ($lastRowInPage['last_job_order_number'] == '') {
                    $lastRowInPage['last_job_order_number'] =  $job['job_order_number'];
                }
            }
            //ถ้าไม่ใช้หน้าแรก
            if ($page > 1) {
                $previousPageLastJob = $groupPages[$page - 1]->last();
                $bringForward['bring_forward'] = 1;
                $bringForward['last_job_order_number'] = $previousPageLastJob['last_job_order_number'];
                $bringForward['page_sum_total_price'] = $previousPageLastJob['page_sum_total_price'];
                $bringForward['page_sum_total_wage'] = $previousPageLastJob['page_sum_total_wage'];
                $bringForward['page_sum_total_price_wage'] = $previousPageLastJob['page_sum_total_price_wage'];

                //ถ้าไม่ใช่หน้าแรก ให้บวกกับ ยอดยกมาด้วย
                $lastRowInPage['page_sum_total_price'] += $bringForward['page_sum_total_price'];
                $lastRowInPage['page_sum_total_wage'] += $bringForward['page_sum_total_wage'];
                $lastRowInPage['page_sum_total_price_wage'] += $bringForward['page_sum_total_price_wage'];
                $allJobs->splice(0, 0, $bringForward);
            }
            $allJobs->push($lastRowInPage);
            $pageJob = [
                'page' => $page,
                'jobs' => $allJobs,
                'total_page' => $total_page,
            ];
            $groupJobsByPage->push($pageJob);
        }
//        $totalResult = collect([
//            'data' => $jobs,
//            'result' => $result,
//            'flat' => $jobsFlatTree,
//            'groupJobsByPage' => $groupJobsByPage
//        ]);
//        return response()->json($totalResult);
        return $groupJobsByPage;
    }

    //Calculate Porlor 4 Child Job
    //ไม่ได้รวม Root Job(Lv 0) อยู่ใน Array ต้องหาผลรวม ของ Job Lv 1 อีกที
    public function calculatePorlor4ChildJob($root_job_id){
        //Recursion ด้วย anonymous function
        //&$jobs , &$parent คือ การ send by reference ค่าจะเปลี่ยนให้เองใน function
        $jobs = Porlor4Job::with(['descendants', 'ancestors', 'item.details.approvedGlobalDetails'])
            ->withDepth()->descendantsOf($root_job_id)->toTree();
        $calculatePrice = function (&$jobs, &$parent = '') use (&$calculatePrice) {
            //With Foreach
            if ($parent != '') {
                //เก็บจำนวนลูกทั้งหมดเพื่อใช้ไปเปรียบเทียบตอนจับกลุ่มด้วยหมายเลขหน้า
                $parent->total_children_number = $parent->children->count();
            }
            foreach ($jobs as $key => $job) {
                $job->number = $key + 1;
                // สิ้นสุดการใส่ใหมายเลขลำดับ

                //การคำนวนในส่วนก่อน recursive เป็นการคำนวนราคาจาก job ที่เป็น item
                //is_item คือ หากเป็นรายการวัสดุจะมีการคำนวณราคา
                if ($job->is_item) {
                    //ถ้าหากเป็น item ให้ปรับสถานะกลุ่มแม่ เป็น 1 เพื่อบอกว่าเป็นกลุ่มของ item
                    $parent->has_items = 1;
                    //เป็นการบวกกันใน lv ลูก แต่อัพเดทค่าไปยัง sumPrice ของแม่
                    $job->item->total_price = $job->item->local_price * $job->item->quantity;
                    $job->item->total_wage = $job->item->local_wage * $job->item->quantity;
                    $job->item->sum_total_price_wage = $job->item->total_price + $job->item->total_wage;
                    $parent->sum_total_price += $job->item->total_price;
                    $parent->sum_total_wage += $job->item->total_wage;
                    $parent->sum_total_price_wage = $parent->sum_total_price + $parent->sum_total_wage;
                    //**น่าจะไม่ได้ใช้แล้ว รอ ลบ
                    if ($parent != '') {
                        //ถ้าเป้น item สุดท้ายในกลุ่ม
                        if ($job->number == $parent->total_children_number) {
                            $job->is_last_job = 1;
                            $job->parent_sum_total_price = $parent->sum_total_price;
                            $job->parent_sum_total_wage = $parent->sum_total_wage;
                            $job->parent_sum_total_price_wage = $parent->sum_total_price + $parent->sum_total_wage;
                            $job->parent_name = $parent->name;
                            $job->parent_order_number = $parent->job_order_number;
                            $job->parent_quantity_factor = $parent->quantity_factor;
                            $job->parent_unit = $parent->unit;
                            $job->parent_name_per_unit = $parent->name_per_unit;
                        }
                    }
                    //**รอลบ
                }
                //สมติข้อมูลเป็นดังนี้
                //1->1.1->1.1.1->1.1.2->
                //   1.2,->1.2.1->1.2.2->1.2.3->
                //   1.3->1.3.1->1.3.2
                //2->2.1 ...
                //ในส่วนการทำงาน ด้านบนที่เป็น Recursive นั้น การทำงานจะวน Recursive ไปจนถึง level ในสุดก่อน
                //โดยหากไม่มี level ที่ลึกว่านี้แล้ว ถึงจะขยับไป array ถัดไปใน level เดียวกัน
                //คือ โปรแกรมจะไล่จาก 1,1.1,1.1.1 ถ้าไม่มี level ต่อจาก  1.1.1 แล้วถึงจะไปแล้ว ถึงจะขยับไป 1.1.2
                $calculatePrice($job->children, $job);
                //เริ่ม 1.1.2 หลังจากออกจาก ลูปตรงนี้
                //และหากสิ้นสุด level นี้ที่ 1.1.2 ลำดับถัดไปก็จะเป็น 1.2,1.2.1 และทำแบบเดิมซ้ำไปกว่าจะหมด
                //ตั้งแต่บรรทันนี้คือ การขยับไปยัง Array ตัวถัดไป ใน level เดียวกันหลังจากผ่าน recursive ด้านบนแล้ว
                //และ Recursive ก็จะค่อยๆย้อนการทำงานกลับไปยัง level บนๆไปเรื่อยๆจนถึงการวน foreach สุดท้ายที่ level สูงสุด

                //******** คำนวนผลรวมรายการกลุ่มแยกต่อหน่วย และ นำผลรวมจากกลุ่มเล็กส่งไปกลุ่มแม่ ******************
                //ขั้นตอนด้านล่างเป็นการนำเอาผลรวมของกลุ่มลูกส่งไปยังกลุ่มแม่ที่ level สูงกว่า
                //การทำงานหลังจาก function recursive เสร็จแล้ว $job ตรงส่วนนี้ คือ $parent ของส่วนด้านบน
                //depth > 1 คือ ทำเมื่อไม่ใช่งานแรก
                if ($job->is_item == 0 && $job->depth > 1) {
                    //ถ้าเป็นกลุ่มรายการสินค้าที่แยกคิดต่อหน่วย ก่อนรวม
                    if ($job->group_item_per_unit) {

                        //ถ้าราคารวมมากกว่า 100 ปัดราคาหลักสิบลง เป็น 00
                        if (floor($job->sum_total_price / 100) * 100 > 100) {
                            $job->round_down_sum_total_price = floor($job->sum_total_price / 100) * 100;

                        } //ถ้าน้อยกว่า 100 ปัด หลักหน่วยลง เป็น 0
                        else {
                            $job->round_down_sum_total_price = floor($job->sum_total_price / 10) * 10;
                        }
                        //ถ้าราคารวมมากกว่า 100 ปัดราคาหลักสิบลง เป็น 00
                        if (floor($job->sum_total_wage / 100) * 100 > 100) {
                            $job->round_down_sum_total_wage = floor($job->sum_total_wage / 100) * 100;

                        } //ถ้าน้อยกว่า 100 ปัด หลักหน่วยลง เป็น 0
                        else {
                            $job->round_down_sum_total_wage = floor($job->sum_total_wage / 10) * 10;
                        }
                        //ผลรวม ราคา+ค่าแรง หลังปัดเศษ
                        $job->round_down_sum_total_price_wage = $job->round_down_sum_total_price + $job->round_down_sum_total_wage;

                        //นำผลรวม ราคา+ค่าแรง หลังปัดเศษ คูณกับ จำนวนหน่วยของกลุ่ม
                        $job->group_item_per_unit_sum_total_price = $job->round_down_sum_total_price * $job->quantity_factor;
                        $job->group_item_per_unit_sum_total_wage = $job->round_down_sum_total_wage * $job->quantity_factor;
                        $job->group_item_per_unit_sum_total_price_wage = $job->group_item_per_unit_sum_total_price + $job->group_item_per_unit_sum_total_wage;

                        //Set ผลลัพธ์ต่างๆไว้ที่ item ตัวสุดท้ายของกลุ่ม
                        $lastChildJob = $job->children->last();
                        $lastChildJob->parent_group_item_per_unit = 1;
                        $lastChildJob->parent_round_down_sum_total_price = $job->round_down_sum_total_price;
                        $lastChildJob->parent_round_down_sum_total_wage = $job->round_down_sum_total_wage;
                        $lastChildJob->parent_round_down_sum_total_price_wage = $job->round_down_sum_total_price_wage;
                        $lastChildJob->parent_group_item_per_unit_sum_total_price = $job->group_item_per_unit_sum_total_price;
                        $lastChildJob->parent_group_item_per_unit_sum_total_wage = $job->group_item_per_unit_sum_total_wage;
                        $lastChildJob->parent_group_item_per_unit_sum_total_price_wage = $job->group_item_per_unit_sum_total_price_wage;
                        //ส่งไป ผลบวกยัง parent
                        $parent->sum_total_price += $job->group_item_per_unit_sum_total_price;
                        $parent->sum_total_wage += $job->group_item_per_unit_sum_total_wage;
                        $parent->sum_total_price_wage = $parent->sum_total_price + $parent->sum_total_wage;

                    } else { // กรณีเป็นกลุ่มธรรมดา
                        $parent->sum_total_price += $job->sum_total_price;
                        $parent->sum_total_wage += $job->sum_total_wage;
                        $parent->sum_total_price_wage = $parent->sum_total_price + $parent->sum_total_wage;
                    }

                }
            }

        };

        $calculatePrice($jobs);

        return $jobs;
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
            'name' => 'รายการหลัก',
            'job_order_number' => ''
        ]);
        $parents = Porlor4Job::withDepth()
            ->descendantsOf($job_root_id)
            ->where('is_item', 0)
            ->toFlatTree();
        $parentFlatTree = $parents->prepend($main);
        return response()->json($parentFlatTree);
    }

    //Delete Item //ไม่ได้ใข้
    public function deleteItem($porlor_4_id, $item_id)
    {
        $result = Porlor4JobItem::destroy($item_id);
        return response()->json($result);
    }

    //Delete Child Job
    public function deleteChildJob($porlor_4_id, $child_job_id)
    {
        $result=DB::transaction(function() use ($porlor_4_id,$child_job_id){
            $root = Porlor4Job::with('items')
                ->withDepth()
                ->descendantsAndSelf($child_job_id)->toTree()->first();
            $nextSiblings = $root->nextSiblings()->withDepth()->get();
            //ถ้า มี root มี items ลบ items ของ root
            $root->items()->delete();
            //วบลูปลบ items ของ ลูกๆทั้งหมด
            foreach ($root->children as $child) {
                $child->items()->delete();
            }
            //ลบ root โดยจะลบ descendant ทั้งหมดของ root ไปด้วย
            $root->delete();

            $this->regenerateOrderNumberAfterDeleted($nextSiblings);
        });
        return response()->json($result);
    }
    //Delete Root Job
    public function deleteRootJob($porlor_4_id,$root_job_id){
        $result= DB::transaction(function() use($root_job_id){
           Porlor4Job::destroy($root_job_id);
        });
        return response()->json($result);
    }

    //Regenerate Order Number หลังจาก ลบ job
    public function regenerateOrderNumberAfterDeleted($nextSiblings){
        //Update Job Order Number After Delete
        $updateOrderNumber = function($jobs,$parent_order_number='') use(&$updateOrderNumber) {
            $new_order_number = 0;
            foreach ($jobs as $job) {

                if ($job->depth == 1) {
                    $job->job_order_number = $job->job_order_number - 1;
                    $job->save();
                }
                elseif ($job->depth > 1) {
                    if ($parent_order_number == '') {
                        $beginningNumber = substr($job->job_order_number, 0, -1);
                        $arrayNumber = explode('.',$job->job_order_number);
                        $updateLastNumber = end($arrayNumber)-1; //เอาตัวเลขสุดท้ายแล้วลบจากเดิมไป 1
                        $job->job_order_number = $beginningNumber.$updateLastNumber;
                        $job->save();
                    }else{
                        $arrayNumber =explode('.',$job->job_order_number);
                        $lastNumber = end($arrayNumber);
                        $job->job_order_number = $parent_order_number.$lastNumber;
                        $job->save();
                    }
                }
                $updateOrderNumber($job->children, $job->job_order_number);
            }
        };
        $updateOrderNumber($nextSiblings);
    }

    //Update Child Job
    public function updateChildJob(Request $request, $porlor_4_id){
        $quantityFactor = 0;
        $unit = '';
        $namePerUnit = '';
        //หากมีการระบุเป็น group_for_item ให้ทำการระบุ unit และ namePerUnit
        if ($request->input('group_item_per_unit')) {
            $quantityFactor = $request->input('quantity_factor');
            $unit = $request->input('unit');
            $namePerUnit = $request->input('name') . '(คิดต่อ 1' . ' ' . $unit . ' )';
        }
        $result = Porlor4Job::where('id',$request->input('id'))
            ->update([
            'name' => $request->input('name'),
            'quantity_factor' => $quantityFactor,
            'unit' => $unit,
            'name_per_unit' => $namePerUnit,
            'group_item_per_unit' => $request->input('group_item_per_unit')
        ]);
        return response()->json($result);
    }
    //Update Child Job Item
    public function updateChildJobItem(Request $request,$porlor_4_id){
        $result=DB::transaction(function() use($request,$porlor_4_id){

            $projectDetails = $request->input('project_details');
            $approvedStatus = GlobalVariableController::$publishedStatus['approved'];

            if ($request->input('material_item') != '') {
                //Update Material Item Local Price
                $newLocalPrice = MaterialItemLocalPrice::firstOrCreate([
                    'material_id' =>$request->input('material_item')['id']
                ]);
                $newLocalPrice->priceDetails()->create([
                    'published_id' => $approvedStatus,
                    'local_price_id' => $newLocalPrice->id,
                    'province_id' => $projectDetails['province']['id'],
                    'amphoe_id' => $projectDetails['amphoe']['id'],
                    'district_id' => $projectDetails['district']['id'],
                    'cost' => 0,
                    'price' => $request->input('local_price'),
                    'wage' => $request->input('local_wage')
                ]);
                //End Update Local Price
                //Input for Porlor 4 job
                Porlor4Job::where('id',$request->input('job_id'))
                ->update([
                    'name' => $request->input('material_item')['approved_global_details']['name'],
                ]);
                //Input สำหรับ porlor 4 job Items
                Porlor4JobItem::where('id',$request->input('item_id'))
                ->update([
                    'quantity' => $request->input('quantity'),
                    'material_id' => $request->input('material_item')['id'],
                    'local_price' => $request->input('local_price'),
                    'local_wage' => $request->input('local_wage'),
                    'unit' => $request->input('unit')
                ]);
            }
        });
    }
    //Update Root Job
    public function updateRootJob(Request $request,$porlor_4_id){
        $result=DB::transaction(function() use($request,$porlor_4_id){
            Porlor4Job::where('id',$request->input('porlor_4_job_id'))
                ->update([
                    'name'=>$request->input('root_job_name')
                ]);
        });
        return response()->json($result);
    }
}
