<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Product Categories에 slug 추가
        Schema::table('site_product_categories', function (Blueprint $table) {
            $table->string('slug')->unique()->after('code');
            $table->index(['slug']);
        });

        // Service Categories에 slug 추가
        Schema::table('site_service_categories', function (Blueprint $table) {
            $table->string('slug')->unique()->after('code');
            $table->index(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_product_categories', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropColumn('slug');
        });

        Schema::table('site_service_categories', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropColumn('slug');
        });
    }
};