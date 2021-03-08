<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(\App\Bus $bus){
        $bus->load('seats');
        return view('booking')->with(['bus'=>$bus]);

    }
}
