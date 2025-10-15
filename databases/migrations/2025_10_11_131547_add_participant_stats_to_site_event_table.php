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
        Schema::table('site_event', function (Blueprint $table) {
            // 참여자 통계 컬럼 추가
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
     */
    public function down(): void
    {
        Schema::table('site_event', function (Blueprint $table) {
            // 인덱스 삭제
            $table->dropIndex(['allow_participation', 'total_participants']);

            // 참여자 통계 컬럼 삭제
            $table->dropColumn([
                'total_participants',
                'approved_participants',
                'pending_participants',
                'rejected_participants'
            ]);
        });
    }
};
