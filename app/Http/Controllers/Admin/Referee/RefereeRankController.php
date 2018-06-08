<?php

namespace App\Http\Controllers\Admin\Referee;

use App\Models\Admin\Referee\RefereeRank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefereeRankController extends Controller
{
    //Get All Referees
    public function getRefereeRanks(){
        $ranks = RefereeRank::orderBy('name')->get();
        return response()->json($ranks);
    }
    //Add New Referee
    public function addRanks(){

    }
    //Update Referee
    public function updateRank(){

    }
    //Delete Referee
    public function deleteRank(){

    }
}
