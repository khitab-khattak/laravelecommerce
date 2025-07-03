<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin/brands/brands', compact('brands'));
    }

    public function brand_add()
    {
        return view('admin/brands/add-brand');
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
            $file->move(public_path('uploads/brands/'), $filename);
            $brand->image = $filename; // ✅ Store only filename
        }
        

        $brand->save();

        return redirect()->route('admin.brands')->with('success', 'Brand Added Successfully');
    }

    public function brand_edit($id, Request $request)
    {
        $brand = Brand::find($id);
        return view('admin.brands.edit-brand', compact('brand'));
    }
    public function brand_update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug,' . $brand->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
    
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->slug); // Slugify if needed
    
        if ($request->hasFile('image')) {
            // Delete old image
            $oldPath = public_path('uploads/brands/' . $brand->image);
            if ($brand->image && file_exists($oldPath)) {
                unlink($oldPath);
            }
    
            // Save new image
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/brands'), $filename);
            $brand->image = $filename;
        }
    
        $brand->save();
    
        return redirect()->route('admin.brands')->with('success', 'Brand updated successfully.');
    }
    
    public function brand_delete($id)
{
    $brand = Brand::findOrFail($id);

    // Full path to image
    $imagePath = public_path('uploads/brands/' . $brand->image);

    // ✅ Delete image from uploads/brands/ if it exists
    if (!empty($brand->image) && file_exists($imagePath)) {
        unlink($imagePath);
    }

    // ✅ Delete the brand record from database
    $brand->delete();

    return redirect()->route('admin.brands')->with('success', 'Brand and its image deleted successfully.');
}

}
