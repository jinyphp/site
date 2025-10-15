<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_language', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('lang', 10)->unique()->comment('언어 코드 (예: ko, en, ja)');
            $table->string('name', 100)->comment('언어명 (예: 한국어, English)');
            $table->string('native_name', 100)->nullable()->comment('원어명 (예: 한국어, English)');
            $table->text('description')->nullable()->comment('설명');
            $table->string('manager', 100)->nullable()->comment('관리자');

            // 상태 관련
            $table->boolean('enable')->default(true)->comment('활성화 여부');
            $table->boolean('is_default')->default(false)->comment('기본 언어 여부');

            // 정렬 및 기타
            $table->integer('order')->default(0)->comment('정렬 순서');
            $table->string('flag')->nullable()->comment('국기 아이콘');
            $table->string('locale')->nullable()->comment('로케일 (예: ko_KR)');

            $table->index(['enable', 'order']);
            $table->index(['is_default']);
        });

        // 기본 언어 데이터 삽입
        $this->insertDefaultLanguages();
    }

    /**
     * 기본 언어 데이터 삽입
     *
     * @return void
     */
    private function insertDefaultLanguages()
    {
        $languages = [
            [
                'lang' => 'ko',
                'name' => '한국어',
                'native_name' => '한국어',
                'description' => '한국어 언어팩',
                'manager' => 'System',
                'enable' => true,
                'is_default' => true,
                'order' => 1,
                'flag' => '🇰🇷',
                'locale' => 'ko_KR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lang' => 'en',
                'name' => 'English',
                'native_name' => 'English',
                'description' => 'English language pack',
                'manager' => 'System',
                'enable' => true,
                'is_default' => false,
                'order' => 2,
                'flag' => '🇺🇸',
                'locale' => 'en_US',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lang' => 'ja',
                'name' => '일본어',
                'native_name' => '日本語',
                'description' => '일본어 언어팩',
                'manager' => 'System',
                'enable' => true,
                'is_default' => false,
                'order' => 3,
                'flag' => '🇯🇵',
                'locale' => 'ja_JP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lang' => 'zh',
                'name' => '중국어',
                'native_name' => '中文',
                'description' => '중국어 언어팩',
                'manager' => 'System',
                'enable' => false,
                'is_default' => false,
                'order' => 4,
                'flag' => '🇨🇳',
                'locale' => 'zh_CN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lang' => 'es',
                'name' => '스페인어',
                'native_name' => 'Español',
                'description' => '스페인어 언어팩',
                'manager' => 'System',
                'enable' => false,
                'is_default' => false,
                'order' => 5,
                'flag' => '🇪🇸',
                'locale' => 'es_ES',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lang' => 'fr',
                'name' => '프랑스어',
                'native_name' => 'Français',
                'description' => '프랑스어 언어팩',
                'manager' => 'System',
                'enable' => false,
                'is_default' => false,
                'order' => 6,
                'flag' => '🇫🇷',
                'locale' => 'fr_FR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lang' => 'de',
                'name' => '독일어',
                'native_name' => 'Deutsch',
                'description' => '독일어 언어팩',
                'manager' => 'System',
                'enable' => false,
                'is_default' => false,
                'order' => 7,
                'flag' => '🇩🇪',
                'locale' => 'de_DE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('site_language')->insert($languages);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_language');

    }
};
