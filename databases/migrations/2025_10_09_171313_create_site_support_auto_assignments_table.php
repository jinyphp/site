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
        Schema::create('site_support_auto_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 지원 요청 유형
            $table->string('priority')->nullable(); // 우선순위 (null이면 모든 우선순위)
            $table->unsignedBigInteger('assignee_id'); // 자동으로 할당할 관리자
            $table->boolean('enable')->default(true); // 활성화 여부
            $table->integer('order')->default(0); // 순서 (낮을수록 우선)
            $table->text('description')->nullable(); // 설명
            $table->timestamps();

            $table->foreign('assignee_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['type', 'priority', 'enable', 'order']);
            $table->unique(['type', 'priority', 'assignee_id'], 'unique_auto_assignment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_support_auto_assignments');
    }
};
