<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20);
            $table->string('company')->nullable();
            $table->string('gst_number')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode', 10);
            $table->text('notes')->nullable();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('design_charges', 12, 2)->default(0);
            $table->decimal('shipping', 12, 2)->default(0);
            $table->decimal('gst', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->string('payment_method')->default('razorpay');
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('status')->default('pending');         // pending, confirmed, designing, printing, shipped, delivered, cancelled
            $table->string('razorpay_order_id')->nullable()->index();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->json('options')->nullable();
            $table->unsignedInteger('quantity');
            $table->decimal('price', 12, 2);
            $table->decimal('design_charge', 12, 2)->default(0);
            $table->string('design_type')->default('upload'); // upload | design_with_us
            $table->string('design_file')->nullable();
            $table->timestamps();
        });

        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('contact'); // contact | quote | product
            $table->string('name');
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->string('product')->nullable();
            $table->string('quantity')->nullable();
            $table->text('message')->nullable();
            $table->string('attachment')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedTinyInteger('rating');
            $table->text('comment');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });

        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn('is_admin'));
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
