<?php

return [
    'name'     => env('APP_NAME', 'Patel Offset'),
    'tagline'  => 'Premium Offset & Digital Printing',
    'phone'    => env('SITE_PHONE', '+919876543210'),
    'whatsapp' => env('SITE_WHATSAPP', '919876543210'),
    'email'    => env('SITE_EMAIL', 'info@pateloffset.com'),
    'address'  => env('SITE_ADDRESS', 'Patel Offset, Main Road, Gujarat, INDIA'),
    'hours'    => env('SITE_HOURS', 'Mon - Sat : 9:30 AM - 8:00 PM'),
    'map'      => env('SITE_MAP_EMBED', 'https://maps.google.com/maps?q=Gujarat%20India&t=&z=7&ie=UTF8&iwloc=&output=embed'),

    'social' => [
        'facebook'  => env('SOCIAL_FACEBOOK', '#'),
        'instagram' => env('SOCIAL_INSTAGRAM', '#'),
        'youtube'   => env('SOCIAL_YOUTUBE', '#'),
        'linkedin'  => env('SOCIAL_LINKEDIN', '#'),
    ],

    // Order charges
    'free_shipping_above' => 999,
    'shipping_charge'     => 60,
    'gst_percent'         => 18,

    'razorpay' => [
        'key'    => env('RAZORPAY_KEY'),
        'secret' => env('RAZORPAY_SECRET'),
    ],

    'admin' => [
        'email'    => env('ADMIN_EMAIL', 'admin@pateloffset.com'),
        'password' => env('ADMIN_PASSWORD', 'admin@123'),
    ],
];
