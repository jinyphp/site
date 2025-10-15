<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed_amount', 'buy_x_get_y', 'free_shipping']);
            $table->decimal('value', 10, 2); // percentage or fixed amount
            $table->decimal('minimum_order_amount', 10, 2)->nullable();
            $table->decimal('maximum_discount_amount', 10, 2)->nullable();
            $table->integer('usage_limit')->nullable(); // total usage limit
            $table->integer('usage_limit_per_customer')->nullable();
            $table->integer('times_used')->default(0);
            $table->json('applicable_products')->nullable(); // specific product IDs
            $table->json('applicable_categories')->nullable(); // specific categories
            $table->json('excluded_products')->nullable(); // excluded product IDs
            $table->boolean('stackable')->default(false); // can be combined with other promotions
            $table->datetime('starts_at');
            $table->datetime('expires_at')->nullable();
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active');
            $table->timestamps();

            $table->index(['code']);
            $table->index(['status', 'starts_at', 'expires_at']);
            $table->index(['type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
