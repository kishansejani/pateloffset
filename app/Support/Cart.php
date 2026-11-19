<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Session cart. Each line:
 * [product_id, name, slug, art, color, image, category, quantity, options, price, design_type, design_charge, design_file]
 */
class Cart
{
    private const KEY = 'cart';

    public static function items(): array
    {
        return session(self::KEY, []);
    }

    public static function add(array $line): string
    {
        $items = self::items();
        $key = uniqid('ci');
        $items[$key] = $line;
        session([self::KEY => $items]);

        return $key;
    }

    public static function remove(string $key): void
    {
        $items = self::items();
        if (! empty($items[$key]['design_file'])) {
            Storage::disk('public')->delete($items[$key]['design_file']);
        }
        unset($items[$key]);
        session([self::KEY => $items]);
    }

    public static function clear(): void
    {
        session()->forget(self::KEY);
    }

    public static function count(): int
    {
        return count(self::items());
    }

    public static function totals(): array
    {
        $items = self::items();
        $subtotal = array_sum(array_column($items, 'price'));
        $design = array_sum(array_column($items, 'design_charge'));
        $base = $subtotal + $design;
        $shipping = $items && $base < config('site.free_shipping_above') ? (float) config('site.shipping_charge') : 0;
        $gst = round($base * config('site.gst_percent') / 100, 2);

        return [
            'subtotal' => round($subtotal, 2),
            'design'   => round($design, 2),
            'shipping' => $shipping,
            'gst'      => $gst,
            'total'    => round($base + $shipping + $gst, 2),
        ];
    }
}
