<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public const ARTS = ['card', 'flyer', 'brochure', 'banner', 'standee', 'letterhead', 'billbook', 'envelope', 'idcard', 'sticker', 'frame', 'invite', 'tag', 'box', 'bag'];

    public function index(Request $request)
    {
        $products = Product::with('category')->latest()->get();

        return view('admin.products.index', ['products' => $products, 'categories' => Category::orderBy('sort')->get()]);
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product(['color' => '#7c3aed', 'is_active' => true, 'dispatch_time' => '3-4 Days', 'design_fee' => 149]), 'categories' => Category::orderBy('sort')->get(), 'arts' => self::ARTS]);
    }

    public function store(Request $request)
    {
        Product::create($this->validated($request));

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', ['product' => $product, 'categories' => Category::orderBy('sort')->get(), 'arts' => self::ARTS]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request, $product));

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function toggle(Request $request, Product $product)
    {
        $field = $request->validate(['field' => ['required', Rule::in(['is_active', 'is_featured', 'is_new', 'is_bestseller', 'is_hot'])]])['field'];
        $product->update([$field => $request->boolean('value')]);

        return response()->json(['ok' => true, 'message' => $product->name.' updated.']);
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'name'              => 'required|string|max:150',
            'slug'              => ['nullable', 'string', 'max:160', Rule::unique('products', 'slug')->ignore($product?->id)],
            'short_description' => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'specifications'    => 'nullable|string',
            'art'               => ['required', Rule::in(self::ARTS)],
            'color'             => 'required|string|max:20',
            'image'             => 'nullable|image|max:4096',
            'tiers_text'        => 'required|string',
            'options_text'      => 'nullable|string',
            'mrp_per_unit'      => 'nullable|numeric|min:0',
            'design_fee'        => 'nullable|numeric|min:0',
            'dispatch_time'     => 'required|string|max:50',
        ]);

        // "500 = 1500" per line
        $tiers = [];
        foreach (preg_split('/\r?\n/', trim($data['tiers_text'])) as $line) {
            if (! preg_match('/^\s*(\d+)\s*[=:]\s*([\d.]+)\s*$/', $line, $m)) {
                throw ValidationException::withMessages(['tiers_text' => "Invalid tier line: \"$line\". Use: quantity = price"]);
            }
            $tiers[] = ['qty' => (int) $m[1], 'price' => (float) $m[2]];
        }

        // "Printing Side: Single Side=0, Both Side=0.5" per line
        $options = [];
        foreach (array_filter(preg_split('/\r?\n/', trim((string) $data['options_text']))) as $line) {
            [$name, $vals] = array_pad(explode(':', $line, 2), 2, '');
            $values = [];
            foreach (array_filter(array_map('trim', explode(',', $vals))) as $v) {
                [$label, $add] = array_pad(explode('=', $v, 2), 2, 0);
                $values[] = ['label' => trim($label), 'add' => (float) $add];
            }
            if (trim($name) && $values) {
                $options[] = ['name' => trim($name), 'values' => $values];
            }
        }

        $out = collect($data)->except(['tiers_text', 'options_text', 'image'])->all();
        $out['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $out['price_tiers'] = $tiers;
        $out['options'] = $options ?: null;
        $out['design_fee'] = $data['design_fee'] ?? 0;
        foreach (['is_new', 'is_bestseller', 'is_hot', 'is_featured', 'is_active'] as $flag) {
            $out[$flag] = $request->boolean($flag);
        }

        if ($request->hasFile('image')) {
            if ($product?->image) {
                Storage::disk('public')->delete($product->image);
            }
            $out['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->boolean('remove_image') && $product?->image) {
            Storage::disk('public')->delete($product->image);
            $out['image'] = null;
        }

        return $out;
    }
}
