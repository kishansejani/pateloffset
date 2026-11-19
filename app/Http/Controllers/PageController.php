<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function quote(Request $request)
    {
        return view('pages.quote', [
            'products' => Product::active()->orderBy('name')->pluck('name'),
            'selected' => $request->product,
        ]);
    }

    public function inquiry(Request $request)
    {
        $data = $request->validate([
            'type'       => 'required|in:contact,quote,product',
            'name'       => 'required|string|max:100',
            'phone'      => ['required', 'regex:/^[0-9+\s-]{10,15}$/'],
            'email'      => 'nullable|email|max:150',
            'product'    => 'nullable|string|max:150',
            'quantity'   => 'nullable|string|max:50',
            'message'    => 'nullable|string|max:2000',
            'attachment' => 'nullable|file|max:20480|mimes:pdf,jpg,jpeg,png,cdr,ai,psd,zip',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('inquiries', 'public');
        }
        Inquiry::create($data);

        return back()->with('success', 'Thank you '.$data['name'].'! Our team will contact you shortly.');
    }

    public function subscribe(Request $request)
    {
        $data = $request->validate(['email' => 'required|email|max:150']);
        Subscriber::firstOrCreate($data);

        return back()->with('success', 'Subscribed! You will receive our latest offers.');
    }

    public function track(Request $request)
    {
        $order = null;
        if ($request->filled(['order_number', 'phone'])) {
            $order = Order::with('items')
                ->where('order_number', trim($request->order_number))
                ->where('phone', trim($request->phone))
                ->first();
            if (! $order) {
                session()->now('error', 'No order found with these details.');
            }
        }

        return view('pages.track', compact('order'));
    }

    public function policy(string $page)
    {
        $pages = [
            'privacy'      => 'Privacy Policy',
            'terms'        => 'Terms & Conditions',
            'shipping'     => 'Shipping & Delivery',
            'returns'      => 'Returns & Exchanges',
            'cancellation' => 'Cancellation Policy',
        ];
        abort_unless(isset($pages[$page]), 404);

        return view('pages.policy', ['page' => $page, 'title' => $pages[$page]]);
    }
}
