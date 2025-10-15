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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('베너 제목');
            $table->text('message')->comment('베너 메시지 내용');
            $table->enum('type', ['info', 'warning', 'success', 'danger', 'primary', 'secondary'])->default('info')->comment('베너 타입');
            $table->string('link_url')->nullable()->comment('클릭시 이동할 URL');
            $table->string('link_text')->nullable()->comment('링크 텍스트');
            $table->string('icon')->nullable()->comment('아이콘 클래스');
            $table->string('background_color')->nullable()->comment('배경색');
            $table->string('text_color')->nullable()->comment('텍스트 색');
            $table->boolean('enable')->default(true)->comment('활성화 여부');
            $table->dateTime('start_date')->nullable()->comment('시작일');
            $table->dateTime('end_date')->nullable()->comment('종료일');
            $table->integer('display_order')->default(0)->comment('표시 순서');
            $table->boolean('is_closable')->default(true)->comment('닫기 버튼 여부');
            $table->integer('cookie_days')->default(1)->comment('쿠키 유지일수');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
