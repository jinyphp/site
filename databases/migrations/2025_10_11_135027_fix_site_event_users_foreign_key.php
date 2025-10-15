<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite에서 외래키를 수정하려면 테이블을 다시 만들어야 함

        // 1. 기존 데이터 백업
        DB::statement('CREATE TABLE site_event_users_backup AS SELECT * FROM site_event_users');

        // 2. 기존 테이블 삭제
        Schema::dropIfExists('site_event_users');

        // 3. 올바른 외래키로 새 테이블 생성
        Schema::create('site_event_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamps();

            // 올바른 외래키 설정
            $table->foreign('event_id')->references('id')->on('site_event')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // 고유 제약조건
            $table->unique(['event_id', 'email']);
        });

        // 4. 데이터 복원
        DB::statement('INSERT INTO site_event_users SELECT * FROM site_event_users_backup');

        // 5. 백업 테이블 삭제
        DB::statement('DROP TABLE site_event_users_backup');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 원래 상태로 되돌리기는 복잡하므로 생략
        // 필요시 수동으로 처리
    }
};
