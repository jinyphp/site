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
        Schema::create('site_notification', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 활성화
            $table->string('enable')->nullable();

            $table->string('type')->nullable();

            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();

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
        Schema::dropIfExists('site_notification');
    }
};
