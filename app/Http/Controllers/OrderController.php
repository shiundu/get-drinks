<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Customer;
use App\Order;
use App\Order_items;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orders.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $products = Product::all();
        $customers = Customer::all();
        return view('orders._form', ['products'=>$products, 'customers'=>$customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function ($request) {
            $order = new Order;
            $order->customer_id = $request->customer_id;
            $order->user_id = $request->user_id;
            $order->total = $request->total;
            $order->drop_off = $request->drop_off;

            if($order->save()){
                $order_id = $order->id;
                foreach ($request->products as $key => $value) {
                    if(count($value)> 0)
                    {
                        $order_items = new Order_items;
                        $order_items->order_id = $order_id;
                        $order_items->customer_id = $request->customer_id;
                        $order_items->user_id = $request->customer_id;
                        $order_items->$key = $request->$value;
                        $order_items->quantity = $request->quantity;
                    }
                }
            }

        }, 5);


        // echo $request->customer_id;
        // //print_r($request->products);
        // foreach ($request->products as $key => $value) {
        //     if(count($value)> 0)
        //     {
        //         echo $key.': '.$value .'</br>';
        //     }
        // }
        return $this->index();
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
