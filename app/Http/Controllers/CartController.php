<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Order;
use GuzzleHttp\Promise\Create;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }
    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        if ($product) {
            $qty = $product->qty + 1;
            Cart::instance('cart')->update($rowId, $qty);
        }
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        if ($product && $product->qty > 1) {
            $qty = $product->qty - 1;
            Cart::instance('cart')->update($rowId, $qty);
        } else {
            Cart::instance('cart')->remove($rowId);
        }
        return redirect()->back();
    }

    public function delete_cart_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back()->with('success', 'Item Removed Sucessfully');
    }

    public function clear_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back()->with('success', 'Cart cleared successfully');
    }

    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if (isset($coupon_code)) {
            $coupon = Coupon::where('code', $coupon_code)->where('expiry_date', '>=', Carbon::today())->where('cart_value', '<=', Cart::instance('cart')->subtotal())->first();
            if (!$coupon) {
                return redirect()->back()->with('error', 'Invalid coupon code!');
            } else {
                $request->session()->put('coupon', [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value,
                ]);
                $this->calculateDiscount($request);
                return redirect()->back()->with('success', 'Coupon has been applied!');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid coupon code!');
        }
    }
    public function calculateDiscount(Request $request)
    {
        $discount = 0;

        if ($request->session()->has('coupon')) {
            $cartSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
            $coupon = $request->session()->get('coupon');

            $isCapped = false;

            if ($coupon['type'] == 'fixed') {
                if ($coupon['value'] > $cartSubtotal) {
                    $discount = $cartSubtotal;
                    $isCapped = true;
                } else {
                    $discount = $coupon['value'];
                }
            } else {
                $discount = ($cartSubtotal * $coupon['value']) / 100;
                if ($discount > $cartSubtotal) {
                    $discount = $cartSubtotal;
                    $isCapped = true;
                }
            }

            $subtotalAfterDiscount = max(0, $cartSubtotal - $discount);
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
            $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

            // Store discount session
            session()->put('discounts', [
                'discount' => number_format($discount, 2, '.', ''),
                'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
                'tax' => number_format($taxAfterDiscount, 2, '.', ''),
                'total' => number_format($totalAfterDiscount, 2, '.', ''),
            ]);

            // Flash capped message
            if ($isCapped) {
                session()->flash('coupon_capped', 'Coupon discount exceeds cart total — discount capped.');
            }
        }
    }
    public function removeCoupon(Request $request)
    {
        // Remove coupon data from session
        $request->session()->forget('coupon');
        $request->session()->forget('discounts');

        return back()->with('success', 'Coupon removed successfully.');
    }
    public function clear(Request $request)
    {
        // Destroy the entire cart
        Cart::instance('cart')->destroy();

        // Remove coupon-related sessions if any
        $request->session()->forget('coupon');
        $request->session()->forget('discounts');

        return back()->with('success', 'Cart cleared successfully.');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        return view('checkout', compact('address'));
    }

    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('is_default', true)->first();

        if (!$address) {
            $validated = $request->validate([
                'name'  => 'required|max:100',
                'phone' => 'required|numeric|digits:11',
                'zip'   => 'required|numeric|digits:6',
                'state' => 'required',
                'city'   => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required',
            ]);
            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = 'Pakistan';
            $address->user_id = $user_id;
            $address->is_default = true;
            $address->save();
        }
        $this->setAmountforCheckout($request);


        $order = new Order();
        $order->user_id  = $user_id;
        $order->subtotal  = $request->session()->get('checkout')['subtotal'];
        $order->discount  = $request->session()->get('checkout')['discount'];
        $order->tax  = $request->session()->get('checkout')['tax'];
        $order->total  = $request->session()->get('checkout')['total'];
        $order->name  = $address->name;
        $order->phone  = $address->phone;
        $order->locality  = $address->locality;
        $order->address  = $address->address;
        $order->city  = $address->city;
        $order->state  = $address->state;
        $order->country  = $address->country;
        $order->landmark  = $address->landmark;
        $order->zip  = $address->zip;
        $order->save();
        foreach (Cart::instance('cart')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();
        }
        if ($request->mode == "card") {
            //
        } elseif ($request->mode == "paypal") {
            //
        } elseif ($request->mode == "cod") {
            $transaction = new Transaction;
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = "pending";
            $transaction->save();
        }
        Cart::instance('cart')->destroy();
        $request->session()->forget('checkout');
        $request->session()->forget('coupon');
        $request->session()->forget('discounts');
        $request->session()->put('order_id',$order->id);
        return redirect()->route('cart.orderConfirmation',compact('order'));
    }
    public function setAmountforCheckout(Request $request)
    {
        if (!Cart::instance('cart')->content()->count()>0) {
            $request->session()->forget('checkout');
            return;
        }

        if ($request->session()->has('coupon')) {
            $request->session()->put('checkout', [
                'discount' => $request->session()->get('discounts')['discount'],
                'subtotal' => $request->session()->get('discounts')['subtotal'],
                'tax' => $request->session()->get('discounts')['tax'],
                'total' => $request->session()->get('discounts')['total'],
            ]);
        } else {
            $request->session()->put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }
    public function order_confirmation(){
        if(session()->has('order_id')){
            $order = Order::find(session()->get('order_id'));
            return view('order-confirmation',compact('order'));
        }
        return redirect()->route('cart.index');
    }
}
