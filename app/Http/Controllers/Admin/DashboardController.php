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
            'orders'    => Order::withCount('items')->latest()->take(10)->get(),
            'chart'     => collect(range(13, 0))->map(function ($d) {
                $day = now()->subDays($d);
                $q = Order::whereDate('created_at', $day->toDateString());

                return ['label' => $day->format('d M'), 'short' => $day->format('d'), 'orders' => (clone $q)->count(), 'revenue' => (float) (clone $q)->where('payment_status', 'paid')->sum('total')];
            }),
            'statusMix' => Order::selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status'),
            'topProducts' => \App\Models\Product::orderByDesc('views')->take(5)->get(),
            'inquiries' => Inquiry::latest()->take(6)->get(),
        ]);
    }
}
