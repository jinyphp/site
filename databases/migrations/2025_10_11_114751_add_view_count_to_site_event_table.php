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
        Schema::table('site_event', function (Blueprint $table) {
            $table->unsignedBigInteger('view_count')->default(0)->after('status');
            $table->timestamp('last_viewed_at')->nullable()->after('view_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_event', function (Blueprint $table) {
            $table->dropColumn(['view_count', 'last_viewed_at']);
        });
    }
};
