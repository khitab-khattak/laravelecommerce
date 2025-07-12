@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Coupon</h3>

            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="#"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="#"><div class="text-tiny">Coupons</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Edit Coupon</div></li>
            </ul>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST" action="{{ route('coupons.update', $coupon->id) }}">
                @csrf
                @method('PUT')

                <fieldset class="name">
                    <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" name="code" placeholder="Coupon Code"
                        value="{{ old('code', $coupon->code) }}" required>
                </fieldset>

                <fieldset class="category">
                    <div class="body-title">Coupon Type</div>
                    <div class="select flex-grow">
                        <select name="type">
                            <option value="">Select</option>
                            <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>Percent</option>
                        </select>
                    </div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Value <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" name="value" placeholder="Coupon Value"
                        value="{{ old('value', $coupon->value) }}" required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Cart Value <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" name="cart_value" placeholder="Cart Value"
                        value="{{ old('cart_value', $coupon->cart_value) }}" required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Expiry Date <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="date" name="expiry_date" placeholder="Expiry Date"
                        value="{{ old('expiry_date', $coupon->expiry_date ? \Carbon\Carbon::parse($coupon->expiry_date)->format('Y-m-d') : '') }}" required>
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection