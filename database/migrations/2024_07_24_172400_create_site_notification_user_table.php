<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
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
        Schema::create('site_notification_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 활성화
            $table->string('enable')->nullable();

            ## 사용자 id
            $table->string('user_id')->nullable();

            ## notification id
            $table->string('noti_id')->nullable();

            ## 상태
            $table->string('status')->nullable();

            $table->string('manager')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_notification_user');
    }
};
