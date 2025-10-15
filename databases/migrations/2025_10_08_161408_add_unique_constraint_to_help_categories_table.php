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
        Schema::table('site_help_cate', function (Blueprint $table) {
            // 코드 필드에 유니크 제약조건 추가
            $table->unique('code', 'unique_help_category_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_help_cate', function (Blueprint $table) {
            $table->dropUnique('unique_help_category_code');
        });
    }
};
