<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteVoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_vote', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('enable')->default(1);

            $table->string('title')->nullable();

            $table->integer('tot')->default(0); // 합계
            $table->integer('cnt')->default(0); // 횟수

            $table->string('manager')->nullable();

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
        Schema::dropIfExists('site_vote');
    }
}
