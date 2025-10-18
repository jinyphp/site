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
        Schema::create('site_about_organization', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 부서명
            $table->string('code')->unique(); // 부서 코드
            $table->text('description')->nullable(); // 부서 설명
            $table->unsignedBigInteger('parent_id')->nullable(); // 상위 부서 ID (트리 구조)
            $table->integer('sort_order')->default(0); // 정렬 순서
            $table->integer('level')->default(0); // 조직 계층 (0: 최상위)
            $table->boolean('is_active')->default(true); // 활성화 상태
            $table->string('manager_title')->nullable(); // 관리자 직책명
            $table->string('contact_email')->nullable(); // 부서 연락처 이메일
            $table->string('contact_phone')->nullable(); // 부서 연락처 전화번호
            $table->timestamps();

            // 외래키 제약조건
            $table->foreign('parent_id')->references('id')->on('site_about_organization')->onDelete('set null');

            // 인덱스
            $table->index(['parent_id', 'sort_order']);
            $table->index(['is_active', 'level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_about_organization');
    }
};
