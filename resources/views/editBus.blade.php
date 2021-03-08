@extends('layouts.app')
<script src="{{ asset('js/app.js') }}" ></script>
@section('content')
<div class="container">
<div class="card text-center">
<div class="card-header">
        Edit Bus {{$bus->id}}
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul style="list-style-type: none;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
   <form action="/bus/edit/{{$bus->id}}" method="post" class="card-body">
      @csrf
      <div class="row">
         <?php
            $d = \DateTime::createFromFormat("Y-m-d", $bus->go_at);
            
            ?>
         <div class="col">
            <span><b>Date of journey</b> </span>
            <div class="input-group">
               <input name="date" value="{{$d->format('m/d/Y')}}" autocomplete="off" id="date1" type="text" class="form-control" placeholder="Pick a date">
               <span class="input-group-addon input-group-text" ><i class="fas fa-calendar-check"></i></span>
            </div>
         </div>
         <div class="col">
            <span><b>Departure time</b> </span>
            <div class="input-group bootstrap-timepicker timepicker">
               <input id="timepicker1" value="{{$bus->departure_at}}" type="text" class="form-control input-small" name="dep">
               <span class="input-group-addon input-group-text"><i class="fa fa-clock"></i></span>
            </div>
         </div>
         <div class="col">
            <span><b>Arrive time</b> </span>
            <div class="input-group bootstrap-timepicker timepicker">
               <input id="timepicker2" value="{{$bus->arrive_at}}"type="text" class="form-control input-small" name="arr">
               <span class="input-group-addon input-group-text"><i class="fa fa-clock"></i></span>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <span><b>Details</b> </span>
            <textarea class="form-control" type="text" id="" name="details">{{$bus->details}}</textarea>
         </div>
      </div>
      <span id="form" class="row">
         <div class="col">
            <span><b>From</b> </span>
            <input @blur="k()" name="from" v-model="from" autocomplete="off" type="text" class="form-control" id="inlineFormInput" placeholder="Enter a city">
            <div v-for="city in froms">
               <span v-text="city.name" @click="fill(city.name)" style="background-color:#206de5;color:white;:hover{cursor:pointer;}"></span>
            </div>
         </div>
         <div class="col">
            <span><b>To</b> </span>
            <input @blur="k()" name="to" v-model="to" autocomplete="off" type="text" class="form-control" id="inlineFormInput" placeholder="Enter a city">
            <div v-for="city in tos">
               <span v-text="city.name" @click="fill2(city.name)" style="background-color:#206de5;color:white;:hover{cursor:pointer;}"></span>
            </div>
         </div>
         <div class="col">
            <b>Fare per seat</b>
            <input type="text" name="fare" value="{{$bus->vara}}" class="form-control">
         </div>
      </span>
      
      <button type="submit" class="btn btn-primary" style="margin-top:29px;">Complete Editing</button>
   </form>
</div>
</div>
<script src="{{ asset('js/app.js') }}" ></script>
<script>
   $('#date1').datepicker({
        autoclose: true,
        todayHighlight: true,
        
    });
    $('#timepicker1').timepicker({
   up: 'fa fa-sort-asc',
   down: 'fa fa-sort-desc'
   });
    $('#timepicker2').timepicker({
   up: 'fa fa-sort-asc',
   down: 'fa fa-sort-desc'
   });
</script>
<script>
   $('#date1').datepicker({
       autoclose: true,
       todayHighlight: true
   });
   $('#date2').datepicker({
       autoclose: true,
       todayHighlight: true
   });
   
   const x = new Vue({
       el:'#form',
       data: {
           from: '{{$bus->from}}',
           to: '{{$bus->to}}',
           froms: [],
           tos: [],
           fromset: false,
           toset: false
       },
       watch:{
           from: _.debounce(function(){
               if(this.from.length>=2 && !x.fromset){
                   
                   axios.get('/api/cities?'+'q='+x.from)
                   .then(function (response) {
                       console.log(response.data);
                       x.froms = response.data;
                               
                   })
                   .catch(function (error) {
                       console.log(error);
                   });
               }else {
                   x.froms = [];
               }
               if(x.fromset){
                   x.fromset = false;
               }
           },300),
           to: _.debounce(function(){
               if(this.to.length>=2 && !x.toset){
                   axios.get('/api/cities?'+'q='+x.to)
                   .then(function (response) {
                       console.log(response.data);
                       x.tos = response.data;
                   })
                   .catch(function (error) {
                       console.log(error);
                   });
               } else {
                   x.tos = [];
               }
               if(x.toset){
                   x.toset = false;
               }
           },300)
       },
       methods:{
           fill(r){
               this.from = r;
               this.froms = [];
               this.fromset = true;
           },
           fill2(r){
               this.to = r;
               this.tos = [];
               this.toset = true;
           },
           k: _.debounce(function(){
               this.froms = [];
               this.tos = [];
           },300),
       }
   });
   
   
</script>
@endsection