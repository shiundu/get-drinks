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

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Table design <small>Custom design</small></h2>
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

                    <p>Add class <code>bulk_action</code> to table for bulk actions options on row select</p>

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>
                            <th class="column-title">Order date </th>
                            <th class="column-title">Customer </th>
                            <th class="column-title">Number of products </th>
                            <th class="column-title">Total </th>
                            <th class="column-title">Drop off </th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                           @foreach($orders as $order)
                          <tr class="even pointer">
                            <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>
                            <td class=" "><?php echo $order->updated_at; ?></td>
                            <td class=" "><?php echo $order->name; ?></td>
                            <td class=" ">
                              @foreach($items as $item)
                                @if($order->id == $item->order_id)
                                  <li><?php echo $item->product_name .' '.$item->quantity; ?></li>
                                @endif
                              @endforeach
                            </td>
                            <td class=" "><?php echo $order->total; ?></td>
                            <td class=" "><?php echo $order->drop_off; ?></td>
                            <td class=" ">
                              <div class="row">
                                <div class="btn-group">
                                  <button class="btn btn-primary" type="button">Dispatched</button>
                                  <button class="btn btn-success" type="button">Delivered</button>
                                  <button class="btn btn-danger" type="button">Delete</button>
                                </div>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>


                  </div>
                </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <a href="<?php echo route('orders.create'); ?>"><button type="button" class="btn btn-default">New Order</button></a>
              </div>
@endsection
