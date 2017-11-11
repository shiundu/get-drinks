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

        if(isset($request->customer['customer_id'])){
            $customer_id = $request->customer['customer_id'];
            $orders = Order::where('customer_id', $customer_id)
                             ->where('status', 1)
                             ->get();
        }
        elseif(isset($request->customer['email'])){
            $customer = Customer::where('email', $request->customer['email'])->get();

            if($customer){
              $customer_id = $customer[0]->id;
              $orders = Order::where('customer_id', $customer_id)
                               ->where('status', 1)
                               ->get();
            }
            else {
              $customer = null;
            }

        }
        elseif(isset($request->customer['phone_number'])){
          $customer = Customer::where('phone_number', $request->customer['phone_number'])->get();

          if($customer){
            $customer_id = $customer[0]->id;
            $orders = Order::where('customer_id', $customer_id)
                             ->where('status', 1)
                             ->get();
                  }
          else {
            return $customer = null;
          }
        }

        if(count($orders) > 0){
            foreach ($request->products as $key => $product) {
              $order_items = Order_items::where('customer_id', $customer_id)
              ->where('product_id', $product['product_id'])
              ->where('order_id', $orders[0]->id)
              ->first();

              if($order_items){
                Order_items::where('customer_id', $customer_id)
                ->where('product_id', $product['product_id'])
                ->where('order_id', $orders[0]->id)
                ->update(['quantity' => $order_items['quantity'] + $product['quantity'] ]);

              }
              else {
                if($key == 'quantity' && count($product) > 0)
                {
                    $order_items = new Order_items;
                    $order_items->order_id = $orders[0]->id;
                    $order_items->customer_id = $customer_id;
                    $order_items->user_id = $customer_id;
                    $order_items->product_id = $product['product_id'];
                    $order_items->quantity = $product['quantity'];
                    $order_items->save();
                }
              }
            }

            $this->updateTotal($orders[0]->id);
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
        elseif($customer == null){
            $customer = new Customer;
            $customer->fname = $request->customer['fname'];
            $customer->lname = $request->customer['lname'];
            $customer->dob = $request->customer['dob'];
            $customer->email = $request->customer['email'];
            $customer->phone_number = $request->customer['phone_number'];
            $customer->county = $request->customer['county'];
            $customer->neighbourhood = $request->customer['neighbourhood'];
            $cust = $customer->save();

            $order = new Order;
            $order->customer_id = $cust->id;
            $order->user_id = $cust->id;
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


        return $this->pending_orders($customer_id);

    }

    public function updateTotal($order_id){
      $total = 0;
      $order_items = Order_items::where('order_id', $order_id)->get();
      $products = Product::all();

      foreach ($products as $prod) {
        foreach ($order_items as $item) {
          if($prod['id'] == $item['product_id']){
            $total = $total + ($item['quantity']* $prod['price']);
          }
        }
      }

      return Order::where('id', $order_id)
             ->where('status',1)
             ->update(['total' => $total ]);

    }

    public function pending_orders($id)
    {
      $all_orders  = [];

      $orders = Order::where('customer_id', $id)
              ->whereIn('status', [1,2])
              ->get();
      $order_count = count($orders);

      if($order_count > 1){
        for ($i=0; $i < $order_count ; $i++) {

            $prod = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select('order_items.order_id', 'order_items.customer_id', 'order_items.product_id',
            'order_items.quantity', 'products.name', 'products.price', 'products.currency')
            ->where('order_id', $orders[$i]->id)
            ->get();

            $order = new \stdClass();
            $order = $orders[$i];
            $order->products = $prod;

            $all_orders[] = $order;
        }
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
