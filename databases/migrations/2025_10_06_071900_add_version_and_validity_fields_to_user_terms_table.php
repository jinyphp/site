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
        Schema::table('user_terms', function (Blueprint $table) {
            // 컬럼이 존재하지 않는 경우에만 추가
            if (!Schema::hasColumn('user_terms', 'version')) {
                // 버전 관리 필드 추가
                $table->string('version', 50)->nullable()->after('description')->comment('약관 버전 (예: 1.0.0)');
            }

            if (!Schema::hasColumn('user_terms', 'valid_from')) {
                // 유효기간 필드 추가
                $table->timestamp('valid_from')->nullable()->after('version')->comment('약관 시작일');
            }

            if (!Schema::hasColumn('user_terms', 'valid_to')) {
                $table->timestamp('valid_to')->nullable()->after('valid_from')->comment('약관 종료일');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_terms', function (Blueprint $table) {
            $table->dropColumn(['version', 'valid_from', 'valid_to']);
        });
    }
};
