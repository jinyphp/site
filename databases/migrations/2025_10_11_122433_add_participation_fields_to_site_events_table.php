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
            // 참여 신청 기능 활성화 여부
            $table->boolean('allow_participation')->default(false);

            // 참여 제한 설정
            $table->integer('max_participants')->nullable(); // null이면 무제한

            // 참여 기간 설정
            $table->timestamp('participation_start_date')->nullable();
            $table->timestamp('participation_end_date')->nullable();

            // 참여 승인 방식
            $table->enum('approval_type', ['auto', 'manual'])->default('auto');

            // 참여 안내 메시지
            $table->text('participation_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_event', function (Blueprint $table) {
            $table->dropColumn([
                'allow_participation',
                'max_participants',
                'participation_start_date',
                'participation_end_date',
                'approval_type',
                'participation_description'
            ]);
        });
    }
};
