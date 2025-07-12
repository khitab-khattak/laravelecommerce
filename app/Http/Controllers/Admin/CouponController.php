<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function list()
    {
        $coupons = Coupon::orderBy('expiry_date', 'DESC')->paginate(12);
        return view('admin.coupons.list', compact('coupons'));
    }

    public function add()
    {
        return view('admin.coupons.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'cart_value' => 'required|numeric|min:0',
            'expiry_date' => 'required|date|after:today',
        ]);

        Coupon::create($validated);

        return redirect()->route('coupons.list')->with('success', 'Coupon has been added successfully!');
    }
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }
    public function update($id,Request $request){
        $coupon = Coupon::find($id);
        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'cart_value' => 'required|numeric|min:0',
            'expiry_date' => 'required|date|after:today',
        ]);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route('coupons.list')->with('success','Coupon has been Updated Successfully!');

    }
    public function destroy($id){
        $coupons = Coupon::find($id);
        $coupons->delete();
        return redirect()->route('coupons.list')->with('success','Coupon has been Deleted Successfully!');

    }
}
