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
        Schema::table('site_menus', function (Blueprint $table) {
            $table->string('menu_code', 100)->unique()->after('id')->comment('메뉴 코드 (JSON 파일명과 연결)');
            $table->text('json_path')->nullable()->after('menu_code')->comment('JSON 파일 경로');
            $table->json('menu_data')->nullable()->after('json_path')->comment('메뉴 트리 데이터 (JSON 캐시)');
            $table->timestamp('json_updated_at')->nullable()->after('menu_data')->comment('JSON 파일 마지막 업데이트 시간');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_menus', function (Blueprint $table) {
            $table->dropColumn(['menu_code', 'json_path', 'menu_data', 'json_updated_at']);
        });
    }
};
