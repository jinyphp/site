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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('location')->nullable(); // 보관 위치
            $table->integer('quantity_on_hand')->default(0); // 현재 재고량
            $table->integer('quantity_allocated')->default(0); // 할당된 재고량 (주문 대기중)
            $table->integer('quantity_available')->default(0); // 사용 가능한 재고량
            $table->integer('reorder_point')->default(0); // 재주문 시점
            $table->integer('reorder_quantity')->default(0); // 재주문 수량
            $table->decimal('unit_cost', 10, 2)->nullable(); // 단위 원가
            $table->date('last_received_at')->nullable(); // 마지막 입고일
            $table->date('last_sold_at')->nullable(); // 마지막 판매일
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['product_id']);
            $table->index(['quantity_on_hand']);
            $table->index(['reorder_point']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
