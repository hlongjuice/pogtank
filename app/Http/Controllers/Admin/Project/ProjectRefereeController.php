<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Admin\Project\ProjectReferee;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectRefereeController extends Controller
{

    //Add Referees
    public function addReferees($project_order_id, Request $request)
    {
        $result=DB::transaction(function () use ($project_order_id, $request) {
            $newRefereesInputs = collect([]);
            foreach ($request->input('new_referees') as $new_referee) {
                $refereeInput = collect([
                    'project_order_id' => $project_order_id,
                    'rank' => $new_referee['rank']['name'],
                    'name' => $new_referee['name'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                $newRefereesInputs->push($refereeInput);
            }
            ProjectReferee::insert($newRefereesInputs->toArray());
        });
        return response()->json($result);
    }
    //Delete Referee
    public function deleteReferee(Request $request){
        $result= DB::transaction(function() use ($request){
            $item_ids= array_pluck($request->input('approved_items'),'id');
            ProjectReferee::destroy($item_ids);
        });
        return response()->json($result);
    }

    //Get Project Referees
    public function getReferees($project_order_id)
    {
        $referees = ProjectReferee::where('project_order_id', $project_order_id)
            ->orderBy('name')
            ->get();
        return response()->json($referees);
    }

}
