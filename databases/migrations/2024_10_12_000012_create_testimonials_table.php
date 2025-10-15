<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Testimonials table
        Schema::create('site_testimonials', function (Blueprint $table) {
            $table->id();

            // Product/Service relation
            $table->string('type')->index(); // 'product' or 'service'
            $table->unsignedBigInteger('item_id')->index(); // product_id or service_id

            // User information
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('name'); // Display name
            $table->string('email')->nullable();
            $table->string('title')->nullable(); // Job title or position
            $table->string('company')->nullable();
            $table->string('avatar')->nullable(); // Profile image URL

            // Testimonial content
            $table->string('headline'); // Testimonial title
            $table->text('content'); // Testimonial content
            $table->unsignedTinyInteger('rating')->default(5); // 1-5 stars

            // Engagement
            $table->unsignedInteger('likes_count')->default(0);
            $table->boolean('featured')->default(false); // Featured testimonial

            // Status
            $table->boolean('enable')->default(true);
            $table->boolean('verified')->default(false); // Verified user

            // Metadata
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['type', 'item_id', 'enable']);
            $table->index(['featured', 'enable']);
            $table->index(['rating', 'enable']);
            $table->index(['likes_count', 'enable']);

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // Testimonial likes table
        Schema::create('site_testimonial_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('testimonial_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();

            // Prevent duplicate likes
            $table->unique(['testimonial_id', 'user_id']);
            $table->unique(['testimonial_id', 'ip_address']);

            // Foreign keys
            $table->foreign('testimonial_id')->references('id')->on('site_testimonials')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_testimonial_likes');
        Schema::dropIfExists('site_testimonials');
    }
};