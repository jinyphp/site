<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 슬라이더 상세 이미지
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
        Schema::create('site_slider_images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 슬라이더 활성화
            $table->string('enable')->nullable();

            ## 슬라이더 코드
            ## 여러개의 슬라이더 그룹으로 분리하여 관리
            $table->string('code')->nullable();

            ## 제목
            $table->string('title')->nullable();

            ## 메모
            $table->text('description')->nullable();

            ## 이미지
            $table->string('image')->nullable();

            ## 클릭 링크
            $table->string('link')->nullable();
            $table->integer('click')->default(1); // 링크 클릭횟수

            ## 카테고리 관리자 아이디
            $table->string('manager')->nullable();

            ## 출력 순서
            $table->integer('pos')->default(1);



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_sliders');
    }
};
