<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Site services table
        Schema::create('site_services', function (Blueprint $table) {
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

            // Service details
            $table->json('features')->nullable();
            $table->json('specifications')->nullable();
            $table->json('tags')->nullable();
            $table->string('service_type')->nullable(); // consultation, training, development, etc.
            $table->integer('duration')->nullable(); // Duration in minutes
            $table->string('availability')->nullable(); // 24/7, business_hours, appointment_only
            $table->boolean('booking_required')->default(false);
            $table->integer('max_participants')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // Status and ordering
            $table->string('status')->default('active'); // active, inactive, draft
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
            $table->index(['service_type', 'enable']);
            $table->index(['sort_order', 'title']);
            $table->index('slug');

            // Foreign key
            $table->foreign('category_id')->references('id')->on('site_service_categories')->onDelete('set null');
        });

        // Site service categories table
        Schema::create('site_service_categories', function (Blueprint $table) {
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
            $table->foreign('parent_id')->references('id')->on('site_service_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_services');
        Schema::dropIfExists('site_service_categories');
    }
};