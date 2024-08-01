<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 사이트 메니져
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_manager', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('enable')->default(1);

            $table->string('user')->nullable();

            $table->string('user_name')->nullable();

            // 이메일
            $table->string('email')->nullable();

            ## 역할
            $table->string('role')->nullable();

            ## 관리자
            $table->string('manager')->nullable();

            ## 설명
            $table->text('description')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_manager');
    }
};
