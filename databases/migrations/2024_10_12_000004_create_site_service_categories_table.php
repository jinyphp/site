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
        Schema::create('site_service_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->boolean('enable')->default(true);
            $table->integer('pos')->default(0); // 정렬 순서

            $table->string('code')->unique(); // 카테고리 코드 (영문)
            $table->string('title'); // 카테고리 이름
            $table->text('description')->nullable(); // 카테고리 설명
            $table->string('image', 500)->nullable(); // 카테고리 이미지
            $table->string('color', 7)->nullable(); // 카테고리 색상 (#ffffff)
            $table->string('icon')->nullable(); // 아이콘 클래스

            // 계층형 구조를 위한 부모 카테고리 ID
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('site_service_categories')->onDelete('set null');

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // 관리
            $table->string('manager')->nullable();

            $table->index(['enable', 'deleted_at']);
            $table->index(['parent_id', 'pos']);
            $table->index(['code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_service_categories');
    }
};