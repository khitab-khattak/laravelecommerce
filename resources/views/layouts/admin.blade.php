<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <title>Surfside Media</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<style>
    .sub-menu-item.active a {
    color: #fd590d;
    font-weight: bold;
}
</style><style>
    .search-popup__results {
        background: #fff;
        border: 1px solid #ddd;
        margin-top: 10px;
        border-radius: 6px;
        max-height: 400px;
        overflow-y: auto;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    #box-content-search {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    #box-content-search li {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border-bottom: 1px solid #f1f1f1;
        transition: background-color 0.2s ease;
    }
    
    #box-content-search li:hover {
        background-color: #f9f9f9;
    }
    
    #box-content-search img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 15px;
        border-radius: 6px;
        border: 1px solid #e0e0e0;
    }
    
    #box-content-search .product-info {
        flex-grow: 1;
    }
    
    #box-content-search .product-name {
        font-weight: 500;
        margin-bottom: 4px;
        color: #333;
    }
    
    #box-content-search .product-link {
        color: #333;
        text-decoration: none;
        display: flex;
        align-items: center;
        width: 100%;
    }
    
    #box-content-search .product-link:hover .product-name {
        text-decoration: underline;
    }
    </style>


<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">
                <div class="section-menu-left">
                    <div class="box-logo">
                        <a href="{{ route('admin.index') }}" id="site-logo-inner">
                            <img class="" id="logo_header" alt=""
                                src=" {{ asset('images/logo/logo.png') }} "
                                data-light="{{ asset('images/logo/logo.png') }}"
                                data-dark="{{ asset('images/logo/logo.png') }}">
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading">Main Home</div>
                            <ul class="menu-list">
                                <li class="menu-item {{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
                                    <a href="{{ route('admin.index') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Dashboard</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @php
                        $currentRoute = Route::currentRouteName();
                    @endphp
                        <div class="center-item">
                            <ul class="menu-list">
                                <li class="menu-item has-children {{ in_array($currentRoute, ['admin.add-products', 'admin.products']) ? 'active' : '' }}">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Products</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{route('admin.add-products')}}" class="">
                                                <div class="text">Add Product</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.products')}}" class="">
                                                <div class="text">Products</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children {{ in_array(Request::segment(2), ['brands', 'add-brands']) ? 'active' : '' }}">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Brand</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item {{ Request::segment(2) == 'add-brands' ? 'active' : '' }}">
                                            <a href="{{route('admin.add-brands')}}" class="">
                                                <div class="text">New Brand</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item {{ Request::segment(2) == 'brands' ? 'active' : '' }}">
                                            <a href="{{ route('admin.brands') }}" class="">
                                                <div class="text">Brands</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                              
                            
                            <li class="menu-item has-children {{ in_array($currentRoute, ['admin.add-category', 'admin.category']) ? 'active' : '' }}">
                                <a href="javascript:void(0);" class="menu-item-button">
                                    <div class="icon"><i class="icon-layers"></i></div>
                                    <div class="text">Category</div>
                                </a>
                                <ul class="sub-menu">
                                    <li class="sub-menu-item {{ $currentRoute == 'admin.add-category' ? 'active' : '' }}">
                                        <a href="{{ route('admin.add-category') }}">
                                            <div class="text">New Category</div>
                                        </a>
                                    </li>
                                    <li class="sub-menu-item {{ $currentRoute == 'admin.category' ? 'active' : '' }}">
                                        <a href="{{ route('admin.category') }}">
                                            <div class="text">Categories</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                                

                            <li class="menu-item has-children {{ in_array($currentRoute, ['admin.orders']) ? 'active' : '' }}">

                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-file-plus"></i></div>
                                        <div class="text">Order</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{route('admin.orders')}}" class="">
                                                <div class="text">Orders</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="order-tracking.html" class="">
                                                <div class="text">Order tracking</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item {{$currentRoute == 'admin.slider.list' ? 'active':''}}">
                                    <a href="{{route('admin.slider.list')}}" class="">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Slider</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ $currentRoute == 'coupons.list' ? 'active' : '' }}">
                                    <a href="{{route('coupons.list')}}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Coupons</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('admin.contact-show') ? 'active' : '' }}">
                                    <a href="{{ route('admin.contact-show') }}">
                                        <div class="icon"><i class="icon-mail"></i></div>
                                        <div class="text">Messages</div>
                                    </a>
                                </li>
                                

                                <li class="menu-item">
                                    <a href="users.html" class="">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">User</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="settings.html" class="">
                                        <div class="icon"><i class="icon-settings"></i></div>
                                        <div class="text">Settings</div>
                                    </a>
                                </li>
                                <form action="{{ route('admin.logout') }}" method="POST" id="logout-form">
                                    @csrf
                                    <li class="menu-item">
                                        <a href="{{ route('admin.logout') }}" class="" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            <div class="icon"><i class="icon-user"></i></div>
                                            <div class="text">Logout</div>
                                        </a>
                                    </li>
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="section-content-right">

                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                                <a href="index-2.html">
                                    <img class="" id="logo_header_mobile" alt=""
                                        src="{{ asset('images/logo/logo.png') }}"
                                        data-light="{{ asset('images/logo/logo.png') }}"
                                        data-dark="{{ asset('images/logo/logo.png') }}" data-width="154px"
                                        data-height="52px" data-retina="{{ asset('images/logo/logo.png') }}">
                                </a>
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>


                                <form class="form-search flex-grow">
                                    <fieldset class="name">
                                        <input type="text" placeholder="Search here..." class="show-search"
                                            name="name" id="search-product" tabindex="2" value="" aria-required="true"
                                            required="" autocomplete="off">
                                    </fieldset>
                                    <div class="button-submit">
                                        <button class="" type="submit"><i class="icon-search"></i></button>
                                    </div>
                                    <div class="box-content-search" id="box-content-search">
                                        <ul id="box-content-search"></ul> <!-- Fix ID spelling -->
                                    </div>
                                </form>

                            </div>
                            <div class="header-grid">

                                <div class="popup-wrap message type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-item">
                                                <span class="text-tiny">1</span>
                                                <i class="icon-bell"></i>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton2">
                                            <li>
                                                <h6>Notifications</h6>
                                            </li>
                                            <li>
                                                <div class="message-item item-1">
                                                    <div class="image">
                                                        <i class="icon-noti-1"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Discount available</div>
                                                        <div class="text-tiny">Morbi sapien massa, ultricies at rhoncus
                                                            at, ullamcorper nec diam</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-2">
                                                    <div class="image">
                                                        <i class="icon-noti-2"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Account has been verified</div>
                                                        <div class="text-tiny">Mauris libero ex, iaculis vitae rhoncus
                                                            et</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-3">
                                                    <div class="image">
                                                        <i class="icon-noti-3"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Order shipped successfully</div>
                                                        <div class="text-tiny">Integer aliquam eros nec sollicitudin
                                                            sollicitudin</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-4">
                                                    <div class="image">
                                                        <i class="icon-noti-4"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Order pending: <span>ID 305830</span>
                                                        </div>
                                                        <div class="text-tiny">Ultricies at rhoncus at ullamcorper
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li><a href="#" class="tf-button w-full">View all</a></li>
                                        </ul>
                                    </div>
                                </div>




                                <div class="popup-wrap user type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-user wg-user">
                                                <span class="image">
                                                    <img src="{{ asset('images/avatar/user-1.png') }}"
                                                        alt="">
                                                </span>
                                                <span class="flex flex-column">
                                                    <span class="body-title mb-2">Kristin Watson</span>
                                                    <span class="text-tiny">Admin</span>
                                                </span>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton3">
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-user"></i>
                                                    </div>
                                                    <div class="body-title-2">Account</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-mail"></i>
                                                    </div>
                                                    <div class="body-title-2">Inbox</div>
                                                    <div class="number">27</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-file-text"></i>
                                                    </div>
                                                    <div class="body-title-2">Taskboard</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-headphones"></i>
                                                    </div>
                                                    <div class="body-title-2">Support</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="login.html" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-log-out"></i>
                                                    </div>
                                                    <div class="body-title-2">Log out</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="main-content">
                        @yield('content')


                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2024 SurfsideMedia</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(function () {
            $("#search-product").on("keyup", function () {
                var searchQuery = $(this).val().trim();
        
                if (searchQuery.length > 2) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.search') }}",
                        data: { query: searchQuery },
                        dataType: 'json',
                        success: function (data) {
                            $("#box-content-search").html('');
        
                            if (data.length === 0) {
                                $("#box-content-search").html('<li class="px-3 py-2 text-muted">No results found</li>');
                                return;
                            }
        
                            $.each(data, function (index, item) {
                                var url = "{{ route('admin.edit-products', ['id' => 'product_id']) }}";
                                var link = url.replace('product_id', item.id);
        
                                $("#box-content-search").append(`
                                    <li>
                                        <a href="${link}" class="product-link">
                                            <img src="{{ asset('uploads/products') }}/${item.image}" alt="${item.name}">
                                            <div class="product-info">
                                                <div class="product-name">${item.name}</div>
                                            </div>
                                        </a>
                                    </li>
                                `);
                            });
                        }
                    });
                } else {
                    $("#box-content-search").html('');
                }
            });
        });
        </script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>


</body>

</html>
