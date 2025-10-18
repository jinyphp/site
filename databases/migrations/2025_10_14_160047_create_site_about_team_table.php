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
        Schema::create('site_about_team', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id'); // 소속 조직 ID
            $table->string('name'); // 이름
            $table->string('position'); // 직책
            $table->string('title')->nullable(); // 직급
            $table->text('bio')->nullable(); // 소개
            $table->string('email')->nullable(); // 이메일
            $table->string('phone')->nullable(); // 전화번호
            $table->string('avatar')->nullable(); // 프로필 사진 URL
            $table->string('linkedin')->nullable(); // LinkedIn 프로필
            $table->json('specialties')->nullable(); // 전문분야 (JSON 배열)
            $table->json('education')->nullable(); // 학력 (JSON 배열)
            $table->json('experience')->nullable(); // 경력 (JSON 배열)
            $table->integer('sort_order')->default(0); // 정렬 순서
            $table->boolean('is_active')->default(true); // 활성화 상태
            $table->boolean('is_manager')->default(false); // 관리자 여부
            $table->date('join_date')->nullable(); // 입사일
            $table->timestamps();

            // 외래키 제약조건
            $table->foreign('organization_id')->references('id')->on('site_about_organization')->onDelete('cascade');

            // 인덱스
            $table->index(['organization_id', 'sort_order']);
            $table->index(['is_active', 'is_manager']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_about_team');
    }
};
