<?php

namespace App\Http\Controllers\Admin\Materials;

use App\Http\Controllers\GlobalVariableController;
use App\Models\Admin\Material\MaterialItem;
use App\Models\Admin\Material\MaterialItemLocalPrice;
use App\Models\Admin\Material\MaterialItemLocalPriceVersion;
use App\Models\Admin\Material\MaterialItemVersion;
use App\Models\Admin\Material\MaterialType;
use App\Models\Admin\Material\Vendor;
use App\Models\Admin\PublishedStatus;
use App\Models\City\District;
use App\Models\City\Province;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use Kalnoy\Nestedset\Collection;

class ItemsController extends Controller
{
    private $indexRoute = '';
    private $publishedStatus = '';

    public function __construct()
    {
        $this->indexRoute = url('admin/materials/items/submitted');
        $this->publishedStatus = GlobalVariableController::$publishedStatus;
    }

    //Add Local Price
    public function addLocalPrice(Request $request)
    {
        $publishedID = $this->publishedStatus['waiting'];
        if (Auth::user()->hasRole('admin')) {
            $publishedID = $this->publishedStatus['approved'];
        }
        $result = DB::transaction(function () use ($request, $publishedID) {
            //Loop for All Local Prices Inputs
            foreach ($request->input('cities') as $city) {
                if ($city['province'] != null) {
                    //Insert Local Price ID
                    $newLocalPrice = MaterialItemLocalPrice::create([
                        'material_id' => $request->input('material_id')
                    ]);
                    //Insert Local Price Details
                    $newLocalPrice->priceDetails()
                        ->create([
                            'published_id' => $publishedID,
                            'local_price_id' => $newLocalPrice->id,
                            'province_id' => $city['province']['id'],
                            'amphoe_id' => $city['amphoe']['id'],
                            'district_id' => $city['district']['id'],
                            'cost' => $city['localCost'],
                            'price' => $city['localPrice'],
                            'wage' => $city['wage']
                        ]);
                }
            }
        });
        return response()->json($result);
    }
    //Note For Index
    //Index number 0 is latest update
    public function index()
    {
        $data = $this->indexProcess();
        return view('admin.materials.items.index')
            ->with([
                'waitingMaterials' => $data['waitingMaterials'],
                'approvedMaterials' => $data['approvedMaterials'],
                'submitted' => 0
            ]);
    }

    //Index After Submitted
    public function indexAfterSubmit($status)
    {
        $data = $this->indexProcess();
        return view('admin.materials.items.index')
            ->with([
                'waitingMaterials' => $data['waitingMaterials'],
                'approvedMaterials' => $data['approvedMaterials'],
                'submitted' => $status
            ]);
    }

    //Process Data all index methods
    //ใช้สำหรับ Get Items หน้า Materials Index
    public function indexProcess()
    {
        //Get All Items that have waiting process maybe GlobalWaiting or LocalWaiting
        $waitingMaterials = MaterialItem::with('published', 'waitingGlobalDetails', 'approvedGlobalDetails')
//            ->where('waiting_item_number', '>', 0)
            ->has('waitingGlobalDetails')
            ->orHas('waitingLocalPrices')
            ->paginate(100);
        //Items that Approved and get lasted approved Details
        $approvedMaterials = MaterialItem::with(['published', 'approvedGlobalDetails'])
            ->where('published_id', $this->publishedStatus['approved'])
            ->orderBy('id','DESC')
            ->paginate(100);
        $data = collect([
            'waitingMaterials' => $waitingMaterials,
            'approvedMaterials' => $approvedMaterials
        ]);
//        dd($data);
        return $data;
    }

    //Create
    public function create()
    {
        $materialTypes = TypesController::getMaterialTypesTree()->toJson();
        $provinces = Province::with(['amphoes' => function ($query) {
            $query->orderBy('name', 'ASC');
        }])->orderBy('name', 'ASC')->get()->toJson();
        return view('admin.materials.items.create')
            ->with([
                'provinces' => $provinces,
                'materialTypes' => $materialTypes,
                'indexRoute' => $this->indexRoute
            ]);
    }

