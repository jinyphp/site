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
        // Products 테이블에 카테고리 관계 추가
        Schema::table('site_products', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('category');
            $table->foreign('category_id')->references('id')->on('site_product_categories')->onDelete('set null');
            $table->index(['category_id', 'deleted_at']);
        });

        // Services 테이블에 카테고리 관계 추가
        Schema::table('site_services', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('category');
            $table->foreign('category_id')->references('id')->on('site_service_categories')->onDelete('set null');
            $table->index(['category_id', 'deleted_at']);
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
            $table->dropForeign(['category_id']);
            $table->dropIndex(['category_id', 'deleted_at']);
            $table->dropColumn('category_id');
        });

        Schema::table('site_services', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropIndex(['category_id', 'deleted_at']);
            $table->dropColumn('category_id');
        });
    }
};