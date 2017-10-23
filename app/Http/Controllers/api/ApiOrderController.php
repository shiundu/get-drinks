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

        // $customer = Customer::where('phone_number', $request->customer['phone_number'])->first();
        if($request->customer['customer_id']){
            $customer_id = $request->customer['customer_id'];
        }
        else {
            $customer = DB::table('customers')
                    ->where('phone_number', $request->customer['phone_number'])
                    ->orWhere('email', $request->customer['email'])
                    ->get();

            $customer_id = $customer[0]->id;
        }



        $orders = Order::where('customer_id', $customer_id)
                 ->where('status', 1)
                 ->get();

        if(count($orders) > 0){
            $order_items = Order_items::where('customer_id', $customer_id)
                 ->where('customer_id', $customer_id)
                 ->where('order_id', $orders[0]->id)
                 ->get();

            foreach ($order_items as $key => $value) {
                    foreach ($product as $key => $value) {
                        if($key == 'quantity' && count($value) > 0){
                                    // $order_items = DB::table('order_items')
                                    //                 ->where('order_id', $orders[0]->id)
                                    //                 ->get();

                                    // foreach ($order_items as $key => $value) {
                                    //     if () {
                                    //     # code...
                                    //     } else {

                                    //     }
                                    // }

                                    // }
                                    // DB::table('order_items')
                                    //     ->where('order_id', $orders[0]->id)
                                    //     ->where('product_id', $product['product_id'];)
                                    //     ->update(['quantity' => $product['quantity'] ]);

                                    // $order_items = new Order_items;
                                    // $order_items->order_id = $order_id;
                                    // $order_items->customer_id = $customer[0]->id;
                                    // $order_items->user_id = $customer[0]->id;
                                    // $order_items->product_id = $product['product_id'];
                                    // $order_items->quantity = $product['quantity'];
                                    // $order_items->save();
                        }
                        else {

                        }

                    }
            }


        }
        elseif($customer){
            $order = new Order;
            $order->customer_id = $customer_id;
            $order->user_id = $customer_id;
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
                            $order_items->customer_id = $customer_id;
                            $order_items->user_id = $customer_id;
                            $order_items->product_id = $product['product_id'];
                            $order_items->quantity = $product['quantity'];
                            $order_items->save();
                        }

                    }
                }
            }
        }


        $orders = Order::where('customer_id', $customer_id)
                 ->where('status', 1)
                 ->get();
        $all_orders  = [];
        array_push($all_orders, $orders[0]);

        $prod = DB::table('order_items')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->select('order_items.order_id', 'order_items.customer_id', 'order_items.product_id',
                    'order_items.quantity', 'products.name', 'products.price', 'products.currency')
                ->where('order_id', $orders[0]->id)
                ->where('customer_id', $customer_id)
                ->get();

        $products = array("products"=> $prod);

        array_merge($all_orders, []);
        array_push($all_orders, $products);

        return $all_orders;

        // return $customer;

    }


    public function pending_orders($phone_number)
    {
        $customer = Customer::where('phone_number', $phone_number)->get();
        $orders = Order::where('customer_id', $customer[0]->id)
                 ->where('status', 1)
                 ->get();
        $all_orders  = [];
        array_push($all_orders, $orders[0]);
        if(count($orders) > 0){
            $prod = DB::table('order_items')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->select('order_items.order_id', 'order_items.customer_id', 'order_items.product_id',
                    'order_items.quantity', 'products.name', 'products.price', 'products.currency')
                ->where('order_id', $orders[0]->id)
                ->get();

            $products = array("products"=> $prod);

            array_merge($all_orders, []);
            array_push($all_orders, $products);

            return $all_orders;
        }


        return $all_orders;
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
