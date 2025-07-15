@extends('layouts.app')
@section('content')
    <style>
        .pt-90 {
            padding-top: 90px !important;
        }

        .pr-6px {
            padding-right: 6px;
            text-transform: uppercase;
        }

        .my-account .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 40px;
            border-bottom: 1px solid;
            padding-bottom: 13px;
        }

        .my-account .wg-box {
            display: flex;
            padding: 24px;
            flex-direction: column;
            gap: 24px;
            border-radius: 12px;
            background: var(--White);
            box-shadow: 0px 4px 24px 2px rgba(20, 25, 38, 0.05);
        }

        .bg-success {
            background-color: #40c710 !important;
        }

        .bg-danger {
            background-color: #f44032 !important;
        }

        .bg-warning {
            background-color: #f5d700 !important;
            color: #000;
        }

        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;
        }

        .table-transaction th,
        .table-transaction td {
            padding: 0.625rem 1.5rem .25rem !important;
            color: #000 !important;
        }

        .table> :not(caption)>tr>th {
            padding: 0.625rem 1.5rem .25rem !important;
            background-color: #6a6e51 !important;
        }

        .table-bordered>:not(caption)>*>* {
            border-width: inherit;
            line-height: 32px;
            font-size: 14px;
            border: 1px solid #e1e1e1;
            vertical-align: middle;
        }

        /* ✅ Improved image + name column formatting */
        .table-striped td:nth-child(1) {
            min-width: 250px;
            padding-bottom: 7px;
        }

        

        .table-bordered> :not(caption)>tr>th,
        .table-bordered> :not(caption)>tr>td {
            border-width: 1px 1px;
            border-color: #6a6e51;

            /* Container holding image + name */
.product-cell {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    overflow: hidden;
}

/* Image wrapper with fixed size */
.product-image {
    width: 50px;
    height: 50px;
    flex-shrink: 0;
    border-radius: 6px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Image itself fills the wrapper */
.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Name section that auto-truncates if too long */
.product-name {
    flex: 1;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

/* Optional: style anchor text */
.product-name a {
    font-weight: 500;
    color: #000;
    text-decoration: none;
    display: inline-block;
    max-width: 100%;
}


        }
    </style>

    <main class="pt-90" style="padding-top: 0px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Order Details</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account-nav')
                </div>

                <div class="col-lg-10">

                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 flex-wrap">
                            <div class="row">
                                <div class="col-6">
                                    <h5>Ordered Details</h5>
                                </div>
                                <div class="col-6 text-right"> <a class="btn btn-sm btn-danger"
                                        href="{{ route('users.orders') }}">Back</a></div>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <table class="table  table-bordered">
                                <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <td>{{ $order->id }}</td>
                                        <th>Mobile</th>
                                        <td>{{ $order->phone }}</td>
                                        <th>Zip Code</th>
                                        <td>{{ $order->zip }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Date</th>
                                        <td>{{ $order->created_at }}</td>
                                        <th>Delivered Date</th>
                                        <td>{{ $order->delivered_date }}</td>
                                        <th>Canceled Date</th>
                                        <td>{{ $order->canceled_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Status</th>
                                        <td colspan="5">
                                            @if ($order->status == 'delivered')
                                                <span class="badge bg-success">Delivered</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="badge bg-danger">Canceled</span>
                                            @else
                                                <span class="badge bg-warning">Ordered</span>
                                            @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="divider"></div>
                    </div>

                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 flex-wrap">
                            <div class="wg-filter flex-grow">
                                <h5>Ordered Details</h5>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="table-layout: fixed; width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="min-width: 250px; width: 250px;">Name</th>
                                        <th class="text-center" style="width: 100px;">Price</th>
                                        <th class="text-center" style="width: 90px;">Quantity</th>
                                        <th class="text-center" style="width: 120px;">SKU</th>
                                        <th class="text-center" style="width: 120px;">Category</th>
                                        <th class="text-center" style="width: 120px;">Brand</th>
                                        <th class="text-center" style="width: 100px;">Options</th>
                                        <th class="text-center" style="width: 120px;">Return Status</th>
                                        <th class="text-center" style="width: 80px;">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_items as $item)
                                    <tr>
                                        <td class="" style="min-width: 250px;">
                                            <div class="product-cell" style="width: 100%;">
                                                <div class="product-image">
                                                    <img src="{{ asset('uploads/products/' . $item->product->image) }}" alt="">
                                                </div>
                                                <div class="product-name">
                                                    <a href="{{ route('shop.product-details', $item->product->slug) }}" target="_blank">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        
                                    
                                        <td class="text-center" style="width: 100px;">${{ $item->price }}</td>
                                        <td class="text-center" style="width: 90px;">{{ $item->quantity }}</td>
                                        <td class="text-center" style="width: 120px;">{{ $item->product->SKU }}</td>
                                        <td class="text-center" style="width: 120px;">{{ $item->product->category->name }}</td>
                                        <td class="text-center" style="width: 120px;">{{ $item->product->brand->name }}</td>
                                        <td class="text-center" style="width: 100px;">{{ $item->options }}</td>
                                        <td class="text-center" style="width: 120px;">{{ $item->rstatus == 0 ? "No" : "Yes" }}</td>
                                        <td class="text-center" style="width: 80px;">
                                            <div class="list-icon-function view-icon">
                                                <div class="item eye">
                                                    <i class="icon-eye"></i>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                            {{ $order_items->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                    <div class="wg-box mt-5">
                        <h5>Shipping Address</h5>
                        <div class="my-account__address-item col-md-6">
                            <div class="my-account__address-item__detail">
                                <p>{{ $order->name }}</p>
                                <p>{{ $order->address }}</p>
                                <p>{{ $order->locality }}</p>
                                <p>{{ $order->city }}</p>
                                <p>{{ $order->landmark }}</p>
                                <p>{{ $order->zip }}</p>
                                <br>
                                <p>Mobile : {{ $order->phone }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="wg-box mt-5">
                        <h5>Transactions</h5>
                        <table class="table table-striped table-bordered table-transaction">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>${{ $order->subtotal }}</td>
                                    <th>Tax</th>
                                    <td>${{ $order->tax }}</td>
                                    <th>Discount</th>
                                    <td>${{ $order->discount }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>${{ $order->total }}</td>
                                    <th>Payment Mode</th>
                                    <td>{{ $transaction->mode }}</td>
                                    <th>Status</th>
                                    <td>
                                        @if ($transaction->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($transaction->status == 'declinded')
                                            <span class="badge bg-danger">Declinded</span>
                                        @elseif($transaction->status == 'refunded')
                                            <span class="badge bg-secondary">Refunded</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{$order->created_at}}</td>
                                    <th>Delivered Date</th>
                                    <td>{{$order->delivered_date}}</td>
                                    <th>Canceled Date</th>
                                    <td>{{$order->canceled}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection