<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Brand;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin/index');
    }
    public function logout()
    {
        Auth::logout();

        return redirect('/login')->with('success', 'You have been logged out.');
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin/brands', compact('brands'));
    }

    public function brand_add()
    {
        return view('admin/add-brand');
    }

    public function brand_store(Request $request)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'slug'  => 'required|string|unique:brands,slug',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);

    $brand = new Brand;
    $brand->name = $request->name;
    $brand->slug = Str::slug($request->slug);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('upload/brand/'), $filename);
        $brand->image = 'upload/brand/' . $filename;
    }

    $brand->save();

    return redirect()->route('admin.brands')->with('success', 'Brand Added Successfully');
}

}
