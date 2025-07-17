<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function list()
    {
        $slides = Slide::orderBy('id', 'DESC')->paginate(12);
        return view('admin.slider.list', compact('slides'));
    }

    public function add()
    {
        return view('admin.slider.add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'tagline'   => 'required',
            'title'     => 'required',
            'subtitle'  => 'required',
            'link'      => 'required|url',
            'image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'    => 'required|in:0,1',
        ]);
    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/slides/'), $filename);
    
            Slide::create([
                'tagline'   => $request->tagline,
                'title'     => $request->title,
                'subtitle'  => $request->subtitle,
                'link'      => $request->link,
                'image'     => $filename,
                'status'    => $request->status,
            ]);
    
            return redirect()->route('admin.slider.list')->with('success', 'Slide has been added successfully.');
        }
    
        return redirect()->back()->withErrors(['image' => 'Image upload failed.']);
    }

    public function edit($id)
{
    $slide = Slide::findOrFail($id);
    return view('admin.slider.edit', compact('slide'));
}

public function update(Request $request, $id)
{
    $slide = Slide::findOrFail($id);

    $request->validate([
        'tagline' => 'required',
        'title' => 'required',
        'subtitle' => 'required',
        'link' => 'required|url',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'status' => 'required|in:0,1',
    ]);

    $data = $request->only(['tagline', 'title', 'subtitle', 'link', 'status']);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/slides/'), $filename);
        $data['image'] = $filename;
    }

    $slide->update($data);

    return redirect()->route('admin.slider.list')->with('success', 'Slide updated successfully.');
}


public function delete($id)
{
    $slide = Slide::findOrFail($id);

    // Full path to image
    $imagePath = public_path('uploads/slides/' . $slide->image);

    // ✅ Delete image from uploads/categories/ if it exists
    if (!empty($slide->image) && file_exists($imagePath)) {
        unlink($imagePath);
    }

    $slide->delete();

    return redirect()->route('admin.slider.list')->with('success', 'Slide has been deleted successfully.');
}

    
}
