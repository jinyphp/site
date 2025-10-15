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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed_amount', 'free_shipping', 'buy_x_get_y']);
            $table->decimal('value', 10, 2);
            $table->decimal('minimum_order_amount', 10, 2)->nullable();
            $table->decimal('maximum_discount_amount', 10, 2)->nullable();
            $table->integer('usage_limit')->nullable(); // 전체 사용 제한
            $table->integer('usage_limit_per_customer')->nullable(); // 고객별 사용 제한
            $table->integer('times_used')->default(0);
            $table->json('applicable_products')->nullable(); // 적용 가능한 상품 ID들
            $table->json('applicable_categories')->nullable(); // 적용 가능한 카테고리들
            $table->json('excluded_products')->nullable(); // 제외 상품 ID들
            $table->boolean('stackable')->default(false); // 다른 쿠폰과 중복 사용 가능
            $table->boolean('auto_apply')->default(false); // 자동 적용 여부
            $table->datetime('starts_at');
            $table->datetime('expires_at')->nullable();
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['code']);
            $table->index(['status', 'starts_at', 'expires_at']);
            $table->index(['type']);
            $table->index(['auto_apply']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
