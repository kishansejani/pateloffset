<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::withCount('products')->orderBy('sort')->get()]);
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => new Category(['color' => '#7c3aed', 'icon' => 'fa-solid fa-print', 'is_active' => true]), 'arts' => ProductController::ARTS]);
    }

    public function store(Request $request)
    {
        Category::create($this->validated($request));

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', ['category' => $category, 'arts' => ProductController::ARTS]);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validated($request, $category));

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function toggle(Request $request, Category $category)
    {
        $request->validate(['field' => ['required', Rule::in(['is_active'])]]);
        $category->update(['is_active' => $request->boolean('value')]);

        return response()->json(['ok' => true, 'message' => $category->name.' is now '.($category->is_active ? 'active' : 'hidden').'.']);
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Move or delete the products in this category first.');
        }
        $category->delete();

        return back()->with('success', 'Category deleted.');
    }

    private function validated(Request $request, ?Category $category = null): array
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'slug'        => ['nullable', 'string', 'max:120', Rule::unique('categories', 'slug')->ignore($category?->id)],
            'icon'        => 'required|string|max:60',
            'art'         => ['required', Rule::in(ProductController::ARTS)],
            'color'       => 'required|string|max:20',
            'tagline'     => 'nullable|string|max:150',
            'description' => 'nullable|string|max:1000',
            'sort'        => 'nullable|integer|min:0',
            'image'       => 'nullable|image|max:4096',
        ]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['sort'] = $data['sort'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        unset($data['image']);

        if ($request->hasFile('image')) {
            if ($category?->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        return $data;
    }
}
