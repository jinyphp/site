<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Site products table
        Schema::create('site_products', function (Blueprint $table) {
            $table->id();

            // Basic information
            $table->boolean('enable')->default(true);
            $table->boolean('featured')->default(false);
            $table->string('slug')->unique()->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();

            // Category
            $table->string('category')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            // Pricing
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->nullable();

            // Media
            $table->string('image')->nullable();
            $table->json('images')->nullable();

            // Product details
            $table->json('features')->nullable();
            $table->json('specifications')->nullable();
            $table->json('tags')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->json('dimensions')->nullable(); // {length, width, height, unit}

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // Status and ordering
            $table->string('status')->default('active'); // active, inactive, draft
            $table->string('stock_status')->default('in_stock'); // in_stock, out_of_stock, on_backorder
            $table->integer('sort_order')->default(0);

            // Management
            $table->string('manager')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['enable', 'featured']);
            $table->index(['enable', 'status']);
            $table->index(['category_id', 'enable']);
            $table->index(['price', 'enable']);
            $table->index(['sort_order', 'title']);
            $table->index('slug');
            $table->index('sku');

            // Foreign key
            $table->foreign('category_id')->references('id')->on('site_product_categories')->onDelete('set null');
        });

        // Site product categories table
        Schema::create('site_product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('enable')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['parent_id', 'enable']);
            $table->index(['sort_order', 'name']);
            $table->index('slug');

            // Foreign key
            $table->foreign('parent_id')->references('id')->on('site_product_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_products');
        Schema::dropIfExists('site_product_categories');
    }
};