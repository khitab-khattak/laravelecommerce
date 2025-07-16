<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function list(){
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);
        return view ('user.orders.list',compact('orders'));
    }

    
    public function details($order_id){
        $order = Order::where('user_id',Auth::user()->id)->where('id',$order_id)->first();
        if($order){
            
            $order_items = OrderItem::where('order_id',$order_id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('order_id',$order_id)->first();
            return view('user.orders.details',compact('order','order_items','transaction'));
        }
        else{
            return redirect()->route('login');
        }
       
    }
    public function order_cancel(Request $request){
        $order = Order::find($request->order_id);
        $order->status = "canceled";
        $order->canceled_date = Carbon::now();
        $order->save();
        return back()->with("status","Order has been cancelled successfully");
    }
}
