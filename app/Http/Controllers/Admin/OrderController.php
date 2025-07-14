<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function list(){
        $orders = Order::orderBy('created_at','DESC')->paginate(10);
        return view('admin.orders.list',compact('orders'));
    }
}
