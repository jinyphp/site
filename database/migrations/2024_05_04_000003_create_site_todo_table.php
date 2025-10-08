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
        Schema::create('site_todo', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('enable')->nullable();

            $table->string('status')->nullable();

            // 작성자 정보
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable(); // 비회원일 경우 비밀번호 필요

            // post 정보
            $table->string('categories')->nullable();
            $table->string('keyword')->nullable();
            $table->string('tags')->nullable();

            $table->string('expired')->nullable();

            // 제목내용
            $table->string('title')->nullable();
            $table->text('content')->nullable();

            // post 대표 이미지
            $table->string('image')->nullable();


            $table->unsignedBigInteger('click')->default(0); // 조회수
            $table->unsignedBigInteger('like')->default(0); //좋아요
            $table->unsignedBigInteger('rank')->default(0); //랭크
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_todo');
    }
};
