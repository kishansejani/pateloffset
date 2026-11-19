<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    public function index()
    {
        return view('checkout.cart', ['items' => Cart::items(), 'totals' => Cart::totals()]);
    }

    public function add(Request $request, Product $product)
    {
        $qtys = array_column($product->tiers(), 'qty');

        $rules = [
            'quantity'    => ['required', 'integer', Rule::in($qtys)],
            'design_type' => ['required', 'in:upload,design_with_us'],
            'design_file' => ['nullable', 'file', 'max:20480', 'mimes:pdf,jpg,jpeg,png,cdr,ai,psd,zip,eps'],
        ];
        foreach ($product->options ?? [] as $opt) {
            $rules['options.'.$opt['name']] = ['required', Rule::in(array_column($opt['values'], 'label'))];
        }
        $data = $request->validate($rules, [], ['design_file' => 'design file']);

        $options = [];
        foreach ($product->options ?? [] as $opt) {
            $options[$opt['name']] = $data['options'][$opt['name']];
        }

        $price = $product->priceFor((int) $data['quantity'], $options);
        abort_if($price === null, 422);

        $file = $request->file('design_file')?->store('designs', 'public');

        Cart::add([
            'product_id'    => $product->id,
            'name'          => $product->name,
            'slug'          => $product->slug,
            'art'           => $product->art,
            'color'         => $product->color,
            'image'         => $product->image,
            'category'      => $product->category->name,
            'quantity'      => (int) $data['quantity'],
            'options'       => $options,
            'price'         => $price,
            'design_type'   => $data['design_type'],
            'design_charge' => $data['design_type'] === 'design_with_us' ? (float) $product->design_fee : 0,
            'design_file'   => $file,
        ]);

        session()->flash('cart_bumped', true);

        if ($request->input('buy_now')) {
            return redirect()->route('checkout');
        }

        return redirect()->route('cart')->with('success', $product->name.' added to your cart.');
    }

    public function remove(string $key)
    {
        Cart::remove($key);

        return back()->with('success', 'Item removed from cart.');
    }
}
