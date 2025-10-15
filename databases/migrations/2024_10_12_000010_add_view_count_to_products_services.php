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
        // Add view_count to site_products table
        Schema::table('site_products', function (Blueprint $table) {
            $table->unsignedInteger('view_count')->default(0)->after('featured');
            $table->index(['view_count']);
        });

        // Add view_count to site_services table
        Schema::table('site_services', function (Blueprint $table) {
            $table->unsignedInteger('view_count')->default(0)->after('featured');
            $table->index(['view_count']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_products', function (Blueprint $table) {
            $table->dropIndex(['view_count']);
            $table->dropColumn('view_count');
        });

        Schema::table('site_services', function (Blueprint $table) {
            $table->dropIndex(['view_count']);
            $table->dropColumn('view_count');
        });
    }
};