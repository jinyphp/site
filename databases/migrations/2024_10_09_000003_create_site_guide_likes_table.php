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
        Schema::create('site_guide_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guide_id');
            $table->string('user_ip', 45); // IPv4/IPv6 support
            $table->unsignedBigInteger('user_id')->nullable(); // 로그인한 사용자용
            $table->enum('type', ['like', 'dislike'])->default('like');
            $table->timestamps();

            // 인덱스
            $table->index(['guide_id', 'type']);
            $table->index(['user_ip', 'guide_id']);
            $table->index(['user_id', 'guide_id']);

            // 동일한 사용자(IP 또는 user_id)가 동일한 가이드에 중복 좋아요 방지
            $table->unique(['guide_id', 'user_ip', 'type'], 'unique_guide_ip_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_guide_likes');
    }
};