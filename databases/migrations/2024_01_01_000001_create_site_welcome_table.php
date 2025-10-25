<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Site Welcome 테이블 생성 마이그레이션
 *
 * @description
 * Welcome 페이지 블록들을 데이터베이스로 관리하기 위한 테이블입니다.
 * 그룹별 관리, 스케줄링, 미리보기 기능을 지원합니다.
 *
 * @features
 * - 그룹별 블록 관리 (group1, group2, ...)
 * - 배포 일자 스케줄링
 * - 미리보기 기능
 * - 블록 순서 관리
 * - 개별 블록 활성화/비활성화
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_welcome', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // 그룹 관리
            $table->string('group_name', 50)->default('default')->comment('그룹명 (group1, group2, etc.)');
            $table->string('group_title')->nullable()->comment('그룹 제목 (관리용)');
            $table->text('group_description')->nullable()->comment('그룹 설명');

            // 블록 정보
            $table->string('block_name')->comment('블록 이름');
            $table->string('view_template')->comment('뷰 템플릿 경로');
            $table->json('config')->nullable()->comment('블록 설정값 (JSON)');
            $table->integer('order')->default(0)->comment('블록 순서');
            $table->boolean('is_enabled')->default(true)->comment('블록 활성화 여부');

            // 스케줄링 및 배포 관리
            $table->datetime('deploy_at')->nullable()->comment('배포 예정일시');
            $table->boolean('is_active')->default(false)->comment('그룹 활성화 상태 (현재 사용 중)');
            $table->boolean('is_published')->default(false)->comment('그룹 배포 상태');

            // 메타 정보
            $table->string('status', 20)->default('draft')->comment('상태: draft, scheduled, active, archived');
            $table->json('meta')->nullable()->comment('추가 메타데이터');

            // 작성자 정보
            $table->unsignedBigInteger('created_by')->nullable()->comment('작성자 ID');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('수정자 ID');

            // 타임스탬프
            $table->timestamps();

            // 인덱스
            $table->index(['group_name', 'is_active'], 'idx_group_active');
            $table->index(['deploy_at', 'status'], 'idx_deploy_status');
            $table->index(['group_name', 'order'], 'idx_group_order');
            $table->index(['is_published', 'deploy_at'], 'idx_published_deploy');

            // 외래키 (선택사항 - users 테이블이 있는 경우)
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_welcome');
    }
};