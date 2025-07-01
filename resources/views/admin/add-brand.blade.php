@extends('layouts.admin')

@section('content')
<div class="main-content-wrap">
    <div class="flex items-center flex-wrap justify-between gap20 mb-27">
        <h3>Brand Information</h3>
        <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
            <li>
                <a href="#"><div class="text-tiny">Dashboard</div></a>
            </li>
            <li><i class="icon-chevron-right"></i></li>
            <li>
                <a href="#"><div class="text-tiny">Brands</div></a>
            </li>
            <li><i class="icon-chevron-right"></i></li>
            <li><div class="text-tiny">New Brand</div></li>
        </ul>
    </div>

    <!-- New Brand Form -->
    <div class="wg-box">
        <form class="form-new-product form-style-1" 
              action="{{ route('admin.store-brands') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf

            <!-- Brand Name -->
            <fieldset class="name">
                <div class="body-title">Brand Name <span class="tf-color-1">*</span></div>
                <input class="flex-grow" type="text" placeholder="Brand name" name="name" required>
            </fieldset>

            <!-- Brand Slug -->
            <fieldset class="name">
                <div class="body-title">Brand Slug <span class="tf-color-1">*</span></div>
                <input class="flex-grow" type="text" placeholder="Brand slug" name="slug" required>
            </fieldset>

            <!-- Image Upload with Preview -->
            <fieldset>
                <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>

                <div class="upload-image flex-grow">
                    <!-- Preview Area -->
                    <div class="item" id="imgpreview" style="display: none;">
                        <img id="previewImage" 
                             src="#" 
                             class="effect8" 
                             alt="Image Preview" 
                             style="max-height: 150px; border-radius: 8px;" />
                    </div>

                    <!-- Upload Button -->
                    <div id="upload-file" class="item up-load">
                        <label class="uploadfile" for="myFile">
                            <span class="icon">
                                <i class="icon-upload-cloud"></i>
                            </span>
                            <span class="body-text">
                                Drop your images here or select 
                                <span class="tf-color">click to browse</span>
                            </span>
                            <input type="file" id="myFile" name="image" accept="image/*">
                        </label>
                    </div>
                </div>
            </fieldset>

            <!-- Submit Button -->
            <div class="bot">
                <div></div>
                <button class="tf-button w208" type="submit">Save</button>
            </div>
        </form>
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
        } else {
            previewImage.src = '#';
            previewContainer.style.display = 'none';
        }
    });
</script>
@endpush
