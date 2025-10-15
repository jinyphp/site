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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('inventory_item_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['in', 'out', 'adjustment', 'transfer']); // 입고, 출고, 조정, 이동
            $table->enum('reason', [
                'purchase', 'sale', 'return', 'damage', 'theft', 'adjustment',
                'transfer', 'promotion', 'sample', 'expired', 'order_fulfillment'
            ]); // 거래 사유
            $table->integer('quantity'); // 수량 (음수 가능)
            $table->integer('previous_quantity'); // 이전 재고량
            $table->integer('new_quantity'); // 새로운 재고량
            $table->decimal('unit_cost', 10, 2)->nullable(); // 단위 원가
            $table->decimal('total_cost', 10, 2)->nullable(); // 총 비용
            $table->string('reference_type')->nullable(); // 참조 타입 (Order, Purchase 등)
            $table->unsignedBigInteger('reference_id')->nullable(); // 참조 ID
            $table->string('batch_number')->nullable(); // 배치/로트 번호
            $table->date('expiry_date')->nullable(); // 유효기간
            $table->string('supplier')->nullable(); // 공급업체
            $table->text('notes')->nullable(); // 비고
            $table->unsignedBigInteger('created_by')->nullable(); // 처리자
            $table->timestamps();

            $table->index(['product_id', 'type']);
            $table->index(['inventory_item_id']);
            $table->index(['reference_type', 'reference_id']);
            $table->index(['created_at']);
            $table->index(['reason']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
