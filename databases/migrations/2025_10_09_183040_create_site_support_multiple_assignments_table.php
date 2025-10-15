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
        Schema::create('site_support_multiple_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_id'); // 지원 요청 ID
            $table->unsignedBigInteger('assignee_id'); // 할당받은 관리자 ID
            $table->enum('role', ['primary', 'secondary'])->default('secondary'); // 역할: 주담당자, 부담당자
            $table->unsignedBigInteger('assigned_by')->nullable(); // 할당한 관리자 ID
            $table->boolean('is_active')->default(true); // 활성 상태
            $table->text('note')->nullable(); // 할당 노트
            $table->timestamp('assigned_at')->useCurrent(); // 할당 시간
            $table->timestamp('deactivated_at')->nullable(); // 비활성화 시간
            $table->timestamps();

            // 외래키 및 인덱스
            $table->foreign('support_id')->references('id')->on('site_support')->onDelete('cascade');
            $table->foreign('assignee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('set null');

            // 복합 유니크 인덱스 (하나의 지원 요청에 같은 관리자가 중복 할당되지 않도록)
            $table->unique(['support_id', 'assignee_id'], 'unique_support_assignee');

            $table->index(['support_id', 'is_active']);
            $table->index(['assignee_id', 'is_active']);
            $table->index(['role', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_support_multiple_assignments');
    }
};
