 @extends('layouts.app')
 @section('content')
     <main class="pt-90">
         <div class="mb-4 pb-4"></div>
         <section class="shop-checkout container">
             <h2 class="page-title">Wishlist</h2>
             @if (session('success'))
             <div class="alert alert-success alert-dismissible fade show" role="alert">
                 {{ session('success') }}
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
         @endif
             <div class="checkout-steps">
                 <a href="shop_cart.html" class="checkout-steps__item active">
                     <span class="checkout-steps__item-number">01</span>
                     <span class="checkout-steps__item-title">
                         <span>Shopping Bag</span>
                         <em>Manage Your Items List</em>
                     </span>
                 </a>
                 <a href="shop_checkout.html" class="checkout-steps__item">
                     <span class="checkout-steps__item-number">02</span>
                     <span class="checkout-steps__item-title">
                         <span>Shipping and Checkout</span>
                         <em>Checkout Your Items List</em>
                     </span>
                 </a>
                 <a href="shop_order_complete.html" class="checkout-steps__item">
                     <span class="checkout-steps__item-number">03</span>
                     <span class="checkout-steps__item-title">
                         <span>Confirmation</span>
                         <em>Review And Submit Your Order</em>
                     </span>
                 </a>
             </div>
             <div class="shopping-cart">
                @if (Cart::instance('wishlist')->content()->count() > 0)
                 <div class="cart-table__wrapper">
                     <table class="cart-table">
                         <thead>
                             <tr>
                                 <th>Product</th>
                                 <th></th>
                                 <th>Price</th>
                                 <th>Quantity</th>
                                 <th>Subtotal</th>
                                 <th>Actions</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($items as $item)
                                 <tr>
                                     <td>
                                         <div class="shopping-cart__product-item">
                                             <img loading="lazy"
                                                 src="{{ asset('uploads/products/' . $item->model->image) }}" width="120"
                                                 height="120" alt="{{ $item->name }}" />
                                         </div>
                                     </td>
                                     <td>
                                         <div class="shopping-cart__product-item__detail">
                                             <h4>{{ $item->name }}</h4>
                                             {{-- <ul class="shopping-cart__product-item__options">
                                        <li>Color: Yellow</li>
                                        <li>Size: L</li>
                                    </ul> --}}
                                         </div>
                                     </td>
                                     <td>
                                         <span class="shopping-cart__product-price">${{ $item->price }}</span>
                                     </td>
                                     <td>
                                         {{ $item->qty }}
                                     </td>
                                     <td>
                                         <span class="shopping-cart__subtotal">${{ $item->subtotal() }}</span>
                                     </td>
                                     <td>
                                        <div class="d-flex align-items-center" style="gap: 0.3rem;">
                                            {{-- Move to Cart Button --}}
                                            <form method="POST" action="{{ route('wishlist.movetocart', $item->rowId) }}" class="me-1">
                                                @csrf
                                                <button class="btn btn-sm btn-warning d-flex align-items-center" type="submit">
                                                    <i class="fas fa-shopping-cart me-1"></i> Move to Cart
                                                </button>
                                            </form>
                                        
                                            {{-- Remove from Wishlist Button --}}
                                            <form method="POST" action="{{ route('wishlist.remove', $item->rowId) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center" title="Remove from Wishlist">
                                                    <svg width="12" height="12" viewBox="0 0 10 10" fill="#dc3545" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                        <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        
                                     </td>
                                 </tr>
                             @endforeach

                         </tbody>
                     </table>
                     <div class="cart-table-footer">
                        
                         <form action="{{route('wishlist.clear')}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-light">CLEAR WISHLIST</button>
                        </form>
                     </div>
                 </div>
                 @else
                    <div class="row">
                        <div class="col md-12 text-center pt-5 pb-5">
                            <p>No items Found in your wishlist</p>
                            <a class="btn btn-info" href="{{ route('shop.index') }}  ">Wishlist Now</a>
                        </div>
                    </div>
                @endif
             </div>
         </section>
     </main>
 @endsection
