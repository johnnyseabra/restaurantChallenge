<!DOCTYPE html>
<html>
    <head>
    	<meta charset="UTF-8">
    	<title>..:: Restaurant Challenge - New Order ::..</title>
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
    <h1 id="orderId"></h1>
    <h1 id="clientName"></h1>
    </body>
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
             channel.bind('order-done', function(data) {

 				//Get message parameters
 				var message = data.message;

				var arrMessage = message.split("|");

				var orderID = arrMessage[0];
				var clientName = arrMessage[1];

				$('#orderId').text(orderID);
				$('#clientName').text(clientName);
 				
             });
        </script>
</html>