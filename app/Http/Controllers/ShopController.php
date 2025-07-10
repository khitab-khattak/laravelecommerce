<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size', 12);
        
        $f_brands = $request->query('brands', '');
        $f_categories = $request->query('categories', '');
        $order = $request->query('order', -1);

        $o_column = 'id';
        $o_order = 'DESC';

        // Handle sorting logic
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
        }

        $brandIds = array_filter(explode(',', $f_brands));
        $categoryIds = array_filter(explode(',', $f_categories));
        $min_price = $request->query('min') ? $request->query('min') : 1;
        $max_price = $request->query('max') ? $request->query('max') : 500;

        $query = Product::query();

        if (!empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
        }
        // Filter by brands if selected
        if (!empty($brandIds)) {
            $query->whereIn('brand_id', $brandIds);
        }
      
        // Handle sorting by price (sale or regular)
        if ($o_column === 'price') {
            $query->orderByRaw("COALESCE(sale_price, regular_price) $o_order");
        } else {
            $query->orderBy($o_column, $o_order);
        }
        $query->where(function ($q) use ($min_price, $max_price) {
            $q->whereBetween('sale_price', [$min_price, $max_price])
              ->orWhere(function ($q2) use ($min_price, $max_price) {
                  $q2->whereNull('sale_price')
                     ->whereBetween('regular_price', [$min_price, $max_price]);
              });
        });

        $products = $query->paginate($size)->withQueryString();
       
        $categories = Category::orderBy('name','ASC')->get();

        $brands = Brand::withCount('products')->orderBy('name', 'ASC')->get();

        return view('shop', compact('products', 'size', 'order', 'brands', 'f_brands','categories','f_categories','min_price','max_price'));
    }


    public function product_details($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->get()->take(8);
        return view('/product_details', compact('product', 'rproducts'));
    }
}
