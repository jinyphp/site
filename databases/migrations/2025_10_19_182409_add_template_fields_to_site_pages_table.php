<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('site_pages', function (Blueprint $table) {
            // 기존 header, footer, sidebar 컬럼을 새로운 이름으로 변경
            $table->string('header_template')->nullable()->after('layout');
            $table->string('footer_template')->nullable()->after('header_template');
            $table->string('sidebar_template')->nullable()->after('footer_template');
        });

        // 기존 데이터 이전
        DB::statement('UPDATE site_pages SET header_template = header WHERE header IS NOT NULL');
        DB::statement('UPDATE site_pages SET footer_template = footer WHERE footer IS NOT NULL');
        DB::statement('UPDATE site_pages SET sidebar_template = sidebar WHERE sidebar IS NOT NULL');

        // 기존 컬럼 제거
        Schema::table('site_pages', function (Blueprint $table) {
            $table->dropColumn(['header', 'footer', 'sidebar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_pages', function (Blueprint $table) {
            // 기존 컬럼 복원
            $table->string('header')->nullable()->after('layout');
            $table->string('footer')->nullable()->after('header');
            $table->string('sidebar')->nullable()->after('footer');
        });

        // 데이터 복원
        DB::statement('UPDATE site_pages SET header = header_template WHERE header_template IS NOT NULL');
        DB::statement('UPDATE site_pages SET footer = footer_template WHERE footer_template IS NOT NULL');
        DB::statement('UPDATE site_pages SET sidebar = sidebar_template WHERE sidebar_template IS NOT NULL');

        // 새 컬럼 제거
        Schema::table('site_pages', function (Blueprint $table) {
            $table->dropColumn(['header_template', 'footer_template', 'sidebar_template']);
        });
    }
};
