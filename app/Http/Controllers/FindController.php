<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FindController extends Controller
{
    public function index(Request $request){
        $up = date('Y-m-d',strtotime($request->up));
        $buses = \App\Bus::where('from',$request->from)->where('to',$request->to)->where('go_at',$up)->get();
        $request2 = new Request;
        $request2->from = $request->to;
        $request2->to = $request->from;
        $request2->up = $request->down; 
        $request2->down = $request->up;
        return view('find')->with(['buses'=>$buses,'request'=>$request,'request2'=>$request2]);
    }
}
