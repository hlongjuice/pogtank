<?php

namespace App\Http\Controllers\Admin\Materials;

use App\Models\Admin\Material\MaterialType;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypesController extends Controller
{

    private $indexRoute = '';

    function __construct()
    {
        $this->indexRoute = route('admin.materials.types.indexAfterSubmit');
    }

    //Index
    public function index()
    {
        //Have Only 3 Depth Types
        $types = MaterialType::orderBy('updated_at', 'DESC')->get()->toTree();
        return view('admin.materials.types.index')
            ->with([
                'types' => $types,
                'submitted' => 0
            ]);
    }

    //Index After Submit
    public function indexAfterSubmit()
    {
        $types = MaterialType::orderBy('updated_at', 'DESC')->get()->toTree();
        return view('admin.materials.types.index')
            ->with([
                'types' => $types,
                'submitted' => 1
            ]);
    }

    //Create
    public function create()
    {
        $parentTypes = self::getMaterialParentTypes()->toJson();
        return view('admin.materials.types.create')
            ->with([
                'parentTypes' => $parentTypes,
                'indexRoute' => $this->indexRoute
            ]);
    }

    //Store
    public function store(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            if ($request->input('parentTypeID') == 0) {
                MaterialType::create([
                    'code_prefix' => $request->input('codePrefix'),
                    'name' => $request->input('typeName'),
                    'details' => $request->input('details')
                ]);
            } else {
                $parent = MaterialType::where('id', $request->input('parentTypeID'))->first();
                $parent->children()->create([
                    'code_prefix' => $request->input('codePrefix'),
                    'name' => $request->input('typeName'),
                    'details' => $request->input('details')
                ]);
                $root = $parent->ancestors()->withDepth()->having('depth', 0)->first();
                $root->updated_at = Carbon::now();
                $root->save();
            }
        });
        return response($result);
    }

//Show
public
function show($id)
{
    //
}

//Edit
public
function edit($id)
{
    $oldType = MaterialType::with('ancestors')->where('id', $id)->first();
    $parentTypes = self::getMaterialTypeSiblings($id);
    return view('admin.materials.types.edit')
        ->with([
            'oldType' => $oldType,
            'parentTypes' => $parentTypes,
            'indexRoute' => $this->indexRoute
        ]);
}

//Update
public
function update(Request $request, $id)
{
    $result = DB::transaction(function () use ($request, $id) {
        $oldType = MaterialType::withDepth()->where('id', $id)->first();
        if ($oldType->parent_id != $request->input('parentTypeID')
            && $oldType->depth != 0) {
            $oldType->parent_id = $request->input('parentTypeID');
        }
        $oldType->name = $request->input('name');
        $oldType->details = $request->input('details');
        $oldType->code_prefix = $request->input('codePrefix');
        $oldType->save();
    });
    return response($result);
}

//Delete
public
function destroy($id)
{
    DB::transaction(function () use ($id) {
        $node = MaterialType::where('id', $id)->first();
        $node->delete();
    });
    return redirect()->route('admin.materials.types.indexAfterSubmit');
}

//Get Material Patent Types
public
static function getMaterialParentTypes()
{
    //Specific Only 2 level of Parent Type [0,1]
    $parentTypes = MaterialType::withDepth()->orderBy('name', 'ASC')->get()->where('depth', '<=', '1')->toFlatTree();
    //If Level 1 set '-- ' prefix
    foreach ($parentTypes as $parentType) {
        if ($parentType->depth == 1) {
            $parentType->name = '-- ' . $parentType->name;
        }
    }
    $parentTypes->prepend([
        'id' => 0,
        'name' => 'หมวดหมู่หลัก'
    ]);
    return $parentTypes;
}

//Get Type Siblings
public
static function getMaterialTypeSiblings($id)
{
    //Specific Only 2 level of Parent Type [0,1]
    $siblings = MaterialType::withDepth()->orderBy('name', 'ASC')
        ->get()
        ->whereNotIn('id', $id)
        ->where('depth', '<=', '1')->toFlatTree();
    //If Level 1 set '-- ' prefix
    foreach ($siblings as $sibling) {
        if ($sibling->depth == 1) {
            $sibling->name = '-- ' . $sibling->name;
        }
    }
    $siblings->prepend([
        'id' => 0,
        'name' => 'หมวดหมู่หลัก'
    ]);
    return $siblings;
}

//Get All Material Types
public
static function getMaterialTypesTree()
{
    //Specific Only 2 level of Parent Type [0,1]
    $parentTypes = MaterialType::withDepth()->orderBy('name', 'ASC')->get()->toFlatTree();
    foreach ($parentTypes as $parentType) {
        //If Level 1 set '-- ' prefix
        if ($parentType->depth == 1) {
            $parentType->name = '-- ' . $parentType->name;
        } //Else Level 2 set '-- -- ' prefix
        else if ($parentType->depth == 2) {
            $parentType->name = '-- -- ' . $parentType->name;
        }
    }
    return $parentTypes;
}
}
