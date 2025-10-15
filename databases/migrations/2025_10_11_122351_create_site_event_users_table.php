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
        Schema::create('site_event_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('site_event')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            // 사용자 정보 (비회원도 참여 가능)
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message')->nullable(); // 참여 메시지

            // 참여 상태
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->string('approved_by')->nullable(); // 승인자

            $table->timestamps();

            // 중복 신청 방지 (동일 이벤트에 동일 이메일로 중복 신청 불가)
            $table->unique(['event_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_event_users');
    }
};
