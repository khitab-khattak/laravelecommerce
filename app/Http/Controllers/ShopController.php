<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
{
    $size = $request->query('size', 12); // default is 12 if not selected
    $products = Product::orderBy('created_at', 'desc')->paginate($size);

    return view('shop', compact('products', 'size'));
}


    public function product_details($product_slug){
        $product = Product::where('slug',$product_slug)->first();
        $rproducts = Product::where('slug','<>', $product_slug)->get()->take(8);
        return view('/product_details',compact('product','rproducts'));
    }
}
