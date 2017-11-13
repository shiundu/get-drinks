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
    public function __construct()
    {
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $orders = Order::all();
        // return view('orders.index', ['orders'=>$orders]);

        $orders = DB::table('orders')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select('orders.id','orders.updated_at', DB::raw('CONCAT(customers.fname, customers.lname) as name'), 'orders.products', 'orders.total', 'orders.drop_off', 'orders.status')
            ->whereIn('status', [1,2,3])
            ->groupBy('orders.id', 'order_items.order_id', 'customers.id')
            ->get();

        $items = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->select('order_items.customer_id',
                DB::raw('order_items.order_id as order_id'),
                DB::raw('order_items.product_id as product_id'),
                DB::raw('order_items.quantity as quantity'),
                DB::raw('products.name as product_name'),
                DB::raw('products.price as price'),
                DB::raw('products.currency as currency'))
            ->whereIn('orders.status', [1,2,3])
            ->get();

        return view('orders.index', ['orders'=>$orders, 'items' => $items]);
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

        // DB::transaction(function ($request) {
            $products = 0;
            $total = 0;
            foreach ($request->products as $key => $product) {
                foreach ($product as $price => $prod) {
                    if(count($prod)> 0)
                    {
                       $products = $products+1;
                       $total = $total + ($price*$prod) ;
                       // print('product id  : '.$key.', Price : '.$price .', quantity : '. $prod.', Total : '.$total.', count :'.$products);
                    }

                }

            }

            $order = new Order;
            $order->customer_id = $request->customer_id;
            $order->user_id = $request->user_id;
            $order->products = $products;
            $order->status = 1;
            $order->total = $total;
            $order->drop_off = $request->drop_off;

            if($order->save()){
                $order_id = $order->id;
                foreach ($request->products as $key => $product) {

                    foreach ($product as $price => $qtty) {
                        if(count($qtty)> 0)
                        {
                            $order_items = new Order_items;
                            $order_items->order_id = $order_id;
                            $order_items->customer_id = $request->customer_id;
                            $order_items->user_id = $request->customer_id;
                            $order_items->product_id = $key;
                            $order_items->quantity = $qtty;
                            $order_items->save();
                        }

                    }
                }
            }

        // });

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
    public function editStatus(Request $request)
    {
      Order::where('id', $request->order_id)
       ->update(['status' => $request->status ]);

       return redirect('orders');
    }


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
