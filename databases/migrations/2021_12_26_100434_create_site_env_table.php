<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteEnvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_env', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('enable')->default(1);

            $table->string('code')->nullable();
            $table->string('afterlogin')->nullable();
            $table->string('dome')->nullable();
            $table->string('type')->nullable();
            $table->string('process')->nullable();
            $table->string('domain')->nullable();
            $table->string('language1')->nullable();
            $table->string('country1')->nullable();
            $table->string('adult_check')->nullable();
            $table->string('menu_code')->nullable();
            $table->string('menu_code_login')->nullable();
            $table->string('members_prices')->nullable();
            $table->string('members_auth')->nullable();
            $table->string('members_point')->nullable();
            $table->string('theme')->nullable();
            $table->string('align')->nullable();
            $table->string('width')->nullable();
            $table->string('bgcolor')->nullable();
            $table->string('left_margin')->nullable();
            $table->string('top_margin')->nullable();


            $table->string('index_pages')->nullable();
            $table->string('header_pages')->nullable();
            $table->string('footer_pages')->nullable();
            $table->string('language')->nullable();
            $table->string('logo')->nullable();

            $table->string('title')->nullable();
            $table->string('seo')->nullable();


            $table->text('description')->nullable();
            // 작업자ID
            $table->unsignedBigInteger('user_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_env');
    }
}
