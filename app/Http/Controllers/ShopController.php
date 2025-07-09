<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;

class ShopController extends Controller
{
    public function index(Request $request)
{
    $size = $request->query('size') ? $request->query('size') : 12;
    $order = $request->query('order') ? $request->query('order') : -1;

    $o_column = '';
    $o_order = '';

    switch ($order) {
        case 1:
            $o_column = 'created_at';
            $o_order = 'DESC';
            break;
        case 2:
            $o_column = 'created_at';
            $o_order = 'ASC';
            break;
        case 3:
            $o_column = 'price';
            $o_order = 'ASC';
            break;
        case 4:
            $o_column = 'price';
            $o_order = 'DESC';
            break;
        default:
            $o_column = 'id';
            $o_order = 'DESC';
    }

    if ($o_column === 'price') {
        // Sort by sale_price if exists, else regular_price
        $products = Product::orderByRaw('COALESCE(sale_price, regular_price) ' . $o_order)
            ->paginate($size);
    } else {
        $products = Product::orderBy($o_column, $o_order)
            ->paginate($size);
    }

    $brands = Brand::orderBy('name','ASC')->get();
    return view('shop', compact('products', 'size', 'order','brands'));
}

    public function product_details($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->get()->take(8);
        return view('/product_details', compact('product', 'rproducts'));
    }
}
