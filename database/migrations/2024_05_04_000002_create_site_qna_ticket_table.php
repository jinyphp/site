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
        Schema::create('site_qna_ticket', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // 작성자 정보
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable(); // 비회원일 경우 비밀번호 필요

            // 제목내용
            $table->string('title')->nullable();
            $table->text('content')->nullable();


            // 분류정보
            $table->string('type')->nullable();
            $table->string('keyword')->nullable();
            $table->string('tags')->nullable();

            // 이미지
            $table->string('image')->nullable();


            //계층
            $table->unsignedBigInteger('ref')->nullable();
            $table->unsignedBigInteger('level')->nullable();
            $table->unsignedBigInteger('pos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_qna_ticket');
    }
};
