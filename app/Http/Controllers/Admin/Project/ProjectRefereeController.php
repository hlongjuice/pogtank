<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Admin\Project\ProjectReferee;
use Carbon\Carbon;
use DB;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectRefereeController extends Controller
{

    //Add Referees
    public function addReferees($project_order_id, Request $request)
    {
        $result=DB::transaction(function () use ($project_order_id, $request) {
            $newRefereesInputs = collect([]);
            $maxPosition = ProjectReferee::where('project_order_id',$project_order_id)->max('position');
            foreach ($request->input('new_referees') as $new_referee) {
                $maxPosition++;
                $refereeInput = collect([
                    'project_order_id' => $project_order_id,
                    'rank' => $new_referee['rank']['name'],
                    'name' => $new_referee['name'],
                    'position'=>$maxPosition,
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
    public function deleteReferees($project_order_id,Request $request){
        $result= DB::transaction(function() use ($project_order_id,$request){
            $start_position = 1;
            $item_ids= array_pluck($request->input('selected_referees'),'id');
            ProjectReferee::destroy($item_ids);
            //Get Rest of Referees
            $projectReferees = ProjectReferee::where('project_order_id',$project_order_id)
                ->orderBy('position')
                ->get();
            //Reposition
            foreach ($projectReferees as $projectReferee){
                $projectReferee->position = $start_position;
                $projectReferee->save();
                $start_position++;
            }
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

    //Update Project Referee
    public function updateReferee($project_order_id,Request $request){
       $result= DB::transaction(function() use($project_order_id,$request){
           ProjectReferee::where('project_order_id',$project_order_id)
               ->update([
                  'name'=>$request->input('referee')['name'],
                  'rank'=>$request->input('referee')['rank']
               ]);
        });
       return response()->json($result);
    }

}
