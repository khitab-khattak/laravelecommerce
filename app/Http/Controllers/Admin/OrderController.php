<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function list(){
        $orders = Order::orderBy('created_at','DESC')->paginate(10);
        return view('admin.orders.list',compact('orders'));
    }

    public function details($order_id){
        $order = Order::find($order_id);
        $order_items = OrderItem::where('order_id',$order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id',$order->id)->first();
        return view('admin.orders.details',compact('order','order_items','transaction'));
    }

    public function update_order_status(Request $request){
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        if($request->order_status == 'delivered'){
            $order->delivered_date = Carbon::now();
        }elseif($request->order_status == 'canceled'){
            $order->canceled_date = Carbon::now();
        }
        $order -> save();
        if($request->order_status == 'delivered'){
            $transaction = Transaction::where('order_id',$request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();

        }
        return back()->with("status","Status changed Successfully");
    }
}
