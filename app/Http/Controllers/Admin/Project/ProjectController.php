<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Admin\Project\ProjectOrder;
use App\Models\Admin\Project\Referee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ProjectController extends Controller
{
    //Index
    public function index()
    {
        return view('admin.project_order.index');
    }

    //Create New Project Form
    public function create()
    {
        return view('admin.project_order.create');
    }

    //Add New Order
    public function addNewOrder(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            //Create new project before add new order
            $newProject = ProjectOrder::create([
//                'product_id'=>$request->input('product')['id'],
                'project_name' => $request->input('project_name'),
                'location' => $request->input('location'),
                'province_id' => $request->input('province')['id'],
                'amphoe_id' => $request->input('amphoe')['id'],
                'district_id' => $request->input('district')['id'],
                'owner_name' => $request->input('owner_name'),
                'agency_name' => $request->input('agency_name'),
                'referee_name' => $request->input('referee_name'),
                'referee_calculated_date'=>$request->input('referee_calculated_date'),
                'form_number' => $request->input('form_number'),
                'form_number_release' => $request->input('form_number_release'),
            ]);
        });
        return response()->json($result);
    }

    //Get All Project Order
    public function getAllProjectOrders()
    {
        $projectOrder = ProjectOrder::with('province.amphoes', 'amphoe', 'district')
            ->orderBy('updated_at', 'DESC')
            ->paginate(100);
        return response()->json($projectOrder);
    }

    //Get Project Details
    public function getProjectDetails($project_order_id)
    {
        $details = ProjectOrder::with(['province', 'amphoe', 'district'])
            ->where('id', $project_order_id)->first();
        return response()->json($details);
    }

    //Update Project Order
    public function updateDetails(Request $request)
    {
        $project = ProjectOrder::where('id', $request->input('id'))->update([
//            'product_id'=>$request->input('product')['id'],
            'project_name' => $request->input('project_name'),
            'location' => $request->input('location'),
            'province_id' => $request->input('province')['id'],
            'amphoe_id' => $request->input('amphoe')['id'],
            'district_id' => $request->input('district')['id'],
            'owner_name' => $request->input('owner_name'),
            'agency_name' => $request->input('agency_name'),
            'referee_name' => $request->input('referee_name'),
            'referee_calculated_date'=>$request->input('referee_calculated_date'),
            'form_number' => $request->input('form_number'),
            'form_number_release' => $request->input('form_number_release'),
        ]);
        return response()->json($project);
    }

    //Delete Project
    public function deleteProject($id)
    {
        $result = DB::transaction(function () use ($id) {
            ProjectOrder::destroy($id);
        });
        return response()->json($result);
    }

}
