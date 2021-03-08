@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row">
      <div class="col">
         <a href="/transports">transports</a>
         <div class="row">
            <div class="col"></div>
         </div>
      </div>
      <div class="col">
         <a href="/transport/add">add a transport</a>
      </div>
      <div class="col">
         <a href="/transport/pending">pending requests</a>
      </div>
      <div class="col">
         <a href="/bus/add">add a bus</a>
      </div>
      <div class="col">
         <a href="/buses">all buses</a>
      </div>
      @if(Auth::user()->admin==1)
      <div class="col">
         <a href="/transport/_dispatch">dispatch pending requests</a>
      </div>
      @endif
   </div>
</div>

@endsection