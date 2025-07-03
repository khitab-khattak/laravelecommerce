@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Category</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="#">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="#">
                        <div class="text-tiny">Category</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <div class="text-tiny">Edit Category</div>
                </li>
            </ul>
        </div>

        <!-- Edit Category Form -->
        <div class="wg-box">
            <form class="form-new-product form-style-1"
                action="{{ route('admin.update-category',$category->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Category Name -->
                <fieldset class="name">
                    <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Category name" name="name"
                        value="{{ old('name', $category->name) }}" required>
                </fieldset>

                <!-- category Slug -->
                <fieldset class="name">
                    <div class="body-title">category Slug <span class="tf-color-1">*</span></div>
                    <input class="flex-grow @error('slug') is-invalid @enderror\" type="text" placeholder="Category slug" name="slug"
                        value="{{ old('slug', $category->slug) }}" required>
                </fieldset>
                @error('slug')
                <div class="alert alert-danger text-center" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror

                <!-- Image Upload with Preview -->
                <fieldset class="mb-6">
                    <div class="body-title mb-2">
                        Upload Image <span class="tf-color-1">*</span>
                    </div>
                
                    <div class="upload-image flex-grow">
                        <div id="upload-file" class="item up-load relative bg-transparent">
                            <label class="uploadfile cursor-pointer block text-center p-4 bg-white rounded-md"
                                   for="myFile"
                                   style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                
                                <!-- Image Preview: Show existing category image -->
                                <div id="imgpreview" style="display: block;">
                                    <img id="previewImage"
                                    src="{{ asset('uploads/categories/' . $category->image) }}"
                                    alt="Image Preview"
                                    style="max-height: 150px; border-radius: 8px; background: transparent; box-shadow: none;" />
                               
                                </div>
                
                                <!-- Upload Icon and Text -->
                                <span class="icon">
                                    <i class="icon-upload-cloud text-2xl"></i>
                                </span>
                                <span class="body-text">
                                    Drop your images here or
                                    <span class="tf-color underline">click to browse</span>
                                </span>
                
                                <!-- File Input -->
                                <input type="file" id="myFile" name="image" accept="image/*" class="hidden">
                            </label>
                        </div>
                    </div>
                </fieldset>
                

                <!-- Submit Button -->
                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('myFile').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById('previewImage');
        const previewContainer = document.getElementById('imgpreview');

        if (file) {
            const imageUrl = URL.createObjectURL(file);
            previewImage.src = imageUrl;
            previewContainer.style.display = 'block';
        }
    });
</script>
@endpush