    //Store
    public function store(Request $request)
    {
        $types = MaterialType::with(['items' => function ($query) {
            $query->where('published_id', $this->publishedStatus['approved']);
        }])->get();

        $result = DB::transaction(function () use ($request) {
            //Check User
            //If user is admin all requested are approved
            $published = '';
            if (Auth::user()->hasRole('admin')) {
                $published = PublishedStatus::where('name_eng', 'approved')->first();
            } else if (Auth::user()->hasRole('editor')) {
                $published = PublishedStatus::where('name_eng', 'waiting')->first();
            }
            $newItem = $this->storeGlobalDetails($request, $published);
            $this->storeLocalPrices($request, $published, $newItem);
        });
        return response($result);
    }

    //Store Global // โดนใช้โดย store method
    public function storeGlobalDetails($request, $published)
    {
        $waitingNumber = 0;
        //If published status is waiting add waiting number
        if ($published->name_eng == 'waiting') {
            $waitingNumber = 1 + count($request->input('cities'));
        }
        //Get Type of Material
        $type = MaterialType::with('items')->where('id', $request->input('materialTypeID'))
            ->first();
        //Create New Item ID
        $newItem = MaterialItem::create([
            'published_id' => $published->id, // $published_id is depend on type of user
            'type_id' => $request->input('materialTypeID')
//            'waiting_item_number' => $waitingNumber // The number of items that still in waiting process
        ]);
        //Count number of material and plus 1 for new material
        $lastedID = $type->items()->count() + 1;
        //Combined code prefix of type with lastedID for coding material
        $codePrefix = $type->code_prefix . str_pad($lastedID, 5, '0', STR_PAD_LEFT);
        $itemInputs = [
            'published_id' => $published->id,
            'material_id' => $newItem->id,
            'name' => $request->input('materialName'),
            'code' => $codePrefix,
            'type_id' => $request->input('materialTypeID'),
            'unit' => $request->input('materialUnit'),
            'global_cost' => $request->input('globalCost'),
            'global_price' => $request->input('globalPrice'),
            'global_wage'=>$request->input('globalWage'),
            'invoice_cost' => $request->input('invoiceCost'),
            'invoice_price' => $request->input('invoicePrice'),
            'invoice_wage'=>$request->input('invoiceWage')
        ];
        //Add Item Global Price and  Details First version
        $newItem->globalDetails()->create($itemInputs);
        return $newItem;
    }

    //Store Local Prices โดนใช้โดย store method
    public function storeLocalPrices($request, $published, $newItem)
    {
        //Loop for All Local Prices Inputs
        foreach ($request->input('cities') as $city) {
            if ($city['province'] != null) {
                //Insert Local Price ID
                $newLocalPrice = $newItem->localPrices()->create([
                    'material_id' => $newItem->id
                ]);
                //Insert Local Price Details
                $newLocalPrice->priceDetails()
                    ->create([
                        'published_id' => $published->id,
                        'local_price_id' => $newLocalPrice->id,
                        'province_id' => $city['province']['id'],
                        'amphoe_id' => $city['amphoe']['id'],
                        'district_id' => $city['district']['id'],
                        'cost' => $city['localCost'],
                        'price' => $city['localPrice'],
                        'wage' => $city['wage']
                    ]);
            }
        }
    }

    public function show($id)
    {
        //
    }

    //Edit
    public function edit($id)
    {
        //The ID is the latest ID that updated
        $material = MaterialItem::with('approvedGlobalDetails', 'waitingGlobalDetails')
            ->where('id', $id)->first();
        $materialTypes = TypesController::getMaterialTypesTree()->toJson();
        $provinces = Province::with(['amphoes' => function ($query) {
            $query->orderBy('name', 'ASC');
        }])->orderBy('name', 'ASC')->get()->toJson();

        return view('admin.materials.items.edit')
            ->with([
                'provinces' => $provinces,
                'materialTypes' => $materialTypes,
                'indexRoute' => $this->indexRoute,
                'materialID' => $id,
                'material' => $material
            ]);
    }

    //Edit  for new Requested Item
    public function editRequested($id)
    {
        $material = MaterialItemVersion
            ::with('type', 'localPrices.province.amphoes',
                'localPrices.amphoe.districts',
                'localPrices.district')
            ->where('material_id', $id)->first();
        //Filter Published Status
        $result = $this->editProcess($material);
        return view('admin.materials.items.edit')
            ->with([
                'provinces' => $result['provinces'],
                'materialTypes' => $result['materialTypes'],
                'indexRoute' => $this->indexRoute,
                'material' => $result['material']
            ]);

    }

