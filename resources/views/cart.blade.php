@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>

        <section class="shop-checkout container">
            <h2 class="page-title">Cart</h2>




            {{-- Flash error --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Checkout steps --}}
            <div class="checkout-steps">
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping and Checkout</span>
                        <em>Checkout Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Review And Submit Your Order</em>
                    </span>
                </a>
            </div>

            {{-- Shopping Cart --}}
            <div class="shopping-cart">
                @if (Cart::instance('cart')->content()->count() > 0)
                    <div class="cart-table__wrapper">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th></th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('uploads/products/' . $item->model->image) }}" width="120"
                                                height="120" alt="{{ $item->name }}">
                                        </td>
                                        <td>
                                            <h4>{{ $item->name }}</h4>
                                            <ul>
                                                <li>Color: Yellow</li>
                                                <li>Size: L</li>
                                            </ul>
                                        </td>
                                        <td>${{ $item->price }}</td>
                                        <td>
                                            <div class="qty-control position-relative">
                                                <input type="number" name="quantity" value="{{ $item->qty }}"
                                                    min="1" class="qty-control__number text-center">

                                                <form action="{{ route('cart.qty.decrease', $item->rowId) }}"
                                                    method="POST">
                                                    @csrf @method('put')
                                                    <div class="qty-control__reduce">-</div>
                                                </form>

                                                <form action="{{ route('cart.qty.increase', $item->rowId) }}"
                                                    method="POST">
                                                    @csrf @method('put')
                                                    <div class="qty-control__increase">+</div>
                                                </form>
                                            </div>
                                        </td>
                                        <td>${{ $item->subtotal() }}</td>
                                        <td>
                                            <form action="{{ route('cart.remove', $item->rowId) }}" method="POST"
                                                style="display:inline">
                                                @csrf @method('delete')
                                                <button type="submit" class="remove-cart"
                                                    style="background:none;border:none;padding:0;">
                                                    <svg width="10" height="10" fill="#767676"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                        <path
                                                            d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Cart Footer --}}
                        <div class="cart-table-footer">

                            {{-- Apply Coupon --}}
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" class="mb-3">
                                @csrf

                                {{-- Alert Messages --}}
                                @if (session('coupon_capped'))
                                    <div class="alert alert-warning mb-2">
                                        {{ session('coupon_capped') }}
                                    </div>
                                @elseif (session()->has('coupon'))
                                    <div class="alert alert-success mb-2">
                                        <strong>{{ session('coupon')['code'] }}</strong> coupon applied successfully!
                                    </div>
                                @endif

                                {{-- Coupon Input Group --}}
                                <div class="input-group">
                                    <input type="text" name="coupon_code" class="form-control" placeholder="Coupon Code"
                                        value="{{ session('coupon')['code'] ?? '' }}"
                                        {{ session()->has('coupon') ? 'readonly' : '' }}>

                                    <button type="submit" class="btn btn-primary"
                                        {{ session()->has('coupon') ? 'disabled' : '' }}>
                                        APPLY COUPON
                                    </button>
                                </div>
                            </form>

                            {{-- Remove & Clear Buttons --}}
                            <div class="d-flex flex-wrap gap-2">
                                @if (session()->has('coupon'))
                                    <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Remove Coupon</button>
                                    </form>
                                @endif

                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light">Clear Cart</button>
                                </form>
                            </div>
                        </div>

                    </div>

                    {{-- Cart Totals --}}
                    <div class="shopping-cart__totals-wrapper">
                        <div class="sticky-content">
                            <div class="shopping-cart__totals">
                                <h3>Cart Totals</h3>
                                <table class="cart-totals">
                                    <tbody>
                                        @if (Session::has('discounts'))
                                            <tr>
                                                <th>Subtotal</th>
                                                <td>${{ Cart::instance('cart')->subtotal() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount ({{ Session::get('coupon')['code'] }})</th>
                                                <td>${{ Session::get('discounts')['discount'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Subtotal After Discount</th>
                                                <td>${{ Session::get('discounts')['subtotal'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td>Free</td>
                                            </tr>
                                            <tr>
                                                <th>VAT</th>
                                                <td>${{ Session::get('discounts')['tax'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td>${{ Session::get('discounts')['total'] }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <th>Subtotal</th>
                                                <td>${{ Cart::subtotal() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td>Free</td>
                                            </tr>
                                            <tr>
                                                <th>VAT</th>
                                                <td>${{ Cart::tax() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td>${{ Cart::total() }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            {{-- Checkout CTA --}}
                            <div class="mobile_fixed-btn_wrapper">
                                <div class="button-wrapper container">
                                    <a href="" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Empty Cart --}}
                    <div class="row">
                        <div class="col md-12 text-center pt-5 pb-5">
                            <p>No items found in your cart</p>
                            <a class="btn btn-info" href="{{ route('shop.index') }}">Shop Now</a>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        $(function() {
            $(".qty-control__increase").on("click", function() {
                $(this).closest('form').submit();
            });

            $(".qty-control__reduce").on("click", function() {
                $(this).closest('form').submit();
            });
        });
    </script>
@endpush
