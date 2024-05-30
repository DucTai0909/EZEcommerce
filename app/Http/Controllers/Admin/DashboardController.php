<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();

        $totalAllUsers = User::count();
        $totalUser = User::where('role_as', '0')->count();
        $totalAdmin = User::where('role_as', '1')->count();

        // $todayDate = Carbon::now()->format('d-m-Y');
        $todayDate = Carbon::now()->toDateString(); // Lấy ngày hiện tại dưới dạng 'Y-m-d'
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $totalOrder = Order::count();
        $todayOrder = Order::whereDate('created_at', $todayDate)->count();
        $thisMonthOrder = Order::whereMonth('created_at',$thisMonth)->count();
        $thisYearOrder = Order::whereYear('created_at',$thisYear)->count();

        return view('admin.dashboard', compact('totalProducts', 'totalCategories', 'totalBrands',
                                                'totalAllUsers', 'totalUser', 'totalAdmin',
                                                'totalOrder', 'todayOrder', 'thisMonthOrder', 'thisYearOrder'));
    }

    public function indexPhantomRead(){
        
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();


        $totalAllUsers = User::count();
        sleep(10);
        $totalUser = User::where('role_as', '0')->count();
        $totalAdmin = User::where('role_as', '1')->count();

        // $todayDate = Carbon::now()->format('d-m-Y');
        $todayDate = Carbon::now()->toDateString(); // Lấy ngày hiện tại dưới dạng 'Y-m-d'
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $totalOrder = Order::count();
        $todayOrder = Order::whereDate('created_at', $todayDate)->count();
        $thisMonthOrder = Order::whereMonth('created_at',$thisMonth)->count();
        $thisYearOrder = Order::whereYear('created_at',$thisYear)->count();
        return view('admin.dashboard', compact('totalProducts', 'totalCategories', 'totalBrands',
                                                'totalAllUsers', 'totalUser', 'totalAdmin',
                                                'totalOrder', 'todayOrder', 'thisMonthOrder', 'thisYearOrder'));
    }
}