    //Edit Process
    public function editProcess($material)
    {
        $materialTypes = TypesController::getMaterialTypesTree()->toJson();
        $provinces = Province::with(['amphoes' => function ($query) {
            $query->orderBy('name', 'ASC');
        }])->orderBy('name', 'ASC')->get()->toJson();
        //LocalPrice Status
        $localApproved = $material->localPrices->filter(function ($item) {
            return $item->priceDetails()->where('published_id', $this->publishedStatus['waiting']);
        });

        $result = collect([
            'materialTypes' => $materialTypes,
            'provinces' => $provinces,
            'material' => $material
        ]);
        return $result;
    }

    //Update **เหมือนจะไม่ได้ใช้งาน รอลบออก หากพบว่าไม่ได้ใช้
    public function update(Request $request, $id)
    {
        $result = DB::transaction(function () use ($request) {
            //Check User
            //If user is admin all requested are approved
            $published = '';
            if (Auth::user()->hasRole('admin')) {
                $published = PublishedStatus::where('name_eng', 'approved')->first();
                MaterialItem::where('id', $request->input('materialID'))
                    ->update([
                        'published_id' => $published->id
                    ]);
            } else if (Auth::user()->hasRole('editor')) {
                $published = PublishedStatus::where('name_eng', 'waiting')->first();
            }
            //Update Global Details
            $newItem = $this->updateGlobalDetails($request, $published);
        });
        return response($result);
    }

