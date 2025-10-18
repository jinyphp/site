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
        Schema::create('site_about_history', function (Blueprint $table) {
            $table->id();
            $table->boolean('enable')->default(true)->comment('활성화/비활성화');
            $table->date('event_date')->comment('연혁 일자');
            $table->string('title')->comment('주요 제목');
            $table->text('subtitle')->nullable()->comment('서브 내용');
            $table->integer('sort_order')->default(0)->comment('출력 순서');
            $table->timestamps();

            // 인덱스 추가
            $table->index(['enable', 'sort_order', 'event_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_about_history');
    }
};
