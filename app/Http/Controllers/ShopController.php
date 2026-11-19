<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private function baseQuery()
    {
        return Product::active()->with('category')->withAvg('reviews', 'rating')->withCount('reviews');
    }

    public function home()
    {
        $q = fn () => $this->baseQuery();

        return view('shop.home', [
            'categories'  => Category::active()->withCount('activeProducts')->get(),
            'newArrivals' => $q()->where('is_new', true)->latest()->take(10)->get(),
            'bestsellers' => $q()->where('is_bestseller', true)->orderByDesc('views')->take(10)->get(),
            'hot'         => $q()->where('is_hot', true)->take(10)->get(),
            'featured'    => $q()->where('is_featured', true)->take(8)->get(),
            'reviews'     => Review::with('product')->where('rating', 5)->latest()->take(3)->get(),
        ]);
    }

    public function index(Request $request, ?Category $category = null)
    {
        $products = $this->baseQuery()
            ->when($category, fn ($q) => $q->where('category_id', $category->id))
            ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('name', 'like', "%$s%")->orWhere('description', 'like', "%$s%")))
            ->when($request->filter === 'new', fn ($q) => $q->where('is_new', true))
            ->when($request->filter === 'bestseller', fn ($q) => $q->where('is_bestseller', true))
            ->when($request->filter === 'hot', fn ($q) => $q->where('is_hot', true))
            ->when($request->filter === 'featured', fn ($q) => $q->where('is_featured', true));

        $products = match ($request->sort) {
            'popular' => $products->orderByDesc('views'),
            'name'    => $products->orderBy('name'),
            'latest'  => $products->latest(),
            default   => $products->orderByDesc('is_featured')->orderByDesc('views'),
        };

        return view('shop.index', [
            'category'   => $category,
            'products'   => $products->paginate(12)->withQueryString(),
            'categories' => Category::active()->withCount('activeProducts')->get(),
        ]);
    }

    public function category(Request $request, Category $category)
    {
        abort_unless($category->is_active, 404);

        return $this->index($request, $category);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->increment('views');
        $product->load(['category', 'reviews']);

        $related = $this->baseQuery()->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)->inRandomOrder()->take(8)->get();
        if ($related->count() < 4) {
            $related = $related->merge($this->baseQuery()->whereKeyNot($product->id)->inRandomOrder()->take(8 - $related->count())->get());
        }

        return view('shop.product', compact('product', 'related'));
    }

    public function review(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:80',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
        $product->reviews()->create($data + ['is_approved' => true]);

        return back()->with('success', 'Thank you! Your review has been posted.');
    }
}