    //Update Global Details
//    public function updateGlobalDetails($request, $published)
    public function updateGlobalDetails(Request $request)
    {
        $publishedStatus = GlobalVariableController::$publishedStatus;
        $publishedID = $publishedStatus['waiting'];
        $result = DB::transaction(function () use ($request, $publishedStatus) {
            if (Auth::user()->hasRole('admin')) {
                $publishedID = $publishedStatus['approved'];
            }
            $itemInputs = collect([
                'material_id' => $request->input('material_id'),
                'published_id' => $publishedID,
                'name' => $request->input('name'),
                'type_id' => $request->input('type')['id'],
                'unit' => $request->input('unit'),
                'global_cost' => $request->input('global_cost'),
                'global_price' => $request->input('global_price'),
                'global_wage'=>$request->input('global_wage'),
                'invoice_cost' => $request->input('invoice_cost'),
                'invoice_price' => $request->input('invoice_price'),
                'invoice_wage'=>$request->input('invoice_wage')
            ]);
            //ดึงค่าเก่าเพื่อมาใช้ในการเปรียบเทียบ
            $oldItem = MaterialItemVersion::where('id', $request->input('id'))->first();
            //If new update is difference type re-generate code prefix
            //หากพบว่ามีการเปลี่ยน type ก็จะทำการ รีรหัสใหม่
            if ($oldItem->type_id != $request->input('type')['id']) {
                //อัพเดท Type ID ที่ Material Master
                //หากเป็นการแก้ไขจาก Admin
                if (Auth::user()->hasRole('admin')) {
                    MaterialItem::where('id', $request->input('material_id'))
                        ->update([
                            'type_id' => $request->input('type')['id']
                        ]);
                }
                //Get Type of Material
                $type = MaterialType::with('items')->where('id', $request->input('type')['id'])
                    ->first();
                //Count number of material and plus 1 for new material
                $lastedID = $type->items()->count() + 1;
                //Combined code prefix of type with lastedID for coding material
                $codePrefix = $type->code_prefix . str_pad($lastedID, 5, '0', STR_PAD_LEFT);
                $itemInputs->put('code', $codePrefix);
            } else {
                $itemInputs->put('code', $oldItem->code);
            }
            // เช็คก่อนอัพเดท ถ้าหากมี material_id และ สถานะ published เป็น waiting ให้อัพเดทอันเดิม
            // โดยถ้าเป็นการเพิ่มจาก admin สถานะเดิมที่เป็น waiting จะเปลี่ยนเป็น approved
//        $result = DB::transaction(function () use ($itemInputs, $request, $publishedStatus) {
            MaterialItemVersion::updateOrCreate(
                ['material_id' => $request->input('material_id')
                    , 'published_id' => $publishedStatus['waiting']],
                $itemInputs->toArray()
            );
        });
        return response()->json($result);
    }

//Update Global Details Status ใช้สำปรับสถานะการ published
    public function updateGlobalDetailsStatus(Request $request, $globalDetailsID)
    {
        $result = DB::transaction(function () use ($request, $globalDetailsID) {
            MaterialItemVersion::where('id', $globalDetailsID)
                ->update([
                    'published_id' => $this->publishedStatus[$request->input('publishedStatus')]
                ]);
            $material = MaterialItem::where('id', $request->input('materialID'))->first();
            $material->published_id = $this->publishedStatus[$request->input('publishedStatus')];
            $material->save();
        });
        return response($result);
    }

//Update Local Price Status ใช้สำปรับสถานะการ published
    public function updateLocalPriceStatus(Request $request, $materialID)
    {
//        return $request->input('waitingLocalPriceIDs');
        $result = DB::transaction(function () use ($request, $materialID) {
            MaterialItemLocalPriceVersion::whereIn('id', $request->input('waitingLocalPriceIDs'))
                ->update([
                    'published_id' => $this->publishedStatus[$request->input('publishedStatus')]
                ]);
            $material = MaterialItem::where('id', $materialID)->first();
            $material->waiting_item_number -= count($request->input('waitingLocalPriceIDs'));
            $material->save();
        });
        return response($result);
    }

//Update Local Price ** ไม่รู้ว่ามีการใช้งานหรือไม่ ยังไม่กล้าลบ 5555
    public function updateLocalPrice($request, $published, $newItem)
    {
        //Loop for All Local Prices Inputs
        if ($request->input('province') != null) {
            foreach ($request->input('cities') as $city) {
                //Insert Local Price ID
                $newLocalPrice = $newItem->localPrices()->create([
                    'material_id' => $newItem->id
                ]);

                //Insert Local Price Details
                $newLocalPrice->priceDetails()
                    ->create([
                        'published_id' => $published->id,
                        'local_price_id' => $newLocalPrice->id,
                        'province_id' => $city['province']['id'],
                        'amphoe_id' => $city['amphoe']['id'],
                        'district_id' => $city['district']['id'],
                        'cost' => $city['localCost'],
                        'price' => $city['localPrice'],
                        'wage' => $city['wage']
                    ]);
            }
        }
        return $newItem;
    }

//Update Local Price Details
    public function updateLocalPriceDetails(Request $request, $id)
    {
        $result = null;
        $publishedID = $this->publishedStatus['waiting'];
        if (Auth::user()->hasRole('admin')) {
            $publishedID = $this->publishedStatus['approved'];
        }
        //Loop for All Local Prices Inputs
        foreach ($request->input('cities') as $city) {
            if ($city['province'] != null) {
                /*    $request = MaterialItemLocalPriceVersion::where('id', $request->input('local_price_version_id'))
                        ->update([
                            'published_id' => $publishedID,
                            'province_id' => $city['province']['id'],
                            'amphoe_id' => $city['amphoe']['id'],
                            'district_id' => $city['district']['id'],
                            'cost' => $city['localCost'],
                            'price' => $city['localPrice'],
                            'wage' => $city['wage']
                        ]);*/
                $request = MaterialItemLocalPriceVersion::updateOrCreate(
                    [
                        'local_price_id' => $request->input('local_price_id'),
                        'published_id' => $this->publishedStatus['waiting']
                    ],
                    [
                        'published_id' => $publishedID,
                        'province_id' => $city['province']['id'],
                        'amphoe_id' => $city['amphoe']['id'],
                        'district_id' => $city['district']['id'],
                        'cost' => $city['localCost'],
                        'price' => $city['localPrice'],
                        'wage' => $city['wage']
                    ]);
            }
        }
        return response($result);
    }

//Delete
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            $localPriceChildren = collect([]);
            $localPrices = MaterialItemLocalPrice::with('priceDetails')
                ->where('material_id', $id)
                ->get();
            $localPriceIDs = $localPrices->pluck('id');
//            dd($localPriceIDs,$localPriceIDs->toArray());
            foreach ($localPrices as $localPrice) {
                $localPriceChildren = $localPriceChildren->concat($localPrice->priceDetails()->pluck('id'));
            }
            // delete all local price version on this material id
            MaterialItemLocalPriceVersion::destroy($localPriceChildren->toArray());
            //delete all local prices
            MaterialItemLocalPrice::destroy($localPriceIDs->toArray());
            $item = MaterialItem::where('id', $id)->first();
            //delete global details version
            $item->globalDetails()->delete();
            //delete global details
            $item->delete();
        });
        return redirect()->route('admin.materials.items.indexAfterSubmit', 'deleted');
    }

