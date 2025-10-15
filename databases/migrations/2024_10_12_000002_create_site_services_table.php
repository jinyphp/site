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
        Schema::create('site_services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->boolean('enable')->default(true);
            $table->boolean('featured')->default(false);

            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('category')->nullable();

            // 서비스 정보
            $table->decimal('price', 10, 2)->nullable();
            $table->string('duration')->nullable(); // 예: "1-2주", "30일"

            // 이미지
            $table->string('image', 500)->nullable();
            $table->text('images')->nullable(); // JSON 배열

            // 서비스 상세 정보
            $table->text('features')->nullable(); // JSON 배열 - 서비스 특징
            $table->text('process')->nullable(); // JSON 배열 - 서비스 프로세스
            $table->text('requirements')->nullable(); // JSON 배열 - 요구사항
            $table->text('deliverables')->nullable(); // JSON 배열 - 결과물
            $table->string('tags')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // 관리
            $table->string('manager')->nullable();

            $table->index(['enable', 'deleted_at']);
            $table->index(['category', 'deleted_at']);
            $table->index(['featured', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_services');
    }
};