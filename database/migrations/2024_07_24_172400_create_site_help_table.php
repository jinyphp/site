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
        Schema::create('site_help', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 활성화
            $table->string('enable')->nullable();

            ## 카테고리
            $table->string('cate')->nullable();
            $table->string('slug')->nullable();

            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();

            $table->integer('like')->default(1);

            $table->string('manager')->nullable();

            ## 출력 순서
            $table->integer('pos')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_help');
    }
};
