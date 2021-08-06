<!DOCTYPE html>
<html>
    <head>
    	<meta charset="UTF-8">
    	<title>..:: Restaurant Challenge - New Order ::..</title>
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
    	<div id="menu">
        </div>
         @if(session()->has('msg'))
    		<div class="alert alert-success">
        		{{ session()->get('msg') }}
    		</div>
		@endif
		<h2>Place Orders</h2>
		<br />
		<div class="container">
          <input class="form-control" id="filter" type="text" placeholder="Search..">
          <br>
          <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Value (US$)</th>
                    <th>Add Order</th>
                  </tr>
                </thead>
                <tbody id="productsTable">
                @foreach ($products as $product)
					<tr id="product-{{ $product->id}}">
                		<td><input type="hidden" id="list-prod-id-{{ $product->id; }}" value="{{ $product->id; }}">{{ $product->id; }}</td><!--  -->
                		<td><input type="hidden" id="list-prod-name-{{ $product->id; }}" value="{{ $product->name; }}">{{ $product->name; }}</td><!--  -->
                		<td><input type="hidden" id="list-prod-value-{{ $product->id; }}" value="{{ $product->value; }}">{{ $product->value; }}</td><!--  -->
                		<td><button class="addList" value="{{ $product->id; }}">Add</button></td><!--  -->
                	</tr>
                	@endforeach
                </tbody>
          	</table>
        </div>
    		<div class="form">
            	<table class="table table-bordered table-striped" id="orderTable">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Value (US$)</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
              	</table>
          	</div>
          	<form id="orderForm" action="{{ route('storeOrder') }}" method="POST">
            	@csrf
              	<h1 id="orderTotal">Total US$ 0.00</h1><br />
              	<h1 id="">Cash</h1>
              	<div class="input-group input-group-lg">
                  <span class="input-group-text">$</span>
                  <span class="input-group-text">0.00</span>
                  <input type="text" id="cash" class="form-control" aria-label="Dollar amount (with dot and two decimal places)">
                </div>
              	<br />
              	<h1 id="change">Change US$ 0.00</h1><br />
              	<h1>Client's Name</h1><input type="text" name="name"  class="form-control" /><br />
              	<button>Send</button>
          	</form>
        

<script>
    $(document).ready(function(){

		//Calculate change
		$("#cash").on("keyup", function() {

			//Sum total order
			var orderTotal = 0;
			$('.prodSubTotal').each(function() {
				orderTotal += parseFloat($(this).val()); 
			});

			var change = $("#cash").val() - orderTotal;

			$('#change').text('Change US$ ' + change);			
		});

		//Filter products list
        $("#filter").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#productsTable tr").filter(function() {
                  	$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
        });


		//Add an item to order
        $(".addList").on("click", function() {

            var prod_id = $(this).val();

			if ($('#order-prod-' + prod_id).length)
			{
				alert('You already included this product');

				return false;
			}
		      
	
            
			var prod_name = $( "#list-prod-name-" + prod_id ).val();
			var prod_value = $( "#list-prod-value-" + prod_id ).val();

			//Create order item
			$("#orderTable").append(
    					"<tr id='order-prod-tr-" + prod_id + "'>" +
        					"<td class='table-primary'>" + prod_id + "<input type='hidden' value='" + prod_id + "' name='prod[]'></td>" +
        					"<td class='table-primary'>" + prod_name + "</td>" +
        					"<td class='table-primary'>" + prod_value + "</td>" +
        					"<td class='table-primary'><input type='number' default='0' class='prodQty' min='0' max='50' id='order-prod-qty-" + prod_id + "' name='qty[]'></td>" +
        					"<td class='table-primary'><input type='number' default='0' class='prodSubTotal' min='0' max='50' id='order-prod-subtotal-" + prod_id + "'name='sub[]' disabled></td>" +
        					"<td class='table-primary'><button class='removeButton' id='order-prod-remove-" + prod_id + "'>Remove</button></td>" +
    					"</tr>"
					);

			$('#orderForm').append(
    					"<input type='hidden' value='" + prod_id + "' id='order-prod-" + prod_id + "'  name='prod[]'>" +
    					"<input type='hidden' value='" + prod_value + "' id='order-prod-value-" + prod_id + "' name='value[]'>" +
    					"<input type='hidden' value='0' id='order-prod-realqty-" + prod_id + "' name='prod_qty[]'>" //I've to add 02 qty input, 01 for form and 01 mock for table. Workaround?
					);

			//Calculate total order
			$(".prodQty").on("change", function() {

				
				var prod_id = $(this).attr('id').replace("order-prod-qty-", "");
				var prod_qty = $(this).val();
				var prod_value = $('#order-prod-value-' + prod_id).val();
				var prod_sub = prod_value * prod_qty;

				//Set subtotal
				$('#order-prod-subtotal-' + prod_id).val(prod_sub);

				//Set prod qty form
				$('#order-prod-realqty-' + prod_id).val(prod_qty);

				//Sum total order
				var orderTotal = 0;
				$('.prodSubTotal').each(function() {
					orderTotal += parseFloat($(this).val()); 
				});

				$('#orderTotal').text('Total US$ ' + orderTotal);
	        });

			//Remove an item from order
	        $(".removeButton").on("click", function() {

	        	var prod_id = $(this).attr('id').replace("order-prod-remove-", "");

				//Destroy order objects
				$("#order-prod-tr-" + prod_id).remove();
				$("#order-prod-" + prod_id ).remove();
				$("#order-prod-value-" + prod_id).remove();
				$("#order-prod-realqty-" + prod_id).remove();

				//Sum total order
				var orderTotal = 0;
				$('.prodSubTotal').each(function() {
					orderTotal += parseFloat($(this).val()); 
				});

				$('#orderTotal').text('Total US$ ' + orderTotal);
				
	        });
            
        });

                    
    });


</script>
    </body>

</html>