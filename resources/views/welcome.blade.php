@extends('layouts.app')
<script src="{{ asset('js/app.js') }}"></script>
@section('content')
<div style="margin-top:40px;">
   <form style="display: flex;justify-content: center;" action="/find" >
      <div class="row">
         <span id="form" class="row">
            <div class="col-auto">
               <label>From </label>
               <input @blur="k()" name="from" v-model="from" autocomplete="off" type="text" class="form-control" id="inlineFormInput" placeholder="Enter a city">
               <div v-for="city in froms">
                  <span v-text="city.name" @click="fill(city.name)" style="background-color:#206de5;color:white;:hover{cursor:pointer;}"></span>
               </div>
            </div>
            <div class="col">
               <label>To </label>
               <input @blur="k()" name="to" v-model="to" autocomplete="off" type="text" class="form-control" id="inlineFormInput" placeholder="Enter a city">
               <div v-for="city in tos">
                  <span v-text="city.name" @click="fill2(city.name)" style="background-color:#206de5;color:white;:hover{cursor:pointer;}"></span>
               </div>
            </div>
         </span>
         <div class="col">
            <label>Date of journey</label>
            <!-- <div class="input-group">
               <input name="up" autocomplete="off" id="date1" type="text" class="form-control" placeholder="Pick a date">
               <span class="input-group-addon" style="margin-left:5px;"><i class="fas fa-calendar-check fa-2x"></i></span>
            </div> -->
            <span class="input-group">
               <input name="up" autocomplete="off" id="date1" type="text" class="form-control" placeholder="Pick a date">
               <i class="input-group-text fas fa-calendar-check"></i>
            </span>
         </div>
         <div class="col">
            <label>Date of return ( optional ) </label>
            <!-- <div class="input-group">
               <input name="down" autocomplete="off" id="date2" type="text" class="form-control" placeholder="Pick a date">
               <span class="input-group-addon" style="margin-left:5px;"><i class="fas fa-calendar-check fa-2x"></i></span>
            </div> -->
            <div class="input-group">
               <input name="down" autocomplete="off" id="date2" type="text" class="form-control" placeholder="Pick a date">
               <i class="input-group-text fas fa-calendar-check"></i>
            </div>
         </div>
         <div class="col ">
            <button type="submit" class="btn btn-primary" style="margin-left: 10px;margin-top:29px;">Find Buses</button>
         </div>
      </div>
   </form>
</div>

<div>
    <img src="{{asset('images/bus.png')}}" alt="" class="rounded mx-auto d-block" style="margin:auto;">
    <h4 class="text-center" style="color:#79829A">E-Ticketing</h4>
</div>

<script src="{{ asset('js/app.js') }}"></script>
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
           from: '',
           to: '',
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