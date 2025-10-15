<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 계시판 목록
     */
    public function up(): void
    {
        Schema::create('site_board_trend', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 활성화
            $table->string('enable')->nullable();

            ## 분류코드
            $table->string('code')->nullable();
            $table->string('slug')->nullable(); // url 임시코드

            ## postid
            $table->string('post_id')->nullable();

            ## related
            $table->string('trend')->nullable();
            $table->string('trend_id')->nullable();

            ## 관리자
            $table->string('manager')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_board_trend');
    }
};
