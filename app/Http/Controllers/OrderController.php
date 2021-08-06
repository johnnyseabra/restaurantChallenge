<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\ProductOrder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $products = Product::get();
        
        
        return view('order.create')->with('products', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Order::create
        ([
            "clientName" => $request->name,
            "status" => 'waiting'
        ]);
        
        for($i = 0; $i < count($request->prod); $i++ )
        {
            ProductOrder::create
            ([
                "product" => $request->prod[$i],
                "quantity" => $request->prod_qty[$i],
                "order" => Order::latest('id')->get()->first()->id
            ]);
        }
        
        event(new \App\Events\NewOrder());
        
        return Redirect::back()->with('msg', 'Order included!');
    }
    
    /**
     * Show orders to kitchen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listKitchen(Request $request)
    {
        
               
        $orders = Order::where('status', 'waiting')->orWhere('status', 'production')->get();
        
        for($i = 0; $i < count($orders); $i++)
        {
            
            //Get products order
            $products = DB::table('products_orders')
                        ->join('products', 'products.id', '=', 'products_orders.product')
                        ->join('orders', 'orders.id', '=', 'products_orders.order')
                        ->select('products.name', 'products_orders.quantity')
                        ->where('products_orders.order', $orders[$i]->id)
                        ->get();
            
            $orders[$i]->products = $products;
        }
        
        
        return view('order.kitchen')->with("orders", $orders);
    }
    
    /**
    * Show last order done screen.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function listDone(Request $request)
    {
        
        return view('order.toten');
    }
    
    
    /**
     * Order's workflow.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        
        $order = Order::findOrFail($request->order);
        
        
        if($order->status == "waiting")
        {
            $newStatus = "production";    
        }
        elseif($order->status == "production")
        
        {
            $newStatus = "done";
            
            //Send event notification
            event(new \App\Events\OrderDone($order->id, $order->clientName));
        }
        else 
        {
            //Prevents DB error
            $newStatus = $order->status;
        }
        
        
        $order->update
        ([
            "status" => $newStatus
        ]);
        
        
        return Redirect::route('kitchen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    


}
