@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Slide</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="index.html">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="slider.html">
                        <div class="text-tiny">Slider</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit Slide</div>
                </li>
            </ul>
        </div>
        <!-- new-slide -->
        <div class="wg-box">
            
    @if (session('success'))
    <div class="alert alert-success mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="list-disc ml-5 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <form  enctype="multipart/form-data" class="form-new-product form-style-1" action="{{route('slider.update' , $slide->id)}}" method="POST">
                {{ csrf_field() }}
                @method('PUT')
                <fieldset class="name">
                    <div class="body-title">Tagline <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Tagline" value="{{$slide->tagline}}" name="tagline" required>
                </fieldset>
                
                <fieldset class="name">
                    <div class="body-title">Title <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Title" value="{{$slide->title}}" name="title" required>
                </fieldset>
                
                <fieldset class="name">
                    <div class="body-title">Subtitle <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Subtitle" value="{{$slide->subtitle}}" name="subtitle" required>
                </fieldset>
                
                <fieldset class="name">
                    <div class="body-title">Link <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Link" value="{{$slide->link}}" name="link" required>
                </fieldset>
               

                <fieldset class="mb-6">
                    <div class="body-title mb-2">
                        Upload Image <span class="tf-color-1">*</span>
                    </div>
                
                    <div class="upload-image w-full">
                        <div id="upload-file" class="item up-load relative w-full">
                            <label for="myFile"
                                class="uploadfile cursor-pointer text-center p-4 bg-white rounded-md w-full flex flex-col items-center gap-2 border border-dashed border-gray-300 hover:border-blue-400 transition">
                
                                <!-- New Image Preview (Initially Hidden) -->
                                <div id="imgpreview" class="w-full" style="display: none;">
                                    <img id="previewImage" src="#" alt="New Image Preview"
                                        class="w-full max-h-[200px] object-contain rounded-md border" />
                                </div>
                
                                <!-- Old Image Preview (Shown only if exists and no new image) -->
                                @if (!empty($slide->image))
                                <div id="oldImagePreview" class="w-full">
                                    <img src="{{ asset('uploads/slides/' . $slide->image) }}" alt="Old Image"
                                        class="w-full max-h-[200px] object-contain rounded-md border" />
                                </div>
                                @endif
                
                                <!-- Upload Icon + Text -->
                                <span class="icon text-gray-500">
                                    <i class="icon-upload-cloud text-3xl"></i>
                                </span>
                                <span class="body-text text-sm text-gray-600">
                                    Drop your image here or <span class="tf-color underline">click to browse</span>
                                </span>
                
                                <input type="file" id="myFile" name="image" accept="image/*" class="hidden">
                            </label>
                        </div>
                    </div>
                </fieldset>
                

                
                
                <fieldset class="status">
                    <div class="body-title">Status <span class="tf-color-1">*</span></div>
                    <div class="select flex-grow">
                        <select name="status" required>
                            <option value="">Select</option>
                            <option value="1" {{ old('status', $slide->status ?? '') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $slide->status ?? '') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </fieldset>                
                
                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
        <!-- /new-slide -->
    </div>
    <!-- /main-content-wrap -->
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('myFile').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById('previewImage');
        const newPreviewContainer = document.getElementById('imgpreview');
        const oldImageContainer = document.getElementById('oldImagePreview');

        if (file) {
            const imageUrl = URL.createObjectURL(file);
            previewImage.src = imageUrl;
            newPreviewContainer.style.display = 'block';

            if (oldImageContainer) {
                oldImageContainer.style.display = 'none';
            }
        } else {
            newPreviewContainer.style.display = 'none';
            previewImage.src = '#';

            if (oldImageContainer) {
                oldImageContainer.style.display = 'block';
            }
        }
    });
</script>

    
@endpush