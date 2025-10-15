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
        Schema::create('site_support_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_id'); // 지원 요청 ID
            $table->unsignedBigInteger('evaluator_id')->nullable(); // 평가자 ID (고객)
            $table->unsignedBigInteger('evaluated_admin_id'); // 평가 대상 관리자 ID
            $table->tinyInteger('rating')->unsigned(); // 평점 (1-5)
            $table->text('comment')->nullable(); // 평가 코멘트
            $table->json('criteria_scores')->nullable(); // 세부 평가 기준별 점수 (응답속도, 해결능력, 친절도 등)
            $table->boolean('is_anonymous')->default(false); // 익명 평가 여부
            $table->string('ip_address')->nullable(); // IP 주소
            $table->timestamps();

            // 외래키 및 인덱스
            $table->foreign('support_id')->references('id')->on('site_support')->onDelete('cascade');
            $table->foreign('evaluator_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('evaluated_admin_id')->references('id')->on('users')->onDelete('cascade');

            // 하나의 지원 요청에 대해 한 번만 평가 가능
            $table->unique(['support_id', 'evaluator_id'], 'unique_support_evaluation');

            $table->index(['evaluated_admin_id', 'rating']);
            $table->index(['support_id', 'created_at']);
            $table->index(['rating', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_support_evaluations');
    }
};
