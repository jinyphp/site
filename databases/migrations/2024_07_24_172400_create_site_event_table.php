<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 이벤트 관리
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_event', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 슬라이더 활성화
            $table->string('enable')->nullable();

            $table->string('code')->nullable();

            ## 적용 블레이드
            $table->string('blade')->nullable();

            $table->string('image')->nullable();

            $table->string('title')->nullable();

            ## 메모
            $table->text('description')->nullable();

            ## 카테고리 관리자 아이디
            $table->string('manager')->nullable();

            ## 상태
            $table->string('status')->nullable();

            // 조회수 관련 (2025_10_11_114751에서 추가됨)
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamp('last_viewed_at')->nullable();

            // 참여 신청 기능 관련 (2025_10_11_122433에서 추가됨)
            $table->boolean('allow_participation')->default(false);
            $table->integer('max_participants')->nullable(); // null이면 무제한
            $table->timestamp('participation_start_date')->nullable();
            $table->timestamp('participation_end_date')->nullable();
            $table->enum('approval_type', ['auto', 'manual'])->default('auto');
            $table->text('participation_description')->nullable();

            // 참여자 통계 관련 (2025_10_11_131547에서 추가됨)
            $table->integer('total_participants')->default(0)->comment('총 신청자 수');
            $table->integer('approved_participants')->default(0)->comment('승인된 신청자 수');
            $table->integer('pending_participants')->default(0)->comment('대기중인 신청자 수');
            $table->integer('rejected_participants')->default(0)->comment('거부된 신청자 수');

            // 인덱스 추가 (목록 조회 성능 향상)
            $table->index(['allow_participation', 'total_participants']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_event');
    }
};
