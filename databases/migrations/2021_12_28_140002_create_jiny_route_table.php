<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJinyRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jiny_route', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('enable')->default(1);

            $table->string('uri')->nullable();
            $table->string('route')->unique();
            $table->string('type')->nullable(); // view, post, markdown
            $table->string('path')->nullable();

            $table->string('page')->nullable();

            $table->string('title')->nullable();
            $table->string('controller')->nullable();

            // 조회수
            $table->unsignedBigInteger('cnt')->default(0);

            $table->string('description')->nullable();
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
        Schema::dropIfExists('sjiny_route');
    }
}
