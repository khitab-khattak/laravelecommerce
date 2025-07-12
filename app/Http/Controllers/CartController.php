<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;

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

    public function delete_cart_item($rowId){
        Cart::instance('cart')->remove($rowId);
        return redirect()->back()->with('success','Item Removed Sucessfully');

    }

    public function clear_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back()->with('success', 'Cart cleared successfully');
    }
    
    public function apply_coupon_code(Request $request){
        $coupon_code = $request->coupon_code;
        if(isset($coupon_code)){
            $coupon = Coupon::where('code',$coupon_code)->where('expiry_date','>=',Carbon::today())->where('cart_value','<=',Cart::instance('cart')->subtotal())->first();
            if(!$coupon){
                return redirect()->back()->with('error','Invalid coupon code!');
            }else{
                $request->session()->put('coupon',[
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value,
                ]);
                $this->calculateDiscount($request);
                return redirect()->back()->with('success','Coupon has been applied!');
            }
        }else
        {
            return redirect()->back()->with('error','Invalid coupon code!');
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

    
}
