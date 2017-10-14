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

                    foreach ($product as $key => $value) {
                        if($key == 'quantity' && count($value) > 0)
                        {
                            $order_items = new Order_items;
                            $order_items->order_id = $order_id;
                            $order_items->customer_id = $customer->id;
                            $order_items->user_id = $customer->id;
                            $order_items->product_id = $product['product_id'];
                            $order_items->quantity = $product['quantity'];
                            $order_items->save();
                        }
                    
                    }
                }
            }
        }

        
        $all_orders  = [];
        $orders = Order::where('customer_id', $customer->id)
                 ->where('status', 1)
                 ->get();

        
        foreach($orders as $order){
            $prods = DB::table('order_items')
                        ->join('products', 'products.id', '=', 'order_items.product_id')
                        ->select('order_items.order_id', 'order_items.customer_id', 'order_items.product_id', 
                            'order_items.quantity', 'products.name', 'products.price', 'products.currency')
                        ->where('order_id', $order['order_id'])
                        ->get();

            // $d = array($order , 'products' => $products);
            // array_push($all_orders, $d);
            array_push($all_orders, $prods);
        }
        return $all_orders;
        
    }

    
    public function pending_orders($phone_number)
    {
        $customer = Customer::where('phone_number', $phone_number)->first();
        $orders = Order::where('customer_id', $customer->id)
                 ->where('status', 1)
                 ->get();
        $all_orders  = [];

        $products = [];
        foreach($orders as $order){
            $prod = DB::table('order_items')
                        ->join('products', 'products.id', '=', 'order_items.product_id')
                        ->select('order_items.order_id', 'order_items.customer_id', 'order_items.product_id', 
                            'order_items.quantity', 'products.name', 'products.price', 'products.currency')
                        ->where('order_id', $order['order_id'])
                        ->get();

            // $d = array($order , 'products' => $products);
            // array_push($all_orders, $d);
            array_push($products, $prod );
        }

        return $orders;         
    }


    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
