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
        Schema::create('site_guide_cate', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('카테고리 코드');
            $table->string('title')->comment('카테고리 제목');
            $table->text('content')->nullable()->comment('카테고리 설명');
            $table->integer('pos')->default(0)->comment('정렬 순서');
            $table->boolean('enable')->default(true)->comment('활성화 여부');
            $table->timestamps();

            // 인덱스 추가
            $table->index(['enable', 'pos']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_guide_cate');
    }
};
