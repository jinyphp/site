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
        if (!Schema::hasTable('site_countries')) {
            Schema::create('site_countries', function (Blueprint $table) {
                $table->id();
                $table->timestamps();

                $table->string('code', 3)->unique()->comment('국가 코드 (예: KR, US, JP)');
                $table->string('name', 100)->comment('국가명 (예: 대한민국, 미국)');
                $table->string('native_name', 100)->nullable()->comment('원어명 (예: South Korea, United States)');
                $table->text('description')->nullable()->comment('설명');
                $table->string('capital', 100)->nullable()->comment('수도');
                $table->string('currency', 10)->nullable()->comment('통화 코드 (예: KRW, USD)');
                $table->string('phone_code', 10)->nullable()->comment('국가 전화번호 코드 (예: +82, +1)');
                $table->string('region', 50)->nullable()->comment('지역 (예: Asia, North America)');

                // 상태 관련
                $table->boolean('enable')->default(true)->comment('활성화 여부');
                $table->boolean('is_default')->default(false)->comment('기본 국가 여부');

                // 정렬 및 기타
                $table->integer('order')->default(0)->comment('정렬 순서');
                $table->string('flag')->nullable()->comment('국기 이모지');

                $table->index(['enable', 'order']);
                $table->index(['is_default']);
            });

            // 기본 국가 데이터 삽입
            $this->insertDefaultCountries();
        }
    }

    /**
     * 기본 국가 데이터 삽입
     *
     * @return void
     */
    private function insertDefaultCountries()
    {
        $countries = [
            [
                'code' => 'KR',
                'name' => '대한민국',
                'native_name' => 'South Korea',
                'description' => '대한민국 국가 정보',
                'capital' => '서울',
                'currency' => 'KRW',
                'phone_code' => '+82',
                'region' => 'Asia',
                'enable' => true,
                'is_default' => true,
                'order' => 1,
                'flag' => '🇰🇷',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'US',
                'name' => '미국',
                'native_name' => 'United States',
                'description' => '미국 국가 정보',
                'capital' => '워싱턴 D.C.',
                'currency' => 'USD',
                'phone_code' => '+1',
                'region' => 'North America',
                'enable' => true,
                'is_default' => false,
                'order' => 2,
                'flag' => '🇺🇸',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'JP',
                'name' => '일본',
                'native_name' => 'Japan',
                'description' => '일본 국가 정보',
                'capital' => '도쿄',
                'currency' => 'JPY',
                'phone_code' => '+81',
                'region' => 'Asia',
                'enable' => true,
                'is_default' => false,
                'order' => 3,
                'flag' => '🇯🇵',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'CN',
                'name' => '중국',
                'native_name' => 'China',
                'description' => '중국 국가 정보',
                'capital' => '베이징',
                'currency' => 'CNY',
                'phone_code' => '+86',
                'region' => 'Asia',
                'enable' => false,
                'is_default' => false,
                'order' => 4,
                'flag' => '🇨🇳',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'GB',
                'name' => '영국',
                'native_name' => 'United Kingdom',
                'description' => '영국 국가 정보',
                'capital' => '런던',
                'currency' => 'GBP',
                'phone_code' => '+44',
                'region' => 'Europe',
                'enable' => false,
                'is_default' => false,
                'order' => 5,
                'flag' => '🇬🇧',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'FR',
                'name' => '프랑스',
                'native_name' => 'France',
                'description' => '프랑스 국가 정보',
                'capital' => '파리',
                'currency' => 'EUR',
                'phone_code' => '+33',
                'region' => 'Europe',
                'enable' => false,
                'is_default' => false,
                'order' => 6,
                'flag' => '🇫🇷',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'DE',
                'name' => '독일',
                'native_name' => 'Germany',
                'description' => '독일 국가 정보',
                'capital' => '베를린',
                'currency' => 'EUR',
                'phone_code' => '+49',
                'region' => 'Europe',
                'enable' => false,
                'is_default' => false,
                'order' => 7,
                'flag' => '🇩🇪',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('site_countries')->insert($countries);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_countries');
    }
};