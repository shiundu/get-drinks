<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Product;
use App\Company;
use App\Customer;


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

        $user = Customer::where('phone_number', customer['phone_number'])->first();

        return $user;
        // if($user){

        // }
        // else {
        //     $user = Customer::where('phone_number', customer['email'])->first();
        // }


        // if(is_array($request->customer)){
        //    return $request->customer['phone_number']; 
        // }
        // else {
        //     return $request->customer;
        // }
        
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
