@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="#"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="#"><div class="text-tiny">Products</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Edit product</div></li>
            </ul>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="list-disc ml-5 text-red-600">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
              action="{{ route('admin.edit-products',$product->id) }}">
            @csrf
            @method('PUT')

            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                           class="mb-10 @error('name') is-invalid @enderror" required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}"
                           class="mb-10 @error('slug') is-invalid @enderror" required>
                </fieldset>

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <select name="category_id" class="@error('category_id') is-invalid @enderror">
                            <option>Choose Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>

                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                        <select name="brand_id" class="@error('brand_id') is-invalid @enderror">
                            <option>Choose Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected($product->brand_id == $brand->id)>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150 @error('short_description') is-invalid @enderror" 
                              name="short_description"
                              placeholder="Short Description" 
                              tabindex="0" 
                              aria-required="true" 
                              required="">{{ old('short_description', $product->short_description) }}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                    @error('short_description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </fieldset>
                

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 @error('description') is-invalid @enderror" name="description" placeholder="Description"
                        tabindex="0" aria-required="true" required="">{{ old('description', $product->description) }}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </fieldset>
                
            </div>

            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Upload image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <!-- Show current image if available -->
                        <div class="item flex justify-center items-center" id="imgpreview"
                            style="height: 200px; {{ $product->image ? '' : 'display:none;' }}">
                            <img id="previewImage"
                                src="{{ $product->image ? asset('uploads/products/' . $product->image) : '#' }}"
                                class="object-contain h-full w-full rounded shadow">
                        </div>
                
                        <!-- File upload input -->
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">
                                    Drop your image here or select <span class="tf-color">click to browse</span>
                                </span>
                                <input type="file" id="myFile" name="image"
                                    accept="image/jpeg,image/png,image/jpg">
                            </label>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="body-title mb-10">Upload Gallery Images</div>
                    <div class="upload-image mb-16">
                        <div id="galUpload" class="item up-load">
                            <div id="galleryPreview" class="flex flex-wrap gap-4 mt-4">
                                @foreach (json_decode($product->images, true) as $img)
                                <div class="relative w-[200px] h-[200px] border rounded overflow-hidden shadow">
                                    <img src="{{ asset('uploads/products/gallery/' . $img) }}"
                                         class="object-contain w-full h-full rounded">
                                </div>
                            @endforeach
                            </div>
                            <input type="file" id="gFile" name="images[]" multiple class="mt-2"
                                   accept="image/jpeg,image/png,image/jpg">
                        </div>
                    </div>
                </fieldset>
                

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                        <input type="text" name="regular_price" value="{{ old('regular_price', $product->regular_price) }}"
                               class="@error('regular_price') is-invalid @enderror" required>
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price <span class="tf-color-1">*</span></div>
                        <input type="text" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}"
                               class="@error('sale_price') is-invalid @enderror" >
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                        <input type="text" name="SKU" value="{{ old('SKU', $product->SKU) }}"
                               class="@error('SKU') is-invalid @enderror" required>
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input type="text" name="quantity" value="{{ old('quantity', $product->quantity) }}"
                               class="@error('quantity') is-invalid @enderror" required>
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock</div>
                        <select name="stock_status" class="@error('stock_status') is-invalid @enderror">
                            <option value="instock" @selected($product->stock_status == 'instock')>InStock</option>
                            <option value="outofstock" @selected($product->stock_status == 'outofstock')>Out of Stock</option>
                        </select>
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title mb-10">Featured</div>
                        <select name="featured" class="@error('featured') is-invalid @enderror">
                            <option value="0" @selected(!$product->featured)>No</option>
                            <option value="1" @selected($product->featured)>Yes</option>
                        </select>
                    </fieldset>
                </div>

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Update Product</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById("myFile").addEventListener("change", function(event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById("previewImage");
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => previewImage.src = e.target.result;
            reader.readAsDataURL(file);
        }
    });

    document.getElementById("gFile").addEventListener("change", function(event) {
        const galleryPreview = document.getElementById("galleryPreview");
        galleryPreview.innerHTML = '';
        Array.from(event.target.files).forEach((file) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement("div");
                wrapper.className = "relative w-[200px] h-[200px] border rounded overflow-hidden shadow";

                const img = document.createElement("img");
                img.src = e.target.result;
                img.className = "object-contain w-full h-full";

                const removeBtn = document.createElement("button");
                removeBtn.innerHTML = "&times;";
                removeBtn.className = "btn btn-sm position-absolute top-0 end-0 m-1 d-flex align-items-center justify-content-center rounded-circle shadow";
                removeBtn.style.width = "20px";
                removeBtn.style.height = "20px";
                removeBtn.style.color = "#dc3545";
                removeBtn.style.border = "none";
                removeBtn.onclick = () => wrapper.remove();

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                galleryPreview.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
