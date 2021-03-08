<link rel="stylesheet" href="{{asset('css/app.css')}}">
<style>

.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>
<div class="container">
		

    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">Order # {{ $invoice->id }}</h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To: </strong><br>
    					{{ $invoice->name }}<br>
    				<strong>E-mail: </strong><br>
					    {{$invoice->email}}<br>
    				</address>
    			</div>
    			
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Order Date:{{ $invoice->created_at }}</strong><br>
    					
    				</address>
    			</div>
    			
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
			<h3>You have ordered seats of <strong>{{$invoice->transport_name}}</strong>
			your trip from <strong>{{$invoice->from }}</strong> to <strong>{{$invoice->to}}</strong>
			will start <strong>{{$invoice->departure}}</strong>
			
			 </h3>
    		<div class="card text-center filterable ml-auto mr-auto">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body text-center">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Seat No.</strong></td>
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
								@for($i=0;$i<count($seats);$i++)
    							<tr>
    								<td>{{$seats[$i]}}</td>
    								<td class="text-center">{{$invoice->fare  }}</td>
    								<td class="text-center">1</td>
    								<td class="text-right">{{$invoice->fare}}</td>
    							</tr>
                                @endfor
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">{{$invoice->fare*count($seats)  }}</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>