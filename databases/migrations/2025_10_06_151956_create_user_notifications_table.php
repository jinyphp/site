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
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('enable')->nullable();

            // 수신자 정보 (샤딩 지원)
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('user_uuid', 36)->nullable()->index()->comment('User UUID for sharding');
            $table->integer('shard_id')->nullable()->index()->comment('Shard number (0-15)');
            $table->string('email')->nullable();
            $table->string('name')->nullable();

            // 알림 타입 (예: message, system, achievement, warning 등)
            $table->string('type')->nullable()->index();

            // 알림 제목 및 내용
            $table->string('title')->nullable();
            $table->text('message')->nullable();

            // 알림 데이터 (JSON으로 추가 정보 저장)
            $table->json('data')->nullable();

            // 알림 관련 링크/액션
            $table->string('action_url')->nullable();
            $table->string('action_text')->nullable();

            // 알림 상태
            $table->string('status')->nullable()->default('unread'); // unread, read
            $table->string('priority')->nullable()->default('normal'); // low, normal, high, urgent

            // 읽음 시간
            $table->timestamp('read_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};
