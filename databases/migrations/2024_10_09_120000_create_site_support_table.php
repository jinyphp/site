<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Support 테이블 생성
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_support', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 활성화
            $table->string('enable')->default('1');

            ## 신청자 정보
            $table->unsignedBigInteger('user_id')->nullable(); // JWT 로그인 사용자
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();

            ## 지원 요청 내용
            $table->string('type')->nullable(); // 지원 유형 (기술지원, 문의, 등)
            $table->string('subject'); // 제목
            $table->text('content'); // 내용
            $table->string('priority')->default('normal'); // urgent, high, normal, low

            ## 첨부파일
            $table->text('attachments')->nullable(); // JSON 형태로 저장

            ## 처리 상태
            $table->string('status')->default('pending'); // pending, in_progress, resolved, closed
            $table->text('admin_reply')->nullable(); // 관리자 답변
            $table->unsignedBigInteger('assigned_to')->nullable(); // 담당자 ID
            $table->timestamp('resolved_at')->nullable(); // 해결 완료 시간
            $table->timestamp('closed_at')->nullable(); // 종료 시간

            ## 메타 정보
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('referrer')->nullable();

            ## 인덱스
            $table->index('user_id');
            $table->index('status');
            $table->index('type');
            $table->index('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_support');
    }
};