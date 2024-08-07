<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 사이트 log
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
        Schema::create('site_log', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('day')->nullable();

            $table->string('uri')->nullable();

            $table->integer('cnt')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_log');
    }
};
