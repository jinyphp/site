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
        Schema::create('site_exchange_rate_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // 통화 쌍 정보
            $table->string('from_currency', 3)->comment('기준 통화 (예: USD)');
            $table->string('to_currency', 3)->comment('대상 통화 (예: KRW)');

            // 외래키 제약조건
            $table->foreign('from_currency')->references('code')->on('site_currencies');
            $table->foreign('to_currency')->references('code')->on('site_currencies');

            // 환율 정보
            $table->decimal('old_rate', 15, 6)->nullable()->comment('이전 환율');
            $table->decimal('new_rate', 15, 6)->comment('새로운 환율');
            $table->decimal('rate_change', 15, 6)->default(0)->comment('환율 변동량 (new_rate - old_rate)');
            $table->decimal('rate_change_percent', 8, 4)->default(0)->comment('환율 변동률 (%)');

            // 메타데이터
            $table->string('action', 20)->comment('액션 (create, update, delete)');
            $table->string('source', 50)->default('manual')->comment('환율 출처');
            $table->string('provider', 100)->nullable()->comment('환율 제공업체');
            $table->timestamp('rate_date')->comment('환율 기준일시');

            // API 관련 정보
            $table->json('api_response')->nullable()->comment('API 응답 데이터 (JSON)');
            $table->string('api_status', 20)->nullable()->comment('API 호출 상태');
            $table->text('api_error')->nullable()->comment('API 에러 메시지');

            // 추가 정보
            $table->string('user_agent', 255)->nullable()->comment('요청 User Agent');
            $table->ipAddress('ip_address')->nullable()->comment('요청 IP 주소');
            $table->unsignedBigInteger('admin_user_id')->nullable()->comment('관리자 ID (수동 입력시)');
            $table->text('notes')->nullable()->comment('비고');

            // 인덱스
            $table->index(['from_currency', 'to_currency']);
            $table->index(['action', 'created_at']);
            $table->index(['source', 'created_at']);
            $table->index(['rate_date']);
            $table->index(['admin_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_exchange_rate_logs');
    }
};