<?php

namespace App\Http\Controllers\Admin\Materials;

use App\Http\Controllers\GlobalVariableController;
use App\Models\Admin\Material\MaterialItem;
use App\Models\Admin\Material\MaterialItemVersion;
use App\Models\Admin\Material\MaterialType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NewItemsController extends Controller
{
    private $publishedStatus = '';
    public function __construct()
    {
        $this->publishedStatus = GlobalVariableController::$publishedStatus;
    }
    //ส่วนที่ใช้งาน
    //หน้า porlor 4 เพิ่มตอนเลือกรายการ items
    public function addNewOtherItem(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            //รายการที่เพิ่มจากหน้าใช้งานจะอยู่ในหมวดหมู่ อื่นๆ
            //โดยหากยังไม่มีหมวดหมู่อื่นๆก็จะสร้างใหม่ให้อัตโนมัติ
            $type = MaterialType::firstOrCreate([
                'code_prefix' => 'ae',
                'name' => 'อื่นๆ'
            ]);
            $publishedStatus = GlobalVariableController::$publishedStatus['approved'];
            $newItem = MaterialItem::create([
                    'type_id' => $type->id,
                    'published_id' => $publishedStatus
                ]);
            //Count number of material and plus 1 for new material
            $lastedID = $type->items()->count() + 1;
            //Combined code prefix of type with lastedID for coding material
            $codePrefix = $type->code_prefix . str_pad($lastedID, 5, '0', STR_PAD_LEFT);
            $itemInputs = [
                'published_id' => $publishedStatus,
                'material_id' => $newItem->id,
                'name' => $request->input('material_item')['name'],
                'code' => $codePrefix,
                'type_id' => $type->id,
                'unit' => '',
                'global_cost' => 0,
                'global_price' => 0,
                'global_wage' => 0,
                'invoice_cost' => 0,
                'invoice_price' => 0,
                'invoice_wage' => 0
            ];
            //Add Item Global Price and  Details First version
            $newItem->globalDetails()->create($itemInputs);
            $newItem->approved_global_details = $newItem->approvedGlobalDetails;
            return $newItem;
        });
        return response()->json($result);
    }

    //Delete Approved Items
    public function deleteApprovedItems(Request $request){
        $result= DB::transaction(function() use ($request){
            $item_ids= array_pluck($request->input('approved_items'),'id');
            MaterialItem::destroy($item_ids);
        });
        return response()->json($result);
    }
    //Delete Waiting Items
    public function deleteWaitingItems(Request $request){
        $result= DB::transaction(function() use ($request){
            MaterialItem::destroy($request->input('waiting_items'));
        });
        return response()->json($result);
    }

    //Get First 50 Items
    public function getApprovedItems()
    {
        $items = MaterialItem::with('approvedGlobalDetails','published')
            ->where('published_id', $this->publishedStatus['approved'])
            ->take(50)
            ->get();
        return response()->json($items);
    }
    //Get Approved Items Group By Page
    public function getApprovedItemsByPage(){
        $items = MaterialItem::with('approvedGlobalDetails','published')
            ->where('published_id', $this->publishedStatus['approved'])
            ->paginate(10);
        return response()->json($items);
    }
    //Get Waiting Items
    public function getWaitingItems(){
        //Items that Approved and get lasted approved Details
        $waitingMaterials = MaterialItem::with('published', 'waitingGlobalDetails', 'approvedGlobalDetails')
            ->has('waitingGlobalDetails')
            ->orHas('waitingLocalPrices')
            ->paginate(50);
        return response()->json($waitingMaterials);
    }

    //Search Items By Name
    public function searchItemsByName(Request $request)
    {
        $items = MaterialItem::with('approvedGlobalDetails')
            ->whereHas('approvedGlobalDetails', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('material_name') . '%');
            })
            ->take(100)
            ->get();
        return response()->json($items);
    }
}
