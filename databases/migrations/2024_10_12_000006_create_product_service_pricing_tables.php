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
        // 상품 가격 옵션 테이블
        Schema::create('site_product_pricing', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('site_products')->onDelete('cascade');

            $table->boolean('enable')->default(true);
            $table->integer('pos')->default(0); // 정렬 순서

            $table->string('name'); // 옵션명 (예: "기본", "프리미엄", "엔터프라이즈")
            $table->string('code')->nullable(); // 옵션 코드
            $table->text('description')->nullable(); // 옵션 설명

            $table->decimal('price', 10, 2); // 가격
            $table->decimal('sale_price', 10, 2)->nullable(); // 할인가
            $table->string('currency', 3)->default('KRW'); // 통화
            $table->string('billing_period')->nullable(); // 결제 주기 (monthly, yearly, once)

            // 옵션 상세 정보
            $table->text('features')->nullable(); // JSON - 포함된 기능들
            $table->text('limitations')->nullable(); // JSON - 제한사항들
            $table->integer('min_quantity')->default(1); // 최소 수량
            $table->integer('max_quantity')->nullable(); // 최대 수량

            $table->index(['product_id', 'enable', 'deleted_at']);
            $table->index(['pos']);
        });

        // 서비스 가격 옵션 테이블
        Schema::create('site_service_pricing', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('site_services')->onDelete('cascade');

            $table->boolean('enable')->default(true);
            $table->integer('pos')->default(0); // 정렬 순서

            $table->string('name'); // 패키지명 (예: "기본 패키지", "프리미엄 패키지")
            $table->string('code')->nullable(); // 패키지 코드
            $table->text('description')->nullable(); // 패키지 설명

            $table->decimal('price', 10, 2); // 가격
            $table->decimal('sale_price', 10, 2)->nullable(); // 할인가
            $table->string('currency', 3)->default('KRW'); // 통화
            $table->string('duration')->nullable(); // 소요 기간

            // 패키지 상세 정보
            $table->text('included_services')->nullable(); // JSON - 포함된 서비스들
            $table->text('deliverables')->nullable(); // JSON - 결과물들
            $table->text('revisions')->nullable(); // JSON - 수정 횟수 정보
            $table->boolean('rush_available')->default(false); // 급행 서비스 가능 여부
            $table->decimal('rush_fee', 10, 2)->nullable(); // 급행 추가 비용

            $table->index(['service_id', 'enable', 'deleted_at']);
            $table->index(['pos']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_service_pricing');
        Schema::dropIfExists('site_product_pricing');
    }
};