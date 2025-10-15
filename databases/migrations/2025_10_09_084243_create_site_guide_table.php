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
        Schema::create('site_guide', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable()->comment('카테고리 코드');
            $table->string('title')->comment('가이드 제목');
            $table->text('summary')->nullable()->comment('가이드 요약');
            $table->longText('content')->nullable()->comment('가이드 내용');
            $table->integer('order')->default(0)->comment('정렬 순서');
            $table->integer('views')->default(0)->comment('조회수');
            $table->boolean('enable')->default(true)->comment('활성화 여부');
            $table->timestamp('deleted_at')->nullable()->comment('삭제일시');
            $table->timestamps();

            // 인덱스 추가
            $table->index(['category', 'enable', 'order']);
            $table->index(['enable', 'views']);
            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_guide');
    }
};
