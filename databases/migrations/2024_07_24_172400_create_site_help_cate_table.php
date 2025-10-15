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
        Schema::create('site_help_cate', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 활성화
            $table->string('enable')->nullable();

            ## 카테고리
            $table->string('code')->nullable();

            $table->string('icon')->nullable();
            $table->string('title')->nullable();
            $table->text('content')->nullable();


            $table->string('image')->nullable();

            $table->string('manager')->nullable();

            $table->integer('like')->default(1);

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
        Schema::dropIfExists('site_help_cate');
    }
};
