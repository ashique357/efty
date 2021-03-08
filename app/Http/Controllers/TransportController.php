<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function add(Request $request){
        return view('addTransport');
    }

    public function save(Request $request){
        $transport = new \App\Transport;
        $request->validate([
            'name' => 'required',
            'lno' => 'required',
        ]);
        $transport->name = $request->name;
        $transport->lno = $request->lno;
        \Auth::user()->transports()->save($transport);
        return redirect('/transport/pending');
    }

    public function pending(){
        $transports = \Auth::user()->transports()->where('approved','0')->orWhere('approved','2')->paginate(25);
        return view('pending')->with(['transports' => $transports]);
    }

    public function _dispatch(){
        if(\Auth::user()->admin==0) abort(404);
        $transports = \App\Transport::where('approved','0')->with('user')->paginate(25);
        return view('dispatch')->with(['transports' => $transports]);
    }
    public function _dispatch_save(Request $request){
        if(\Auth::user()->admin==0) abort(404);
        if($request->a){
            $t = \App\Transport::find($request->id);
            $t->approved = 1;
            $t->save();
        }else {

            $t = \App\Transport::find($request->id);
            $t->approved = 2;
            $t->save();
        }
        return redirect()->back();
    }

    public function show(){
        $transports = \Auth::user()->transports()->where('approved','1')->with('user')->paginate(25);
        return view('transports')->with(['transports' => $transports]);
    }

    public function delete(\App\Transport $transport){
        if($transport->user_id!=\Auth::id()) abort(404);
        $transport->delete();
        $transports = \Auth::user()->transports()->where('approved','1')->with('user')->get();
        return redirect('/transports');
    }



}
