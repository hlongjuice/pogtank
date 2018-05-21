<?php

namespace App\Http\Controllers;

use App\Models\TestItem;
use Illuminate\Http\Request;

class TestApi extends Controller
{
    //
    public function getItems(){
        $items = TestItem::all();
        return response()->json($items);
    }
    public function editItem(){
        return view('web.test_api.index');
    }
    public function updateItems($id){
        $items= TestItem::first()->update([
            'name'=>'OOOO'
        ]);
//        return redirect()->route('test_api.edit');
//        $items =TestItem::all();
//        return response()->json($items);
    }
    public function delete($id){
        TestItem::first()->delete();
        return redirect()->route('test_api.edit');
    }
}
