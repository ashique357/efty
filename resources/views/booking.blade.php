@extends('layouts.app')
@section('content')
<style>
   a {
   color: #b71a4c;
   }
   ._front-indicator {
   width: 145px;
   margin: 5px 32px 15px 32px;
   background-color: #f6f6f6;	
   color: #adadad;
   text-align: center;
   padding: 3px;
   border-radius: 5px;
   }
   ._wrapper {
   width: 100%;
   text-align: center;
   margin-top:150px;
   }
   ._container {
   margin: 0 auto;
   width: 500px;
   text-align: left;
   }
   .booking-details {
   float: left;
   text-align: left;
   margin-left: 35px;
   font-size: 12px;
   position: relative;
   height: 401px;
   }
   .booking-details h2 {
   margin: 25px 0 20px 0;
   font-size: 17px;
   }
   .booking-details h3 {
   margin: 5px 5px 0 0;
   font-size: 14px;
   }
   div.seatCharts-cell {
   color: #182C4E;
   height: 25px;
   width: 25px;
   line-height: 25px;
   }
   div.seatCharts-seat {
   color: #FFFFFF;
   cursor: pointer;	
   }
   div.seatCharts-row {
   height: 35px;
   }
   div.seatCharts-seat.available {
   background-color: #B9DEA0;
   }
   div.seatCharts-seat.available.first-class {
   /* 	background: url(vip.png); */
   background-color: #3a78c3;
   }
   div.seatCharts-seat.focused {
   background-color: #76B474;
   }
   div.seatCharts-seat.selected {
   background-color: #E6CAC4;
   }
   div.seatCharts-seat.unavailable {
   background-color: #472B34;
   }
   div.seatCharts-container {
   border-right: 1px dotted #adadad;
   width: 250px;
   padding: 20px;
   float: left;
   }
   div.seatCharts-legend {
   padding-left: 0px;
   position: absolute;
   bottom: 16px;
   }
   ul.seatCharts-legendList {
   padding-left: 0px;
   }
   span.seatCharts-legendDescription {
   margin-left: 5px;
   line-height: 30px;
   }
   .checkout-button {
   display: block;
   margin: 10px 0;
   font-size: 14px;
   }
   #selected-seats {
   max-height: 90px;
   overflow-y: scroll;
   overflow-x: none;
   width: 170px;
   }
</style>
<script src="//code.jquery.com/jquery.min.js"></script>
<script src="{{asset('js/app.js')}}"></script>
<form id="form" action="/checkout" method ="post">
   @csrf
   <div class="_wrapper">
      <div class="_container">
         <h1>Seats booked of Bus id {{$bus->id}}</h1>
         <input type="hidden" name="bus" value="{{$bus->id}}">
         <div id="seat-map">
            <div class="_front-indicator">Front</div>
         </div>
         <div class="booking-details">
            <h2>Booking Details</h2>
            <h3> Selected Seats (<span id="counter">0</span>):</h3>
            <ul id="selected-seats">
            </ul>
            Total: <b>৳<span id="total" >0</span></b>
            <button type="submit"  class="checkout-button">Checkout &raquo;</button>
            <input type="hidden" name="taka" id="taka">
            <div id="legend"></div>
         </div>
      </div>
   </div>
</form>
<script>
   var firstSeatLabel = 1;
   
   $(document).ready(function() {
     var $cart = $('#selected-seats'),
       $counter = $('#counter'),
       $total = $('#total'),
       sc = $('#seat-map').seatCharts({
       map: [
         'ee_ee',
         'ee_ee',
         'ee_ee',
         'ee_ee',
         'ee_ee',
         'ee_ee',
         'ee_ee',
         'ee_ee',
         'eeeee',
       ],
       seats: {
         f: {
           price   : 100,
           classes : 'first-class', //your custom CSS class
           category: 'First Class'
         },
         e: {
           price   : {{$bus->vara}},
           classes : 'economy-class', //your custom CSS class
           category: 'Economy Class'
         }         
       
       },
       naming : {
         top : false,
         getLabel : function (character, row, column) {
           return firstSeatLabel++;
         },
       },
       legend : {
         node : $('#legend'),
           items : [
           [ 'e', 'available',   'Available seat'],
           [ 'f', 'unavailable', 'Already Booked']
           ]         
       },
       click: function () {
         if (this.status() == 'available') {
           //let's create a new <li> which we'll add to the cart items
           $('<li>'+this.data().category+' Seat # '+this.settings.label+': <b>	৳'+this.data().price+'</b> <a href="#" class="cancel-cart-item">[cancel]</a></li>')
             .attr('id', 'cart-item-'+this.settings.id)
             .data('seatId', this.settings.id)
             .appendTo($cart);
           
           $('<input type="hidden" id="in-'+this.settings.label+'" name="'+this.settings.label+'" value='+this.settings.id+'>').appendTo($cart);
   
           /*
            * Lets up<a href="https://www.jqueryscript.net/time-clock/">date</a> the counter and total
            *
            * .find function will not find the current seat, because it will change its stauts only after return
            * 'selected'. This is why we have to add 1 to the length and the current seat price to the total.
            */
           $counter.text(sc.find('selected').length+1);
           $total.text(recalculateTotal(sc)+this.data().price);
           
           $('<input type="hidden" name="price" value='+(recalculateTotal(sc)+this.data().price)+'>').appendTo($cart);
           $('#taka').val(recalculateTotal(sc)+this.data().price);
           return 'selected';
         } else if (this.status() == 'selected') {
           //update the counter
           $counter.text(sc.find('selected').length-1);
           //and total
           $total.text(recalculateTotal(sc)-this.data().price);
           $('#taka').val(recalculateTotal(sc)-this.data().price);
           //remove the item from our cart
           $('#cart-item-'+this.settings.id).remove();
           $('#in-'+this.settings.label).remove();
           //seat has been vacated
           return 'available';
         } else if (this.status() == 'unavailable') {
           //seat has been already booked
           return 'unavailable';
         } else {
           return this.style();
         }
       }
     });
   
     //this will handle "[cancel]" link clicks
     $('#selected-seats').on('click', '.cancel-cart-item', function () {
       //let's just trigger Click event on the appropriate seat, so we don't have to repeat the logic here
       sc.get($(this).parents('li:first').data('seatId')).click();
     });
   
     //let's pretend some seats have already been booked
     
     
      function check(st){
        axios.get('/api/seat/{{$bus->id}}')
        .then(function (response) {
        arr = response.data;
        for(var i=1;i<=9;i++){
            for(j=1;j<=5;j++){
                if(i!=9 && j==3) continue;
                var st = i+'_'+j;
                
                if(arr[st]==1) sc.get([st]).status('unavailable');
            }
          }
        })
        .catch(function (error) {
        });
      }
      check();

   });
   
   function recalculateTotal(sc) {
   var total = 0;
   
   //basically find every selected seat and sum its price
   sc.find('selected').each(function () {
     total += this.data().price;
   });
   
   return total;
   }
   
</script>
@endsection