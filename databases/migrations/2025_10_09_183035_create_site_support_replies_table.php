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
        Schema::create('site_support_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_id'); // 지원 요청 ID
            $table->unsignedBigInteger('user_id')->nullable(); // 작성자 ID (관리자 또는 고객)
            $table->enum('type', ['question', 'answer', 'note'])->default('answer'); // 유형: 질문, 답변, 내부 노트
            $table->enum('sender_type', ['customer', 'admin']); // 발송자 유형
            $table->text('content'); // 내용
            $table->json('attachments')->nullable(); // 첨부파일
            $table->boolean('is_private')->default(false); // 내부 메모 여부 (고객에게 비공개)
            $table->boolean('is_read')->default(false); // 읽음 여부
            $table->timestamp('read_at')->nullable(); // 읽은 시간
            $table->string('ip_address')->nullable(); // IP 주소
            $table->text('user_agent')->nullable(); // 사용자 에이전트
            $table->timestamps();

            // 외래키 및 인덱스
            $table->foreign('support_id')->references('id')->on('site_support')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->index(['support_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['sender_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_support_replies');
    }
};
