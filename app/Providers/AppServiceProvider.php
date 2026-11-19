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
    }
}
