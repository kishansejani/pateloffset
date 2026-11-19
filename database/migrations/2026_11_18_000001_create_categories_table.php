<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->default('fa-solid fa-print');
            $table->string('art')->default('card');
            $table->string('color', 20)->default('#6d28d9');
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();       // one feature per line
            $table->text('specifications')->nullable();    // one spec per line
            $table->string('art')->default('card');         // SVG mockup style
            $table->string('color', 20)->default('#6d28d9');
            $table->string('image')->nullable();
            $table->json('price_tiers');                    // [{qty, price}]
            $table->json('options')->nullable();            // [{name, values:[{label, add}]}]
            $table->decimal('mrp_per_unit', 10, 2)->nullable();
            $table->decimal('design_fee', 10, 2)->default(0);
            $table->string('dispatch_time')->default('3-4 Days');
            $table->boolean('is_new')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_hot')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
