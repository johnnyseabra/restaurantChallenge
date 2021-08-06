<!DOCTYPE html>
<html>
    <head>
    	<meta charset="UTF-8">
    	<title>..:: Restaurant Challenge - Kitchen ::..</title>
    	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
    	<div id="menu">
        </div>
        
		<h2>Orders List</h2>
		<br />
		<div class="container">
          <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Itens</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="ordersTable">
                @foreach ($orders as $order)
					<tr>
                		<td>{{ $order->id; }}</td>
                		<td>{{ $order->clientName; }}</td>
                		<td>
                			<ul>
                			@foreach ($order->products as $product)
                			
                			<li>{{ $product->name }} - {{ $product->quantity }}</li>
                			
                			@endforeach
                			</ul>
                		</td>
                		<td>
                			<form action="{{route('changeOrderStatus'); }}" method="POST">
                				@csrf
                				<button name="order" value="{{ $order->id; }}">
                					@if($order->status == "waiting") 
                						Start
            						@else
            							Done
            						@endif
                				</button>
                			</form>
                		</td>
                	</tr>
                	@endforeach
                </tbody>
          	</table>
        </div>
        <script>
        
             // Enable pusher logging - don't include this in production
             Pusher.logToConsole = true;
        
             // Initiate the Pusher JS library
             var pusher = new Pusher('af0846d93f380714766d', {
                 encrypted: true,
                 cluster: 'us2'
             });
        
             // Subscribe to the channel we specified in our Laravel Event
             var channel = pusher.subscribe('restaurant-app');
        
             // Bind a function to a Event (the full Laravel class)
             channel.bind('new-order', function(data) {
                 location.reload();
             });
        </script>
    </body>
</html>