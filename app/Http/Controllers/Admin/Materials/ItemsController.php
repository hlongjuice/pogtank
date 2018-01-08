<?php

namespace App\Http\Controllers\Admin\Materials;

use App\Http\Controllers\GlobalVariableController;
use App\Models\Admin\Material\MaterialItem;
use App\Models\Admin\Material\MaterialItemLocalPrice;
use App\Models\Admin\Material\MaterialItemVersion;
use App\Models\Admin\Material\MaterialType;
use App\Models\Admin\PublishedStatus;
use App\Models\City\District;
use App\Models\City\Province;
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

    //Submitted
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
    public function indexProcess()
    {
        $waitingMaterials = MaterialItem::with(['published', 'waitingGlobalPrice'])
            ->where('published_id', $this->publishedStatus['waiting'])
            ->paginate(50);
        //Items that Approved and get lasted approved Details
        $approvedMaterials = MaterialItem::with(['published', 'approvedGlobalPrice'])
            ->where('published_id', $this->publishedStatus['approved'])
            ->paginate(50);
        $data = collect([
            'waitingMaterials' => $waitingMaterials,
            'approvedMaterials' => $approvedMaterials
        ]);
        // dd($data['approvedMaterials']);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function store(Request $request)
    {
        $types = MaterialType::with(['items' => function ($query) {
            $query->where('published_id', $this->publishedStatus['approved']);
        }])->get();

        $result = DB::transaction(function () use ($request) {
            //Check User
            //If user is admin all requested are approved
            if (Auth::user()->hasRole('admin')) {
                $published = PublishedStatus::where('name_eng', 'approved')->first();
            } else if (Auth::user()->hasRole('editor')) {
                $published = PublishedStatus::where('name_eng', 'waiting')->first();
            }
            //Get Type of Material
            $type = MaterialType::with('items')->where('id', $request->input('materialTypeID'))
                ->first();
            //Create New Item ID
            $newItem = MaterialItem::create([
                'published_id' => $published->id
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
                'invoice_cost' => $request->input('invoiceCost'),
                'invoice_price' => $request->input('invoicePrice')
            ];
            //Add Item Global Price and  Details First version
            $newItem->globalPriceDetails()->create($itemInputs);

            //Loop for All Local Prices Inputs
            if($request->input('province')!=null){
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
        });
        return response($result);
    }

    public function show($id)
    {
        //
    }

    //Edit Approved Items
    public function edit($id)
    {
        $materialTypes = TypesController::getMaterialTypesTree()->toJson();
        $provinces = Province::with(['amphoes' => function ($query) {
            $query->orderBy('name', 'ASC');
        }])->orderBy('name', 'ASC')->get()->toJson();
        $material = MaterialItem::with('approvedGlobalPrice.type', 'waitingGlobalPrice.type',
            'localPrices.approvedPrice','localPrices.waitingPrices')
            ->where('id', $id)->first();
//        dd($material->localPrices);
        return view('admin.materials.items.edit')
            ->with([
                'provinces' => $provinces,
                'materialTypes' => $materialTypes,
                'indexRoute' => $this->indexRoute,
                'material' => $material
            ]);
    }

    //Edit Method for new Requested Item
    public function editRequested($id)
    {
        $material = MaterialItemGlobalDetailRequested
            ::with('type', 'localPrices.province.amphoes',
                'localPrices.amphoe.districts',
                'localPrices.district')
            ->where('id', $id)->first();
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

    public function editProcess($material)
    {
        $materialTypes = TypesController::getMaterialTypesTree()->toJson();
        $provinces = Province::with(['amphoes' => function ($query) {
            $query->orderBy('name', 'ASC');
        }])->orderBy('name', 'ASC')->get()->toJson();
        //LocalPrice Status
        $localApproved=$material->localPrices->filter(function($item){
            return  $item->priceDetails()->where('published_id', $this->publishedStatus['waiting']);
        });

        $result=collect([
           'materialTypes'=>$materialTypes,
           'provinces'=>$provinces,
           'material'=>$material
        ]);
        return $result;
    }

    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
        });
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $node = MaterialItem::where('id', $id)->first();
            $node->delete();
        });
        return redirect()->route('admin.materials.items.indexAfterSubmit', 'deleted');
    }

    public function getDistricts($id)
    {
        $districts = District::where('amphoe_id', $id)->orderBy('name', 'ASC')->get()->toJson();
        return $districts;
    }

}
