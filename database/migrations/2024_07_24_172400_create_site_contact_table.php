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
        Schema::create('site_contact', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 활성화
            $table->string('enable')->nullable();

            $table->string('company')->nullable();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();

            $table->string('type')->nullable(); // contact 유형
            $table->string('subject')->nullable();
            $table->text('message')->nullable();

            $table->string('image')->nullable();

            $table->string('status')->nullable();
            $table->string('finished_at')->nullable(); // 문의 종료

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
        Schema::dropIfExists('site_contact');
    }
};
