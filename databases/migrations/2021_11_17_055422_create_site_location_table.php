<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_location', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // 기본 설정
            $table->boolean('is_active')->default(true)->comment('활성화 상태');

            // 기본 정보
            $table->string('image')->nullable()->comment('위치 이미지');
            $table->string('country')->nullable()->comment('국가');
            $table->string('title')->nullable()->comment('위치명');
            $table->string('lang')->nullable()->comment('언어');
            $table->string('active')->nullable()->comment('활성 상태');
            $table->string('description')->nullable()->comment('설명');
            $table->string('manager')->nullable()->comment('관리자');

            // 주소 정보
            $table->string('address')->nullable()->comment('주소');
            $table->string('city')->nullable()->comment('도시');
            $table->string('state')->nullable()->comment('주/도');
            $table->string('postal_code')->nullable()->comment('우편번호');

            // 좌표 정보
            $table->decimal('latitude', 10, 8)->nullable()->comment('위도');
            $table->decimal('longitude', 11, 8)->nullable()->comment('경도');

            // 연락처 정보
            $table->string('phone')->nullable()->comment('전화번호');
            $table->string('email')->nullable()->comment('이메일');

            // 정렬
            $table->integer('sort_order')->default(0)->comment('정렬 순서');

            // 인덱스
            $table->index(['is_active', 'sort_order']);
            $table->index(['country', 'city']);
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_location');

    }
};
