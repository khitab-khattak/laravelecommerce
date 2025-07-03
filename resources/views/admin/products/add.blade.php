@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add Product</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="index-2.html">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="all-product.html">
                            <div class="text-tiny">Products</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Add product</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="list-disc ml-5 text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.store-products') }}">
                @csrf
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10 @error('name') is-invalid @enderror" type="text"
                            placeholder="Enter product name" name="name" tabindex="0" value="{{ old('name') }}"
                            aria-required="true" required="">

                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('slug') is-invalid @enderror" type="text"
                            placeholder="Enter product slug" name="slug" tabindex="0" value="{{ old('slug') }}"
                            aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="@error('category_id') is-invalid @enderror" name="category_id">
                                    <option>Choose category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="brand">
                            <div class="body-title mb-10">Brand <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="@error('brand_id') is-invalid @enderror" name="brand_id">
                                    <option>Choose Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach


                                </select>
                            </div>
                        </fieldset>
                    </div>

                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150 @error('short_description') is-invalid @enderror" name="short_description"
                            placeholder="Short Description" tabindex="0" aria-required="true" required=""></textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                        @error('short_description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                        </div>
                        <textarea class="mb-10 @error('description') is-invalid @enderror" name="description" placeholder="Description"
                            tabindex="0" aria-required="true" required=""></textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>
                </div>
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            <div class="item flex justify-center items-center" id="imgpreview"
                                style="display:none; height: 200px;">
                                <img id="previewImage" src="#" alt="Preview"
                                    class="object-contain h-full w-full rounded shadow">
                            </div>

                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click
                                            to browse</span></span>
                                    <input type="file" id="myFile" name="image"
                                        accept="image/jpeg,image/png,image/jpg" required>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Upload Gallery Images</div>
                        <div class="upload-image mb-16">
                            <div id="galUpload" class="item up-load">
                                <div id="galleryPreview" class="flex flex-wrap gap-4 mt-4"></div>
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or select <span class="tf-color">click
                                            to browse</span></span>
                                    <input type="file" id="gFile" name="images[]"
                                        accept="image/jpeg,image/png,image/jpg" multiple>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10 @error('regular_price') is-invalid @enderror" type="text"
                                placeholder="Enter regular price" name="regular_price" tabindex="0"
                                value="{{ old('regular_price') }}" aria-required="true" required="">
                            @error('regular_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Sale Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10 @error('sale_price') is-invalid @enderror" type="text"
                                placeholder="Enter sale price" name="sale_price" tabindex="0"
                                value="{{ old('sale_price') }}" aria-required="true" required="">
                            @error('sale_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                    </div>


                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10 @error('SKU') is-invalid @enderror" type="text"
                                placeholder="Enter SKU" name="SKU" tabindex="0" value="{{ old('SKU') }}"
                                aria-required="true" required="">
                            @error('SKU')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10 @error('quantity') is-invalid @enderror" type="text"
                                placeholder="Enter quantity" name="quantity" tabindex="0"
                                value="{{ old('quantity') }}" aria-required="true" required="">
                            @error('quantity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select class="@error('stock_status') is-invalid @enderror" name="stock_status">
                                    <option value="instock">InStock</option>
                                    <option value="outofstock">Out of Stock</option>
                                </select>
                            </div>

                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured</div>
                            <div class="select mb-10">
                                <select class="@error('featured') is-invalid @enderror" name="featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            @error('featured')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Add product</button>
                    </div>
                </div>
            </form>
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById("myFile").addEventListener("change", function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById("imgpreview");
            const previewImage = document.getElementById("previewImage");

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });
        document.getElementById("gFile").addEventListener("change", function(event) {
            const files = event.target.files;
            const galleryPreview = document.getElementById("galleryPreview");

            galleryPreview.innerHTML = ''; // Clear previous

            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create wrapper div
                    const wrapper = document.createElement("div");
                    wrapper.className =
                        "relative w-[200px] h-[200px] border rounded overflow-hidden shadow";

                    // Create image
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "object-contain w-full h-full";

                    // Create remove button
                    const removeBtn = document.createElement("button");
                    removeBtn.innerHTML = "&times;";
                    removeBtn.className =
                        "btn btn-sm position-absolute top-0 end-0 m-1 d-flex align-items-center justify-content-center rounded-circle shadow";
                    removeBtn.style.width = "20px";
                    removeBtn.style.height = "20px";
                    removeBtn.style.color = "#dc3545"; // Bootstrap red
                    removeBtn.style.fontSize = "14px";
                    removeBtn.style.border = "none";

                    removeBtn.type = "button";
                    removeBtn.onclick = () => wrapper.remove();

                    // Append
                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    galleryPreview.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
