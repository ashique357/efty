<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request){
        if($request->taka==0) abort(404);
        $arr = $request->all();
        $i = 0;
        while ($el = current($arr)) {
            if (key($arr)>=1 && key($arr)<=37) {
                $seats[$i++] = $arr[key($arr)];
            }
            next($arr);
        }
        session()->flash('seats',$seats);
        session()->flash('no',count($seats));
        session()->flash('taka',$request->taka);
        session()->flash('bus',$request->bus);
        return redirect('checkout');
    }
    public function checkout(Request $request){
         if(session('taka')==0) abort(404);
         $name = '';$email = '';
         if(\Auth::check()){
            $name = \Auth::user()->name;
            $email = \Auth::user()->email;
         }
         $request->session()->reflash();
         session()->flash('name', $request->name);
         session()->flash('email', $request->email);
         return view('checkout')->with(['name' => $name , 'email' => $email]);
    }

    public function charge(Request $request){

        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey("sk_test_L4MWICS4JdZWOdax7zcD7Q2o");

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:

        
        $token = $_POST['stripeToken'];
        try{
             $charge = \Stripe\Charge::create([
            'amount' => session('taka'),
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $token,
            'receipt_email' => $request->email,
        ]);
        } catch(Exception $ex){
            //dd(515);
            session()->reflash();
            return redirect('/charge/complete?payment='.'fail');
        }
       
        
        if($charge->outcome->seller_message=="Payment complete."){
            // update seats
            $array = session('seats');
            for($i=0;$i<count($array);$i++){
                $seat = \App\Bus::find(session('bus'))->seats()->where('seat_id',$array[$i])->firstOrFail();
                $seat->status = 1;
                $seat->save();
            }
            $ibus = \App\Bus::find(session('bus'));
            $ibus->load('transport');
            $invoice = new \App\Invoice;
            $invoice->price = session('taka');
            $invoice->fare = session('taka')/count($array);
            $invoice->seats = count($array);
            $invoice->name = $request->name;
            $invoice->email = $request->email;
            $invoice->from = $ibus->from;
            $invoice->to = $ibus->to;
            $invoice->departure = $ibus->go_at;
            $invoice->transport_name = $ibus->transport->name;
            $invoice->save();
            \App\Jobs\ProcessInvoice::dispatch($invoice,$request->email,$array);
            return redirect('/charge/complete?payment='.'success');
        }
        
        return redirect('/charge/complete?payment='.'fail');
   }
   public function complete(Request $request){

    if($request->payment=='success'){
        return view('success');
    }else {
        session()->reflash();
        session()->flash('payment', 'failed');

        return redirect("/checkout");
    }
   }
}
