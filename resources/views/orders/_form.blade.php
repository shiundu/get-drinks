@extends('layouts.page')

@section('content')
        
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>New Product <small>add new product</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form method="POST" action="/orders" class="form-horizontal form-label-left">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Company</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select name="customer_id" class="form-control">
                            <option >Select Customer</option>
                          @foreach($customers as $customer)
                            <option value="<?php echo $customer->id; ?>"><?php echo $customer->fname.' '.$customer->lname; ?></option>
                          @endforeach
                          </select>
                        </div>
                      </div> 

                      @foreach($products as $product)
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $product->name; ?></label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" 
                                        name="products[<?php echo $product->id; ?>]"
                                        class="form-control" 
                                        placeholder="Quantity">
                              </div>
                            </div>
                      @endforeach
                      
                      
                      

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="button" class="btn btn-primary">Cancel</button>
                          <button type="reset" class="btn btn-primary">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
@endsection