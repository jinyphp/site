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
        Schema::create('site_page_content', function (Blueprint $table) {
            $table->id();

            // 페이지 관계
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('site_pages')->onDelete('cascade');

            // 블럭 정보
            $table->string('block_type', 50)->default('text'); // text, blade, html, markdown, image, video, component
            $table->string('title')->nullable(); // 블럭 제목
            $table->longText('content')->nullable(); // 블럭 내용 또는 파일 경로

            // 블럭 설정
            $table->json('settings')->nullable(); // 추가 설정값 (CSS 클래스, 스타일 등)
            $table->integer('sort_order')->default(0); // 블럭 순서
            $table->boolean('is_active')->default(true); // 활성화 여부

            // 메타 정보
            $table->string('css_class')->nullable(); // CSS 클래스
            $table->json('attributes')->nullable(); // HTML 속성들

            // 작성자 정보
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // 인덱스
            $table->index(['page_id', 'sort_order']);
            $table->index(['page_id', 'is_active']);
            $table->index('block_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_page_content');
    }
};
