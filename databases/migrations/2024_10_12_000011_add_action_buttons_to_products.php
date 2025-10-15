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
        Schema::table('site_products', function (Blueprint $table) {
            // Action button settings
            $table->boolean('enable_purchase')->default(true)->after('view_count');
            $table->boolean('enable_cart')->default(true)->after('enable_purchase');
            $table->boolean('enable_quote')->default(true)->after('enable_cart');
            $table->boolean('enable_contact')->default(true)->after('enable_quote');
            $table->boolean('enable_social_share')->default(true)->after('enable_contact');

            // Index for performance
            $table->index(['enable_purchase', 'enable_cart', 'enable_quote', 'enable_contact']);
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
            $table->dropIndex(['enable_purchase', 'enable_cart', 'enable_quote', 'enable_contact']);
            $table->dropColumn([
                'enable_purchase',
                'enable_cart',
                'enable_quote',
                'enable_contact',
                'enable_social_share'
            ]);
        });
    }
};