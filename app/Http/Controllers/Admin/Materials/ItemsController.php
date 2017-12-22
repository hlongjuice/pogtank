<?php

namespace App\Http\Controllers\Admin\Materials;

use App\Http\Controllers\GlobalVariableController;
use App\Models\Admin\Material\MaterialItem;
use App\Models\Admin\Material\MaterialType;
use App\Models\City\District;
use App\Models\City\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ItemsController extends Controller
{
    private $indexRoute = '';

    public function __construct()
    {
        $this->indexRoute = url('admin/materials/items/submitted');
    }

    public function index()
    {
        $materials = MaterialItem::with('type')->orderBy('name', 'ASC')->paginate(50);
        return view('admin.materials.items.index')
            ->with([
                'materials' => $materials,
                'submitted' => 0
            ]);
    }

    //Submitted
    public function indexAfterSubmit($status)
    {
        $materials = MaterialItem::with('type')->orderBy('name', 'ASC')->paginate(50);
        return view('admin.materials.items.index')
            ->with([
                'materials' => $materials,
                'submitted' => $status
            ]);
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
        $result = DB::transaction(function () use ($request) {
            //Get Type of Material
            $type = MaterialType::with('items')->where('id', $request->input('materialTypeID'))
                ->first();
            //Count number of material and plus 1 for new material
            $lastedID = $type->items()->count() + 1;
            //Combined code prefix of type with lastedID for coding material
            $codePrefix = $type->code_prefix . str_pad($lastedID, 5, '0', STR_PAD_LEFT);;
            $published = GlobalVariableController::$publishedStatus['waiting'];
            $newItem = MaterialItem::create([
                'name' => $request->input('materialName'),
                'code' => $codePrefix,
                'type_id' => $request->input('materialTypeID'),
                'unit' => $request->input('materialUnit'),
                'global_cost' => $request->input('globalCost'),
                'global_price' => $request->input('globalPrice'),
                'invoice_cost' => $request->input('invoiceCost'),
                'invoice_price' => $request->input('invoicePrice'),
                'published_id' => $published
            ]);
            $localPriceInput = collect([]);
            foreach ($request->input('cities') as $city) {
                $localPriceInput->push([
                    'material_id' => $newItem->id,
                    'province_id' => $city['province']['id'],
                    'amphoe_id' => $city['amphoe']['id'],
                    'district_id' => $city['district']['id'],
                    'cost' => $city['localCost'],
                    'price' => $city['localPrice'],
                    'wage'=>$city['wage']
                ]);
            }
            $newItem->localPrices()->createMany($localPriceInput->toArray());
        });
        return response($result);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $materialTypes = TypesController::getMaterialTypesTree()->toJson();
        $provinces = Province::with(['amphoes' => function ($query) {
            $query->orderBy('name', 'ASC');
        }])->orderBy('name', 'ASC')->get()->toJson();
        $material = MaterialItem::with('type','localPrices.province.amphoes','localPrices.amphoe.districts','localPrices.district')
            ->where('id', $id)->first();
        return view('admin.materials.items.edit')
            ->with([
                'provinces' => $provinces,
                'materialTypes' => $materialTypes,
                'indexRoute' => $this->indexRoute,
                'material' => $material
            ]);
    }

    public function update(Request $request, $id)
    {
        //
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
