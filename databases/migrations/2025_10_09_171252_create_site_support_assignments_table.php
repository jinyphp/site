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
        Schema::create('site_support_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_id');
            $table->unsignedBigInteger('assigned_from')->nullable(); // 누가 할당했는지
            $table->unsignedBigInteger('assigned_to'); // 누구에게 할당했는지
            $table->string('action'); // assign, unassign, transfer
            $table->text('note')->nullable(); // 할당/이전 사유
            $table->timestamps();

            $table->foreign('support_id')->references('id')->on('site_support')->onDelete('cascade');
            $table->foreign('assigned_from')->references('id')->on('users')->onDelete('set null');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');

            $table->index(['support_id', 'created_at']);
            $table->index(['assigned_to', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_support_assignments');
    }
};
