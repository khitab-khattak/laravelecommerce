<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{

    public function index()
    {
        $items = Cart::instance('wishlist')->content();
        return view('wishlist', compact('items'));
    }

    public function add_to_wishlist(Request $request)
    {
        Cart::instance('wishlist')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function remove_wishlist_item($rowId){
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back()->with('success','Item Removed Sucessfully');

    }

    public function clear_wishlist()
    {
        Cart::instance('wishlist')->destroy();
        return redirect()->back()->with('success', 'Cart cleared successfully');
    }

    public function move_to_cart($rowId){
        $item =Cart::instance('wishlist')->get($rowId);
        Cart::instance('wishlist')->remove($rowId);
        Cart::instance('cart')->add($item->id,$item->name,$item->qty,$item->price)->associate('App\Models\Product');
        return redirect()->back();
    }
}
