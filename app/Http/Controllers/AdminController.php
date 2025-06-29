<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Brand;

class AdminController extends Controller
{
    public function index(){
        return view('admin/index');
    }
    public function logout()
    {
        Auth::logout();
    
        return redirect('/login')->with('success', 'You have been logged out.');
    }

    public function brands(){
        $brands = Brand::orderBy('id','DESC')->paginate(10);
        return view('admin/brands',compact('brands'));
    }
}
