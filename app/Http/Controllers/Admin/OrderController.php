<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;

class OrderController extends Controller
{
    public function list(){
        $orders = Order::orderBy('created_at','DESC')->paginate(10);
        return view('admin.orders.list',compact('orders'));
    }

    public function details($order_id){
        $order = Order::find($order_id);
        $order_items = OrderItem::where('order_id',$order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id',$order_id)->first();
        return view('admin.orders.details',compact('order','order_items','transaction'));
    }
}
