<?php

namespace App\Http\Controllers\Admin\Project\Porlor5;

use App\Models\Admin\Project\Porlor4;
use App\Models\Admin\Project\ProjectOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Porlor5Controller extends Controller
{
    public function getPorlor5($project_order_id){
        $allPorlor4Parts = ProjectOrder::with('porlor4.jobs')->where('id',$project_order_id)->get();
        foreach ($allPorlor4Parts as $allPorlor4Part){
            $root_job = $allPorlor4Part->jobs()->where('parent_id',null)->first();
            $allPorlor4Part->root_job = $root_job;
            $this->calculatePorlor4($root_job->id);
        }
        return response()->json($allPorlor4Parts);
    }
    public function calculatePorlor4($root_job_id){
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


        $calculatePrice($jobs);

        return ;
    }
}
