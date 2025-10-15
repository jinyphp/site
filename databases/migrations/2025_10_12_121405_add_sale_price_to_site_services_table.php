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
        Schema::table('site_services', function (Blueprint $table) {
            $table->decimal('sale_price', 10, 2)->nullable()->after('price')->comment('할인 판매가');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_services', function (Blueprint $table) {
            $table->dropColumn('sale_price');
        });
    }
};