//Delete Waiting Global Details
    public function deleteWaitingGlobalDetails($materialID, $globalDetailsID)
    {
        $result = DB::transaction(function () use ($materialID, $globalDetailsID) {
            $material = MaterialItem::where('id', $materialID)->first();
            MaterialItemVersion::destroy($globalDetailsID);
            $material->save();
        });
        return response($result);
    }

//Delete Local Price
    public function deleteLocalPrice($id)
    {
        $result = DB::transaction(function () use ($id) {
            $localPrice = MaterialItemLocalPrice::where('id', $id)->first();
            $localPrice->priceDetails()->delete();
            MaterialItemLocalPrice::destroy($id);
        });
        return response($result);
    }

//Delete Waiting Local Price
    public function deleteWaitingLocalPrices($id)
    {
        $result = DB::transaction(function () use ($id) {
            MaterialItemLocalPriceVersion::destroy($id);
        });
        return response($result);
    }

//Get Districts
    public function getDistricts($id)
    {
        $districts = District::where('amphoe_id', $id)->orderBy('name', 'ASC')->get()->toJson();
        return $districts;
    }

//Get Global Details
    public function getGlobalDetails($id)
    {
        $material = MaterialItem::with(
            'published', 'approvedGlobalDetails', 'waitingGlobalDetails',
            'approvedLocalPrices.parent', 'waitingLocalPrices.parent'
        )
            ->where('id', $id)->first();
        return response($material);
    }

//Get Approved Local Prices
    public function getApprovedLocalPrices($materialID)
    {
        $approvedLocalPrices = MaterialItemLocalPrice::has('approvedPrice')
            ->with('approvedPrice')
            ->where('material_id', $materialID)
            ->orderBy('updated_at', 'DESC')
            ->paginate(50);
        return response()->json($approvedLocalPrices);
    }

//Get Waiting Local Price
    public function getWaitingLocalPrices($materialID)
    {
        $waitingLocalPrice = MaterialItemLocalPrice::has('waitingPrice')
            ->with('waitingPrice')
            ->where('material_id', $materialID)
            ->orderBy('updated_at', 'DESC')
            ->paginate(50);
        return response()->json($waitingLocalPrice);
    }

    // Get Item of Type
    public function getItemsOfType($type_id)
    {
        //ถ้า id == 0 คือ เลือกแบบ all Types
        $typeDescenDantsAndSelfID=null;
        $items=null;

        if($type_id == 0){
            $items = MaterialItem::with('approvedGlobalDetails')
                ->take(50)
                ->get();
        }else{
            //Query id ของ type_id ที่เลือก และ ลูกๆทั้งหมด เพราะถ้าต้นหาทาง type แม่
            //จะได้ Item ของลูกไปด้วย
            $typeDescenDantsAndSelfID= MaterialType::descendantsAndSelf($type_id)
                ->toFlatTree()
                ->pluck('id');
            $items = MaterialItem::with('approvedGlobalDetails')
                ->whereIn('type_id', $typeDescenDantsAndSelfID)
                ->take(50)
                ->get();
        }
        return response()->json($items);
    }

//Search Item of Type By Name
    public function searchItemsOfTypeByName(Request $request, $type_id)
    {
        //ถ้า id == 0 คือ เลือกแบบ all Types
        $typeDescenDantsAndSelfID=null;
        $items=null;
        if($type_id == 0){
            $items = MaterialItem::with('approvedGlobalDetails')
                ->whereHas('approvedGlobalDetails', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('material_name') . '%');
                })
                ->get();
        }else{
            //Query id ของ type_id ที่เลือก และ ลูกๆทั้งหมด เพราะถ้าต้นหาทาง type แม่
            //จะได้ Item ของลูกไปด้วย
            $typeDescenDantsAndSelfID= MaterialType::descendantsAndSelf($type_id)
                ->toFlatTree()
                ->pluck('id');
            $items = MaterialItem::with('approvedGlobalDetails')
                ->whereIn('type_id', $typeDescenDantsAndSelfID)
                ->whereHas('approvedGlobalDetails', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('material_name') . '%');
                })
                ->get();
        }

        return response()->json($items);
    }

}
