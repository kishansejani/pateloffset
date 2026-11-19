<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => config('site.admin.email')],
            ['name' => 'Admin', 'password' => Hash::make(config('site.admin.password')), 'is_admin' => true]
        );

        $categories = [
            ['Visiting Cards', 'fa-solid fa-address-card', 'card', '#7c3aed', 'Make a bold first impression', 'Premium business cards in gloss, matt, velvet, texture, metal & PVC finishes.'],
            ['Marketing Materials', 'fa-solid fa-bullhorn', 'flyer', '#ec4899', 'Flyers, brochures & pamphlets', 'Eye-catching flyers, brochures and pamphlets that bring customers to your door.'],
            ['Flex & Banners', 'fa-solid fa-flag', 'banner', '#f97316', 'Big prints, bigger impact', 'Solvent & eco-solvent flex, vinyl, backlit and roll-up banners in every size.'],
            ['Stationery', 'fa-solid fa-file-lines', 'letterhead', '#0ea5e9', 'Letterheads, envelopes & bill books', 'Professional office stationery that carries your brand on every page.'],
            ['Stickers & Labels', 'fa-solid fa-note-sticky', 'sticker', '#22c55e', 'Stick your brand everywhere', 'Die-cut, round, vinyl, transparent and product labels in any shape.'],
            ['Display & Signage', 'fa-solid fa-display', 'standee', '#eab308', 'Standees, frames & LED signs', 'Roll-up standees, acrylic frames, LED menu books and table-top displays.'],
            ['Wedding & Invitations', 'fa-solid fa-heart', 'invite', '#e11d48', 'Celebrate in style', 'Elegant wedding cards, invitations and greeting cards with foil and laser cut.'],
        ];

        $cat = [];
        foreach ($categories as $i => [$name, $icon, $art, $color, $tagline, $desc]) {
            $cat[$art] = Category::updateOrCreate(['slug' => Str::slug($name)], [
                'name' => $name, 'icon' => $icon, 'art' => $art, 'color' => $color,
                'tagline' => $tagline, 'description' => $desc, 'sort' => $i,
            ]);
        }

        $sides = fn ($a = 0, $b = 0.5) => [['name' => 'Printing Side', 'values' => [['label' => 'Single Side', 'add' => $a], ['label' => 'Both Side', 'add' => $b]]]];
        $lam   = [['name' => 'Lamination', 'values' => [['label' => 'Gloss', 'add' => 0], ['label' => 'Matt', 'add' => 0], ['label' => 'Velvet', 'add' => 0.5]]]];

        // [category art, name, product art, color, tiers, mrp/unit, flags, options, dispatch, features]
        $products = [
            ['card', 'Velvet UV Visiting Card', 'card', '#7f1d1d', [[500, 1500], [1000, 2500]], 4, ['featured', 'hot'], $sides(0, 1), '6-7 Days', "350 GSM Matt Art Paper\nVelvet lamination with spot UV\nRich soft-touch feel\nPremium quality cutting"],
            ['card', 'Gold Foil Premium Visiting Card', 'card', '#1c1917', [[250, 1800], [500, 2900], [1000, 4800]], 9, ['featured', 'new'], $sides(0, 2), '7-8 Days', "800 GSM thick board\nReal gold foil stamping\nDie-cut shapes available\nLuxury finish"],
            ['card', 'Matt Lamination Visiting Card', 'card', '#1e3a8a', [[500, 650], [1000, 990], [2000, 1800]], 2, ['bestseller'], $sides(0, 0.4), '3-4 Days', "350 GSM Art Card\nMatt lamination both side\nStandard size 90 x 53 mm\nFast delivery"],
            ['card', 'Gloss UV Coated Visiting Card', 'card', '#0f766e', [[1000, 450], [2000, 850], [5000, 2000]], 1, ['bestseller', 'hot'], $sides(0, 0.2), '2-3 Days', "300 GSM Art Card\nHigh gloss UV coating\nVibrant colours\nMost affordable"],
            ['card', 'Metal Visiting Card - Gold', 'card', '#a16207', [[50, 3500], [100, 6000]], 90, ['new'], null, '8-10 Days', "Stainless steel metal card\nLaser engraved text\nGold colour finish\nLifetime durability"],
            ['card', 'Non-Tearable PVC Visiting Card', 'card', '#4338ca', [[500, 1100], [1000, 1900]], 3, [], $sides(0, 0.6), '4-5 Days', "Waterproof synthetic sheet\nNon tearable\nGlossy lamination\nLong lasting"],
            ['card', 'Texture 350 GSM Visiting Card', 'card', '#be185d', [[500, 900], [1000, 1500]], null, ['featured'], $sides(), '4-5 Days', "Textured premium sheet\nElegant feel\nGloss coated\nCorporate look"],
            ['flyer', 'A5 Flyer - 130 GSM', 'flyer', '#db2777', [[1000, 1800], [2000, 3200], [5000, 7000]], 3, ['bestseller', 'featured'], $sides(0, 0.7), '3-4 Days', "Size 5.8 x 8.3 inch (A5)\n130 GSM Art Paper\nFull colour printing\nPerfect for promotions"],
            ['flyer', 'A4 Flyer - 90 GSM', 'flyer', '#9333ea', [[1000, 2400], [3000, 6300], [5000, 9500]], null, ['hot'], $sides(0, 0.8), '3-4 Days', "Size 8.3 x 11.7 inch (A4)\n90 GSM Maplitho\nBudget friendly\nBulk distribution"],
            ['flyer', 'Tri-Fold Brochure', 'brochure', '#c026d3', [[500, 4500], [1000, 7500]], 12, ['new'], $lam, '5-6 Days', "A4 open size, 3 panels\n170 GSM Art Paper\nCrease & fold included\nCorporate presentations"],
            ['flyer', 'Pamphlet - Single Colour', 'flyer', '#475569', [[2000, 1600], [5000, 3500]], null, [], null, '2-3 Days', "Single colour printing\n70 GSM Paper\nEconomical\nNewspaper inserts"],
            ['banner', 'Star Flex Banner (per sq.ft)', 'banner', '#ea580c', [[10, 180], [50, 800], [100, 1500]], 22, ['bestseller', 'hot'], [['name' => 'Eyelets', 'values' => [['label' => 'Without Eyelets', 'add' => 0], ['label' => 'With Eyelets', 'add' => 2]]]], '1-2 Days', "Star flex material\nSolvent printing\nOutdoor weather resistant\nPrice per square foot"],
            ['banner', 'Backlit Flex (per sq.ft)', 'banner', '#0284c7', [[10, 450], [50, 2100]], 60, ['new'], null, '2-3 Days', "Backlit flex material\nGlow sign boards\nEco-solvent print\nRich colours"],
            ['banner', 'Roll-Up Standee - Aluminium', 'standee', '#f59e0b', [[1, 1600], [2, 3000], [5, 7000]], 3200, ['featured', 'hot'], null, '2-3 Days', "Size 2.5 x 6 feet\nAluminium stand with bag\nPrinted star flex\nEasy to carry"],
            ['banner', 'Vinyl Sticker Print (per sq.ft)', 'banner', '#16a34a', [[10, 400], [50, 1800]], 80, [], null, '1-2 Days', "Solvent vinyl\nGlossy or matt\nWall & glass application\nPrice per square foot"],
            ['letterhead', 'Letterhead - 100 GSM', 'letterhead', '#0369a1', [[500, 1800], [1000, 2900]], 5, ['bestseller', 'featured'], null, '4-5 Days', "A4 size\n100 GSM Bond / Maplitho\nFull colour printing\nProfessional look"],
            ['letterhead', 'Envelope 9 x 4 - 70 GSM', 'envelope', '#0891b2', [[500, 1500], [1000, 2500]], null, ['hot'], null, '4-5 Days', "9 x 4 inch envelope\n70 GSM paper\nCompany branding\nOffice use"],
            ['letterhead', 'Bill Book (Duplicate)', 'billbook', '#1d4ed8', [[5, 1100], [10, 2000], [20, 3600]], 300, ['bestseller'], [['name' => 'Copies', 'values' => [['label' => 'Duplicate', 'add' => 0], ['label' => 'Triplicate', 'add' => 60]]]], '3-4 Days', "50 sets per book\nCarbonless NCR paper\nSerial numbering\nA5 size"],
            ['letterhead', 'ID Card with Lanyard', 'idcard', '#2563eb', [[10, 900], [50, 3800]], 120, ['new'], null, '3-4 Days', "PVC ID card\nBoth side printing\nPrinted lanyard & holder\nSchools & offices"],
            ['sticker', 'Round Sticker - PVC', 'sticker', '#16a34a', [[500, 700], [1000, 1200]], 2, ['hot'], null, '3-4 Days', "PVC non tearable\nRound die-cut\nGloss finish\nProduct labelling"],
            ['sticker', 'Transparent Label Sticker', 'sticker', '#059669', [[500, 1100], [1000, 1900]], null, ['new'], null, '4-5 Days', "Transparent vinyl\nKiss cut\nWaterproof\nBottles & jars"],
            ['sticker', 'Custom Car Stickers', 'sticker', '#dc2626', [[2, 600], [5, 1400]], 450, ['featured'], null, '2-3 Days', "Car body vinyl\nUV resistant\nAny shape\nEasy to apply"],
            ['standee', 'Acrylic Display Frame A4', 'frame', '#ca8a04', [[1, 450], [5, 2000]], 700, ['new', 'featured'], null, '3-4 Days', "Clear acrylic frame\nA4 297 x 210 mm\nTable top / wall\nUV print available"],
            ['standee', 'LED Menu Book A4', 'frame', '#7c2d12', [[1, 2500], [2, 4700]], 3000, ['new'], null, '6-7 Days', "LED backlit menu\nA4 size 2 pages\nRechargeable\nRestaurants & cafes"],
            ['standee', 'Table Top Card Stand A5', 'frame', '#b45309', [[1, 220], [10, 1900]], 350, ['hot'], null, '2-3 Days', "Acrylic L-shape stand\nA5 148 x 210 mm\nReception counters\nInsert print included"],
            ['invite', 'Royal Wedding Card', 'invite', '#9f1239', [[100, 4500], [300, 12000], [500, 18500]], 60, ['featured', 'bestseller'], null, '8-10 Days', "Premium hard card\nGold foil + embossing\nWith envelope\nCustom design included"],
            ['invite', 'Laser Cut Invitation', 'invite', '#be123c', [[100, 5500], [300, 15000]], 70, ['new'], null, '10-12 Days', "Intricate laser cut\nShimmer sheet\nRibbon finishing\nLuxury feel"],
            ['invite', 'Greeting & Diwali Card', 'invite', '#c2410c', [[100, 2200], [500, 9000]], null, ['hot'], null, '5-6 Days', "Festive designs\n300 GSM card\nFoil highlights\nCorporate gifting"],
        ];

        $spec = "Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI";

        foreach ($products as [$catArt, $name, $art, $color, $tiers, $mrp, $flags, $options, $dispatch, $features]) {
            $p = Product::updateOrCreate(['slug' => Str::slug($name)], [
                'category_id'       => $cat[$catArt]->id,
                'name'              => $name,
                'short_description' => strtok($features, "\n").' • '.explode("\n", $features)[1],
                'description'       => $features,
                'specifications'    => $spec,
                'art'               => $art,
                'color'             => $color,
                'price_tiers'       => array_map(fn ($t) => ['qty' => $t[0], 'price' => $t[1]], $tiers),
                'options'           => $options,
                'mrp_per_unit'      => $mrp,
                'design_fee'        => in_array($catArt, ['banner', 'invite']) ? 0 : 149,
                'dispatch_time'     => $dispatch,
                'is_new'            => in_array('new', $flags),
                'is_bestseller'     => in_array('bestseller', $flags),
                'is_hot'            => in_array('hot', $flags),
                'is_featured'       => in_array('featured', $flags),
                'views'             => random_int(40, 650),
            ]);

            if ($p->reviews()->count() === 0) {
                foreach (array_slice($this->reviews(), random_int(0, 4), random_int(1, 3)) as [$n, $r, $c]) {
                    Review::create(['product_id' => $p->id, 'name' => $n, 'rating' => $r, 'comment' => $c]);
                }
            }
        }
    }

    private function reviews(): array
    {
        return [
            ['Rahul Mehta', 5, 'Excellent print quality and colours came out exactly like the design. Delivered on time!'],
            ['Priya Shah', 5, 'Very professional team, they even helped fix my design for free. Highly recommended.'],
            ['Kiran Desai', 4, 'Good quality and fair pricing. Packaging was neat and safe.'],
            ['Amit Patel', 5, 'Ordered for my shop, customers loved the finish. Will order again.'],
            ['Neha Joshi', 5, 'Fast delivery and the finishing is premium. Value for money.'],
            ['Vishal Rathod', 4, 'Nice work, WhatsApp support was quick to respond.'],
            ['Sneha Trivedi', 5, 'Best printing service in town. Smooth online payment too.'],
        ];
    }
}
