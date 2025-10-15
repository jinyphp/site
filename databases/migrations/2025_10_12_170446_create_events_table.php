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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('banner_text')->nullable();
            $table->string('banner_color')->default('#007bff');
            $table->json('banner_settings')->nullable(); // 배너 표시 설정
            $table->json('promotion_ids')->nullable(); // 연결된 프로모션 ID들
            $table->json('coupon_ids')->nullable(); // 연결된 쿠폰 ID들
            $table->json('target_audience')->nullable(); // 대상 고객 (전체, 신규, 기존 등)
            $table->datetime('starts_at');
            $table->datetime('ends_at')->nullable();
            $table->enum('status', ['draft', 'active', 'paused', 'ended'])->default('draft');
            $table->boolean('show_banner')->default(true);
            $table->boolean('show_popup')->default(false);
            $table->json('popup_settings')->nullable();
            $table->integer('priority')->default(0); // 우선순위 (높을수록 우선)
            $table->json('conditions')->nullable(); // 이벤트 참여 조건
            $table->json('rewards')->nullable(); // 이벤트 보상
            $table->integer('max_participants')->nullable(); // 최대 참여자 수
            $table->integer('current_participants')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['slug']);
            $table->index(['status', 'starts_at', 'ends_at']);
            $table->index(['priority']);
            $table->index(['show_banner', 'show_popup']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
