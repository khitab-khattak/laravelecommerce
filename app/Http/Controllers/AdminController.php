<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->limit(10)->get();
    
        $dashboardDatas = DB::select("
            SELECT 
                SUM(total) AS TotalAmount,
                SUM(CASE WHEN status = 'ordered' THEN total ELSE 0 END) AS TotalOrderedAmount,
                SUM(CASE WHEN status = 'delivered' THEN total ELSE 0 END) AS TotalDeliveredAmount,
                SUM(CASE WHEN status = 'canceled' THEN total ELSE 0 END) AS TotalCanceledAmount,
                COUNT(*) AS Total,
                SUM(CASE WHEN status = 'ordered' THEN 1 ELSE 0 END) AS TotalOrdered,
                SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) AS TotalDelivered,
                SUM(CASE WHEN status = 'canceled' THEN 1 ELSE 0 END) AS TotalCanceled
            FROM orders
        ");
    
        $monthlyDatas = DB::select("
            SELECT 
                M.id AS MonthNo, 
                M.name AS MonthName, 
                IFNULL(D.TotalAmount, 0) AS TotalAmount, 
                IFNULL(D.TotalOrderedAmount, 0) AS TotalOrderedAmount, 
                IFNULL(D.TotalDeliveredAmount, 0) AS TotalDeliveredAmount, 
                IFNULL(D.TotalCanceledAmount, 0) AS TotalCanceledAmount
            FROM month_names M
            LEFT JOIN (
                SELECT 
                    STRFTIME('%m', created_at) AS MonthNo,
                    SUM(total) AS TotalAmount,
                    SUM(CASE WHEN status = 'ordered' THEN total ELSE 0 END) AS TotalOrderedAmount,
                    SUM(CASE WHEN status = 'delivered' THEN total ELSE 0 END) AS TotalDeliveredAmount,
                    SUM(CASE WHEN status = 'canceled' THEN total ELSE 0 END) AS TotalCanceledAmount
                FROM orders
                WHERE STRFTIME('%Y', created_at) = STRFTIME('%Y', 'now')
                GROUP BY STRFTIME('%m', created_at)
            ) D ON D.MonthNo = printf('%02d', M.id)
            ORDER BY M.id
        ");
    
        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $OrderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $DeliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $CanceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());
    
        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');
    
        $MonthLabels = "'" . implode("','", collect($monthlyDatas)->pluck('MonthName')->toArray()) . "'";
    
        return view('admin.index', compact(
            'orders', 'dashboardDatas',
            'AmountM', 'OrderedAmountM', 'DeliveredAmountM', 'CanceledAmountM',
            'TotalAmount', 'TotalOrderedAmount', 'TotalDeliveredAmount', 'TotalCanceledAmount',
            'MonthLabels'
        ));
    }
    
    public function logout()
    {
        Auth::logout();

        return redirect('/login')->with('success', 'You have been logged out.');
    }

   

    
}
