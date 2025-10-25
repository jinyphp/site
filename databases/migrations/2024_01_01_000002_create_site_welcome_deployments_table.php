<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Site Welcome 배포 이력 테이블 생성 마이그레이션
 *
 * @description
 * Welcome 페이지 그룹들의 배포 이력을 관리하기 위한 테이블입니다.
 * 언제, 누가, 어떤 그룹을 배포했는지 추적합니다.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_welcome_deployments', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // 배포 정보
            $table->string('group_name', 50)->comment('배포된 그룹명');
            $table->string('group_title')->nullable()->comment('배포된 그룹 제목');
            $table->text('group_description')->nullable()->comment('배포된 그룹 설명');

            // 배포 타입
            $table->string('deployment_type', 20)->default('manual')->comment('배포 타입: manual, scheduled, auto');
            $table->string('deployment_status', 20)->default('success')->comment('배포 상태: success, failed, partial');

            // 배포 세부 정보
            $table->integer('blocks_count')->default(0)->comment('배포된 블록 수');
            $table->json('blocks_deployed')->nullable()->comment('배포된 블록들의 상세 정보');

            // 이전 활성 그룹 정보
            $table->string('previous_active_group')->nullable()->comment('이전에 활성화되어 있던 그룹');

            // 배포 시간
            $table->datetime('deployed_at')->comment('실제 배포된 시간');
            $table->datetime('scheduled_at')->nullable()->comment('예약된 배포 시간 (스케줄 배포인 경우)');

            // 배포자 정보
            $table->unsignedBigInteger('deployed_by')->nullable()->comment('배포를 실행한 사용자 ID');
            $table->string('deployed_by_name')->nullable()->comment('배포를 실행한 사용자 이름');

            // 추가 메타데이터
            $table->text('deployment_notes')->nullable()->comment('배포 메모');
            $table->json('deployment_metadata')->nullable()->comment('배포 관련 추가 정보');

            // 타임스탬프
            $table->timestamps();

            // 인덱스
            $table->index(['group_name', 'deployed_at'], 'idx_group_deployed');
            $table->index(['deployment_type', 'deployment_status'], 'idx_type_status');
            $table->index(['deployed_at'], 'idx_deployed_at');
            $table->index(['deployed_by'], 'idx_deployed_by');

            // 외래키 (선택사항 - users 테이블이 있는 경우)
            // $table->foreign('deployed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_welcome_deployments');
    }
};