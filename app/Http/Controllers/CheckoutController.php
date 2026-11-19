<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class CheckoutController extends Controller
{
    private function razorpay(): ?Api
    {
        $key = config('site.razorpay.key');
        $secret = config('site.razorpay.secret');

        return $key && $secret ? new Api($key, $secret) : null;
    }

    public function index()
    {
        if (! Cart::count()) {
            return redirect()->route('shop')->with('error', 'Your cart is empty. Add a product first.');
        }

        return view('checkout.checkout', ['items' => Cart::items(), 'totals' => Cart::totals()]);
    }

    /** Save the order and create a Razorpay order, then show the payment page. */
    public function store(Request $request)
    {
        if (! Cart::count()) {
            return redirect()->route('shop');
        }

        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|max:150',
            'phone'      => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'company'    => 'nullable|string|max:150',
            'gst_number' => 'nullable|string|max:20',
            'address'    => 'required|string|max:500',
            'city'       => 'required|string|max:80',
            'state'      => 'required|string|max:80',
            'pincode'    => 'required|digits:6',
            'notes'      => 'nullable|string|max:1000',
        ], ['phone.regex' => 'Enter a valid 10 digit mobile number.']);

        $totals = Cart::totals();

        $order = DB::transaction(function () use ($data, $totals) {
            $order = Order::create($data + [
                'order_number'   => Order::generateNumber(),
                'subtotal'       => $totals['subtotal'],
                'design_charges' => $totals['design'],
                'shipping'       => $totals['shipping'],
                'gst'            => $totals['gst'],
                'total'          => $totals['total'],
            ]);
            foreach (Cart::items() as $line) {
                $order->items()->create([
                    'product_id'    => $line['product_id'],
                    'product_name'  => $line['name'],
                    'options'       => $line['options'],
                    'quantity'      => $line['quantity'],
                    'price'         => $line['price'],
                    'design_charge' => $line['design_charge'],
                    'design_type'   => $line['design_type'],
                    'design_file'   => $line['design_file'],
                ]);
            }

            return $order;
        });

        // Customer may view/pay only orders created in their session
        session()->push('my_orders', $order->order_number);
        Cart::clear();

        return redirect()->route('payment', $order->order_number);
    }

    public function payment(string $number)
    {
        $order = $this->ownedOrder($number);
        if ($order->payment_status === 'paid') {
            return redirect()->route('order.success', $number);
        }

        $api = $this->razorpay();
        if ($api && ! $order->razorpay_order_id) {
            try {
                $rzp = $api->order->create([
                    'receipt'  => $order->order_number,
                    'amount'   => (int) round($order->total * 100), // paise
                    'currency' => 'INR',
                    'notes'    => ['order_number' => $order->order_number],
                ]);
                $order->update(['razorpay_order_id' => $rzp['id']]);
            } catch (\Throwable $e) {
                Log::error('Razorpay order create failed: '.$e->getMessage());

                return view('checkout.payment', ['order' => $order->load('items'), 'gatewayError' => config('app.debug') ? 'Payment gateway error: '.$e->getMessage() : 'Online payment is temporarily unavailable.']);
            }
        }

        return view('checkout.payment', ['order' => $order->load('items'), 'gatewayError' => $api ? null : (config('app.debug')
            ? 'Razorpay keys are not configured yet. Add RAZORPAY_KEY and RAZORPAY_SECRET in the .env file.'
            : 'Online payment is temporarily unavailable.')]);
    }

    /** Razorpay checkout handler posts here after a successful payment. */
    public function verify(Request $request)
    {
        $data = $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id'   => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);

        $order = Order::where('razorpay_order_id', $data['razorpay_order_id'])->firstOrFail();
        $api = $this->razorpay();
        abort_unless($api, 500);

        try {
            $api->utility->verifyPaymentSignature($data);
        } catch (SignatureVerificationError $e) {
            $order->update(['payment_status' => 'failed']);

            return redirect()->route('payment', $order->order_number)->with('error', 'Payment verification failed. Please try again.');
        }

        $order->update([
            'razorpay_payment_id' => $data['razorpay_payment_id'],
            'razorpay_signature'  => $data['razorpay_signature'],
            'payment_status'      => 'paid',
            'status'              => 'confirmed',
            'paid_at'             => now(),
        ]);

        return redirect()->route('order.success', $order->order_number);
    }

    public function failed(Request $request, string $number)
    {
        $order = $this->ownedOrder($number);
        if ($order->payment_status !== 'paid') {
            $order->update(['payment_status' => 'failed']);
        }

        return redirect()->route('payment', $number)->with('error', 'Payment was not completed. You can retry below.');
    }

    public function success(string $number)
    {
        return view('checkout.success', ['order' => $this->ownedOrder($number)->load('items')]);
    }

    private function ownedOrder(string $number): Order
    {
        abort_unless(in_array($number, session('my_orders', []), true), 403, 'This order does not belong to your session. Use Track Order instead.');

        return Order::where('order_number', $number)->firstOrFail();
    }
}
