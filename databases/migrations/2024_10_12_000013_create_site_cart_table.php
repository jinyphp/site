<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 사이트 장바구니 테이블 생성
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('site_cart', function (Blueprint $table) {
            $table->id();

            // 사용자 식별
            $table->unsignedBigInteger('user_id')->nullable()->comment('로그인 사용자 ID');
            $table->string('session_id')->nullable()->comment('비로그인 사용자 세션 ID');

            // 상품 정보
            $table->enum('item_type', ['product', 'service'])->comment('아이템 타입');
            $table->unsignedBigInteger('item_id')->comment('상품/서비스 ID');
            $table->unsignedBigInteger('pricing_option_id')->nullable()->comment('가격 옵션 ID');

            // 주문 정보
            $table->integer('quantity')->default(1)->comment('수량');
            $table->text('options')->nullable()->comment('추가 옵션 (JSON 형태)');

            // 메타 정보
            $table->timestamps();
            $table->softDeletes();

            // 인덱스
            $table->index(['user_id']);
            $table->index(['session_id']);
            $table->index(['item_type', 'item_id']);

            // 외래키 제약조건
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_cart');
    }
};