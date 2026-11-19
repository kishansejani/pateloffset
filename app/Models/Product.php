<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'short_description', 'description', 'specifications',
        'art', 'color', 'image', 'price_tiers', 'options', 'mrp_per_unit', 'design_fee',
        'dispatch_time', 'is_new', 'is_bestseller', 'is_hot', 'is_featured', 'is_active', 'views',
    ];

    protected $casts = [
        'price_tiers'   => 'array',
        'options'       => 'array',
        'is_new'        => 'boolean',
        'is_bestseller' => 'boolean',
        'is_hot'        => 'boolean',
        'is_featured'   => 'boolean',
        'is_active'     => 'boolean',
        'mrp_per_unit'  => 'float',
        'design_fee'    => 'float',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true)->latest();
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    /** Tiers sorted by quantity. */
    public function tiers(): array
    {
        $tiers = collect($this->price_tiers ?? [])
            ->map(fn ($t) => ['qty' => (int) $t['qty'], 'price' => (float) $t['price']])
            ->sortBy('qty')->values()->all();

        return $tiers ?: [['qty' => 1, 'price' => 0]];
    }

    public function startingPrice(): float
    {
        return $this->tiers()[0]['price'];
    }

    public function startingQty(): int
    {
        return $this->tiers()[0]['qty'];
    }

    /** MRP for the lowest tier (for strike-through + % OFF). */
    public function startingMrp(): ?float
    {
        if (! $this->mrp_per_unit) {
            return null;
        }
        $mrp = $this->mrp_per_unit * $this->startingQty();

        return $mrp > $this->startingPrice() ? $mrp : null;
    }

    public function discountPercent(): ?int
    {
        $mrp = $this->startingMrp();

        return $mrp ? (int) round((1 - $this->startingPrice() / $mrp) * 100) : null;
    }

    /**
     * Calculate the price for a quantity + selected option labels.
     * Option "add" values are extra rupees per unit.
     */
    public function priceFor(int $qty, array $selected = []): ?float
    {
        $tier = collect($this->tiers())->firstWhere('qty', $qty);
        if (! $tier) {
            return null;
        }
        $extraPerUnit = 0;
        foreach ($this->options ?? [] as $opt) {
            $chosen = $selected[$opt['name']] ?? null;
            foreach ($opt['values'] as $v) {
                if ($v['label'] === $chosen) {
                    $extraPerUnit += (float) ($v['add'] ?? 0);
                }
            }
        }

        return round($tier['price'] + $extraPerUnit * $qty, 2);
    }

    public function featureLines(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string) $this->description))));
    }

    public function specLines(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string) $this->specifications))));
    }

    public function rating(): float
    {
        return round((float) $this->reviews()->avg('rating'), 1);
    }

    public function badge(): ?string
    {
        return match (true) {
            $this->discountPercent() !== null => $this->discountPercent().'% OFF',
            $this->is_new        => 'New',
            $this->is_bestseller => 'Bestseller',
            $this->is_hot        => 'Hot',
            default              => null,
        };
    }
}
