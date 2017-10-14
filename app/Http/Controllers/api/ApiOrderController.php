<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Product;
use App\Company;
use App\Customer;
use App\Order;
use App\Order_items;
use Illuminate\Support\Facades\DB;


class ApiOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $products = Product::all();
    //     return  $products;
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    //     $companies = Company::all();
    //     return view('products._form', ['companies'=>$companies]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products = 0;
        $total = 0;
        foreach ($request->products as $key => $product) {
            if(count((int)$product['quantity'])> 0)
            {
               $products = $products+1;
               $total = $total + ((int)$product['price']*(int)$product['quantity']) ;
            }
        }

        $customer = Customer::where('phone_number', $request->customer['phone_number'])->first();
        if($customer){
            $order = new Order;
            $order->customer_id = $customer->id;
            $order->user_id = $customer->id;
            $order->products = $products;
            $order->total = $total;
            $order->status = 1;
            $order->drop_off = $request->customer['drop_off'];

            if($order->save()){
                $order_id = $order->id;
                foreach ($request->products as $key => $product) {

                    foreach ($product as $price => $qtty) {
                        if(count($qtty)> 0)
                        {
                            return $product;
                            $order_items = new Order_items;
                            $order_items->order_id = $order_id;
                            $order_items->customer_id = $customer->id;
                            $order_items->user_id = $customer->id;
                            $order_items->product_id = $key;
                            $order_items->quantity = $qtty;
                            $order_items->save();
                        }
                    
                    }
                }
            }
        }

        
        // $all_orders  = [];
        // $orders = Order::where('customer_id', $customer->id)
        //          ->where('status', 1)->get();

        
        // foreach($orders as $order){

        //     $products = DB::table('order_items')
        //                 ->join('products', 'products.id', '=', 'order_items.product_id')
        //                 ->select('order_items.order_id', 'order_items.customer_id', 'order_items.product_id', 'order_items.quantity', 'products.name', 'products.price', 'products.currency')
        //                 ->get();

        //     $d = array($all_orders , 'products' => $products);
        //     array_push($all_orders, $d);
        // }
        // return $all_orders;
        
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
