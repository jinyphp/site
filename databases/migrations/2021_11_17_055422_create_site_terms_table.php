<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_terms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('enable')->nullable();
            $table->string('require')->nullable();

            $table->string('slug')->nullable();
            $table->string('title')->nullable();

            $table->string('blade')->nullable();



            // 메뉴 설명
            $table->string('description')->nullable();

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
        Schema::dropIfExists('site_terms');

    }
};
