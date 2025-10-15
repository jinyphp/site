<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 계시판 목록
     */
    public function up(): void
    {
        Schema::create('site_board', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 활성화
            $table->string('enable')->nullable();

            ## 분류코드
            $table->string('code')->nullable();
            $table->string('slug')->nullable(); // url 임시코드

            //
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();

            // board 대표 이미지
            $table->string('image')->nullable();

            $table->text('header')->nullable();
            $table->text('footer')->nullable();

            // Blade
            //$table->string('blade')->nullable();
            $table->string('view_layout')->nullable();
            $table->string('view_table')->nullable();
            $table->string('view_list')->nullable();
            $table->string('view_filter')->nullable();
            $table->string('view_create')->nullable();
            $table->string('view_detail')->nullable();
            $table->string('view_edit')->nullable();
            $table->string('view_form')->nullable();

            ## 권환
            $table->string('permit_read')->nullable();
            $table->string('permit_create')->nullable();
            $table->string('permit_edit')->nullable();
            $table->string('permit_delete')->nullable();

            ## 설명
            $table->text('description')->nullable();

            ## 관리자
            $table->string('manager')->nullable();

            ## 글갯수
            $table->unsignedBigInteger('post')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_board');
    }
};
