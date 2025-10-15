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
        Schema::create('site_product_images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('site_products')->onDelete('cascade');

            $table->boolean('enable')->default(true);
            $table->integer('pos')->default(0); // 정렬 순서
            $table->boolean('is_featured')->default(false); // 대표 이미지 여부

            $table->string('title')->nullable(); // 이미지 제목
            $table->text('description')->nullable(); // 이미지 설명
            $table->string('alt_text')->nullable(); // 대체 텍스트 (SEO)

            // 이미지 정보
            $table->string('image_url', 500); // 이미지 URL
            $table->string('thumbnail_url', 500)->nullable(); // 썸네일 URL
            $table->string('original_filename')->nullable(); // 원본 파일명
            $table->string('file_size')->nullable(); // 파일 크기
            $table->string('dimensions')->nullable(); // 이미지 크기 (예: "1920x1080")
            $table->string('mime_type')->nullable(); // MIME 타입

            // 이미지 태그 및 분류
            $table->string('tags')->nullable(); // 이미지 태그 (쉼표로 구분)
            $table->string('image_type')->nullable(); // 이미지 유형 (예: "main", "detail", "lifestyle", "tech_spec")

            $table->index(['product_id', 'enable', 'deleted_at']);
            $table->index(['product_id', 'pos']);
            $table->index(['is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_product_images');
    }
};