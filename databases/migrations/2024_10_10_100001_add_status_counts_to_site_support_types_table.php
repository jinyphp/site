<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Support Types 테이블에 상태별 요청 수 컬럼 추가
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
        Schema::table('site_support_types', function (Blueprint $table) {
            // 상태별 요청 수 추적 컬럼 추가
            $table->integer('pending_requests')->default(0)->after('total_requests');
            $table->integer('in_progress_requests')->default(0)->after('pending_requests');
            $table->integer('closed_requests')->default(0)->after('resolved_requests');
            $table->timestamp('last_stats_updated_at')->nullable()->after('avg_resolution_hours');

            // 인덱스 추가
            $table->index(['pending_requests', 'in_progress_requests']);
            $table->index('last_stats_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_support_types', function (Blueprint $table) {
            $table->dropIndex(['pending_requests', 'in_progress_requests']);
            $table->dropIndex('last_stats_updated_at');

            $table->dropColumn([
                'pending_requests',
                'in_progress_requests',
                'closed_requests',
                'last_stats_updated_at'
            ]);
        });
    }
};