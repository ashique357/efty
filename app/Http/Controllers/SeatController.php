<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeatController extends Controller
{   
    public function __construct(){
        $this->middleware('auth');
    }
    public function show(\App\Bus $bus){
        return view('seats')->with(['bus'=>$bus]);
    }
}
