<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function list(){
        $products = Product::OrderBy('created_at','DESC')->paginate(10);
        return view('admin/products/list',compact('products'));
    }

    public function add(){
        $categories = Category::select('id','name')->orderBy('created_at','DESC')->get();
        $brands = Brand::select('id','name')->orderBy('created_at','DESC')->get();
        return view('admin/products/add',compact('brands','categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:products,slug',
            'category_id'       => 'required|exists:categories,id',
            'brand_id'          => 'required|exists:brands,id',
            'short_description' => 'required|string|max:255',
            'description'       => 'required|string',
            'regular_price'     => 'required|numeric',
            'sale_price'        => 'required|numeric|lte:regular_price',
            'SKU'               => 'required|string|max:100',
            'quantity'          => 'required|integer',
            'stock_status'      => 'required|in:instock,outofstock',
            'featured'          => 'required|in:0,1',
            'image'             => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'images.*'          => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $ImageName = null;
        if ($request->hasFile('image')) {
            $Image = $request->file('image');
            $ImageName = time() . '_' . uniqid() . '.' . $Image->getClientOriginalExtension();
            $Image->move(public_path('uploads/products'), $ImageName);
        }
    
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug);
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->quantity = $request->quantity;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->image = $ImageName;
    
        if ($request->hasFile('images')) {
            $galleryImages = [];
            foreach ($request->file('images') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products/gallery'), $fileName);
                $galleryImages[] = $fileName;
            }
            $product->images = json_encode($galleryImages);
        }
    
        $product->save();
    
        return redirect()->route('admin.products')->with('success', 'Product added successfully!');
    }
    
}
