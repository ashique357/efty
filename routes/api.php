<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/cities', function(Request $request){
    $res = \App\City::where('name','like','%'.$request->q.'%')->get();
    return $res;
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/seat/{bus}', function (Request $request,\App\Bus $bus) {
    $seats = $bus->seats()->get();
    $arr = [];
    for($i=0;$i<count($seats);$i++){
        $arr[$seats[$i]['seat_id']] = $seats[$i]['status'];
    }
    return $arr;
});
