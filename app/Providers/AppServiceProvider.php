<?php

namespace App\Providers;

use App\Models\Category;
use App\Support\Cart;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('layouts.app', function ($view) {
            $view->with('navCategories', Category::active()->with('activeProducts')->get());
            $view->with('cartCount', Cart::count());
        });

        View::composer('admin.layout', function ($view) {
            $newOrders = \App\Models\Order::whereIn('status', ['pending', 'confirmed'])->where('payment_status', 'paid')->latest()->take(5)->get();
            $newInquiries = \App\Models\Inquiry::where('is_read', false)->latest()->take(5)->get();
            $view->with('adminBadges', [
                'orders'    => \App\Models\Order::whereIn('status', ['pending', 'confirmed'])->where('payment_status', 'paid')->count(),
                'inquiries' => \App\Models\Inquiry::where('is_read', false)->count(),
            ]);
            $view->with('adminNotes', compact('newOrders', 'newInquiries'));
        });
    }
}
