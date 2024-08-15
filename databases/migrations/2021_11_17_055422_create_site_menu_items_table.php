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
        Schema::create('site_menu_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // 메뉴코드, 아이디
            $table->string('code')->nullable();
            $table->unsignedBigInteger('menu_id')->default(0);

            // 메뉴 활성화
            $table->string('enable')->nullable();

            $table->string('header')->nullable();
            $table->string('title')->nullable();
            $table->string('name')->nullable();

            // 아이콘 출력
            $table->string('icon')->nullable();

            // 링크
            $table->string('href')->nullable();
            $table->string('target')->nullable(); // 새창으로 실행
            $table->string('selected')->nullable();

            $table->string('submenu')->nullable(); // 서브메뉴 포함여부

            // 메뉴트리 위치관계
            $table->integer('ref')->default(0);
            $table->integer('level')->default(0);
            $table->integer('pos')->default(1);

            // 메뉴 설명
            $table->string('description')->nullable();

            // 관리자ID
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
        Schema::dropIfExists('site_menu_items');

    }
};
