<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Brand;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin/index');
    }
    public function logout()
    {
        Auth::logout();

        return redirect('/login')->with('success', 'You have been logged out.');
    }

   

    
}
