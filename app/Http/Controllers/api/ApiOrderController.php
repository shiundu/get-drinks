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
        // $product = new Product;
        // $product->name = $request->name;
        // $product->price = $request->price;
        // $product->currency = $request->currency;
        // $product->company_id = $request->company_id;
        // $product->description = $request->description;
        // $product->save();
        // if($request->customer['phone_number'] && $request->customer['drop_off']){
        //     return ' customer = '.$request->customer.' products = '.$request->products;;
        // }
        // id | fname |  lname  | dob  |        email         | phone_number | county  | neighbourhood |
        return $request;
        $products = 0;
        $total = 0;
        foreach ($request->products as $key => $product) {
            foreach ($product as $price => $prod) {
                if(count($prod)> 0)
                {
                   $products = $products+1;
                   $total = $total + ((float)$price*(int)$prod) ;
                }
                
            }

        }

        $customer = Customer::where('phone_number', $request->customer['phone_number'])->first();
        if($customer){
            // customer_id | user_id | total | lat | lon | drop_off | products | status 
            $order = new Order;
            $order->customer_id = $customer->id;
            $order->user_id = $customer->id;
            $order->products = $products;
            $order->total = $total;
            $order->drop_off = $request->customer['drop_off'];

            if($order->save()){
                $order_id = $order->id;
                foreach ($request->products as $key => $product) {

                    foreach ($product as $price => $qtty) {
                        if(count($qtty)> 0)
                        {
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

        return Order::findOrFail($order_id);
        
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
