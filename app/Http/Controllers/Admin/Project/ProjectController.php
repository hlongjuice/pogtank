<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Admin\Project\ProjectOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ProjectController extends Controller
{
    //Index
    public function index(){

        return view('admin.project_order.index');
    }
    //Create New Project Form
    public function create(){
        return view('admin.project_order.create');
    }

    //Get All Project Order
    public function getAllProjectOrders(){
        $projectOrder = ProjectOrder::orderBy('updated_at','DESC')
            ->paginate(100);
        return response()->json($projectOrder);
    }
    //Add New Order
    public function addNewOrder(Request $request){
        $result=DB::transaction(function() use ($request){
            //Create new project before add new order
            $newProject=ProjectOrder::create([
                'product_id'=>$request->input('product')['id'],
                'project_name'=>$request->input('project_name'),
                'location'=>$request->input('location'),
                'province_id'=>$request->input('province')['id'],
                'amphoe_id'=>$request->input('amphoe')['id'],
                'district_id'=>$request->input('district')['id'],
                'owner_name'=>$request->input('owner_name'),
                'agency_name'=>$request->input('agency_name'),
                'referee_name'=>$request->input('referee_name'),
                'form_number'=>$request->input('form_number'),
                'form_number_release'=>$request->input('form_number_release'),
            ]);
        });
        return response()->json($result);
    }
    //Update Project Order
    public function updateOrder(Request $request){
        $project=ProjectOrder::where('id',$request->input('order_id'))->update([
            'product_id'=>$request->input('product')['id'],
            'project_name'=>$request->input('project_name'),
            'location'=>$request->input('location'),
            'province_id'=>$request->input('province')['id'],
            'amphoe_id'=>$request->input('amphoe')['id'],
            'district_id'=>$request->input('district')['id'],
            'owner_name'=>$request->input('owner_name'),
            'agency_name'=>$request->input('agency_name'),
            'referee_name'=>$request->input('referee_name'),
            'form_number'=>$request->input('form_number'),
            'form_number_release'=>$request->input('form_number_release'),
        ]);
        return response()->json($project);
    }
}
