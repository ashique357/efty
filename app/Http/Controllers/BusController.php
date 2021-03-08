<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function add(Request $request){
        $transport = \Auth::user()->transports()->find($request->tid);
        if($transport)
        return view('addBus')->with(['transport' =>$transport]);
        else abort(404);
    }

    public function show(Request $request){
        $buses = \Auth::user()->buses()->with('transport')->paginate(25);
        return view('allBuses')->with(['buses'=>$buses]);
    }
    public function saveBus(Request $request){
        $validatedData = $request->validate([
            'tid' => 'required',
            'date' => 'required',
            'dep' => 'required',
            'arr' => 'required',
            'details' => 'required',
            'from' => 'required',
            'to' => 'required',
            'fare' => 'required'
        ]);
        
        $datetime = date('Y-m-d',strtotime($request->date));
        $datetime = new \DateTime($datetime);
        for($k=0;$k<max((int)$request->day,1);$k++){
            

            $aj = $datetime->format('Y-m-d');
            $bus = new \App\Bus;
            $bus->go_at = date('Y-m-d',strtotime($aj));
            $bus->departure_at = $request->dep;
            $bus->arrive_at = $request->arr;
            $bus->details = $request->details;
            $bus->transport_id = $request->tid;
            $bus->from = $request->from;
            $bus->to = $request->to;
            $bus->vara = $request->fare;
            \Auth::user()->buses()->save($bus);
            
            for($i=1;$i<=9;$i++){
                for($j=1;$j<=5;$j++){
                    if($i!=9 && $j==3) continue;
                    $st = $i.'_'.$j;
                    $seat = new \App\Seat;
                    $seat->status = 0;
                    $seat->seat_id = $st;
                    $bus->seats()->save($seat);
                }
            }
            $datetime = $datetime->modify('+1 day');
        }

        
        

        



        return redirect('/buses');
    }
    public function edit(Request $request, \App\Bus $bus){
        $x = \Auth::user()->buses()->find($bus->id);
        if($x){
            return view('editBus')->with(['bus'=>$bus]);
        } else abort(404);
    }

    public function editSave(Request $request, \App\Bus $bus){
        $bus = \Auth::user()->buses()->find($bus->id);
        if($bus){
            $validatedData = $request->validate([
                'date' => 'required',
                'dep' => 'required',
                'arr' => 'required',
                'details' => 'required',
                'from' => 'required',
                'to' => 'required',
                'fare' => 'required'
            ]);
            $bus->go_at = date('Y-m-d',strtotime($request->date));
            $bus->departure_at = $request->dep;
            $bus->arrive_at = $request->arr;
            $bus->details = $request->details;
            $bus->from = $request->from;
            $bus->to = $request->to;
            $bus->vara = $request->fare;
            $bus->save();
            return redirect('/buses');
        } else abort(404);

    }
    public function delete(Request $request, \App\Bus $bus){
        $bus = \Auth::user()->buses()->find($bus->id);
        if($bus){
            $bus->delete();
            return redirect('/buses');
        } else abort(404);

    }
}
