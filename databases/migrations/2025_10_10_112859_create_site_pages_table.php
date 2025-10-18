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
        Schema::create('site_pages', function (Blueprint $table) {
            $table->id();

            // 기본 정보
            $table->string('title'); // 페이지 제목
            $table->string('slug')->unique(); // URL 경로 (예: /about, /contact)
            $table->text('content')->nullable(); // 페이지 내용
            $table->text('excerpt')->nullable(); // 요약/설명

            // SEO 관련
            $table->string('meta_title')->nullable(); // SEO 제목
            $table->text('meta_description')->nullable(); // SEO 설명
            $table->text('meta_keywords')->nullable(); // SEO 키워드
            $table->string('og_title')->nullable(); // Open Graph 제목
            $table->text('og_description')->nullable(); // Open Graph 설명
            $table->string('og_image')->nullable(); // Open Graph 이미지

            // 상태 관리
            $table->enum('status', ['published', 'draft', 'private'])->default('draft'); // 상태
            $table->boolean('is_featured')->default(false); // 추천 페이지
            $table->integer('view_count')->default(0); // 조회수
            $table->integer('sort_order')->default(0); // 정렬 순서

            // 레이아웃 및 템플릿
            $table->string('template')->nullable(); // 사용할 템플릿
            $table->string('layout')->nullable(); // 레이아웃
            $table->string('header')->nullable(); // 헤더
            $table->string('footer')->nullable(); // 푸터
            $table->string('sidebar')->nullable(); // 사이드바
            $table->json('custom_fields')->nullable(); // 커스텀 필드 (JSON)

            // 발행 관리
            $table->timestamp('published_at')->nullable(); // 발행일
            $table->unsignedBigInteger('created_by')->nullable(); // 작성자
            $table->unsignedBigInteger('updated_by')->nullable(); // 수정자

            $table->timestamps();
            $table->softDeletes(); // SoftDeletes 지원

            // 인덱스
            $table->index(['status', 'published_at']);
            $table->index(['slug']);
            $table->index(['sort_order']);

            // 외래키
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_pages');
    }
};
