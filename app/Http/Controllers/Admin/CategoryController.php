<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function list(){
        $category = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin/categories/list',compact('category'));
    }

    public function add(){
        return view('admin/categories/add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:categories,slug',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/categories/'), $filename);
            $category->image = $filename; // ✅ Store only filename
        }
        

        $category->save();

        return redirect()->route('admin.category')->with('success', 'category Added Successfully');
    }

    public function category_edit($id, Request $request)
    {
        $category = category::find($id);
        return view('admin.categories.edit', compact('category'));
    }
    public function category_update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
    
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug); // Slugify if needed
    
        if ($request->hasFile('image')) {
            // Delete old image
            $oldPath = public_path('uploads/categories/' . $category->image);
            if ($category->image && file_exists($oldPath)) {
                unlink($oldPath);
            }
    
            // Save new image
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $filename);
            $category->image = $filename;
        }
    
        $category->save();
    
        return redirect()->route('admin.category')->with('success', 'category updated successfully.');
    }
    
    public function category_delete($id)
{
    $category = Category::findOrFail($id);

    // Full path to image
    $imagePath = public_path('uploads/categories/' . $category->image);

    // ✅ Delete image from uploads/categories/ if it exists
    if (!empty($category->image) && file_exists($imagePath)) {
        unlink($imagePath);
    }

    // ✅ Delete the category record from database
    $category->delete();

    return redirect()->route('admin.category')->with('success', 'category and its image deleted successfully.');
}
}
