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
        Schema::create('site_layouts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('enable')->nullable();

            $table->string('tag')->nullable();
            $table->string('icon')->nullable();
            $table->string('name')->nullable();
            $table->string('path')->nullable();

            // 메뉴 설명
            $table->string('description')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_layouts');

    }
};