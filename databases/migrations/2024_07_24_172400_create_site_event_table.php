<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 이벤트 관리
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
        Schema::create('site_event', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 슬라이더 활성화
            $table->string('enable')->nullable();


            $table->string('code')->nullable();

            ## 적용 블레이드
            $table->string('blade')->nullable();

            $table->string('image')->nullable();

            $table->string('title')->nullable();

            ## 메모
            $table->text('description')->nullable();

            ## 카테고리 관리자 아이디
            $table->string('manager')->nullable();

            ## 상태
            $table->string('status')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_event');
    }
};
