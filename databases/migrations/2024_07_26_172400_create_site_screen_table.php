<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 사이트 화면 번호검색
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
        Schema::create('site_screen', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('code')->nullable();

            $table->string('uri')->nullable();

            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('keyword')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_screen');
    }
};
