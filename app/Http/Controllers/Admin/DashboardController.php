<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'revenue'   => Order::where('payment_status', 'paid')->sum('total'),
                'orders'    => Order::count(),
                'paid'      => Order::where('payment_status', 'paid')->count(),
                'pending'   => Order::whereNotIn('status', ['delivered', 'cancelled'])->where('payment_status', 'paid')->count(),
                'inquiries' => Inquiry::where('is_read', false)->count(),
                'products'  => Product::count(),
            ],
            'orders'    => Order::latest()->take(8)->get(),
            'inquiries' => Inquiry::latest()->take(6)->get(),
        ]);
    }
}
