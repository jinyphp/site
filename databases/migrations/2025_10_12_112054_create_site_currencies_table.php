<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_currencies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('code', 3)->unique()->comment('통화 코드 (예: USD, EUR, KRW)');
            $table->string('name', 100)->comment('통화명 (예: US Dollar, Euro, Korean Won)');
            $table->string('symbol', 10)->comment('통화 기호 (예: $, €, ₩)');
            $table->text('description')->nullable()->comment('설명');

            // 소수점 자리수
            $table->integer('decimal_places')->default(2)->comment('소수점 자리수 (예: USD=2, JPY=0)');

            // 상태 관련
            $table->boolean('enable')->default(true)->comment('활성화 여부');
            $table->boolean('is_base')->default(false)->comment('기준 통화 여부 (기본 KRW)');

            // 정렬 및 기타
            $table->integer('order')->default(0)->comment('정렬 순서');

            $table->index(['enable', 'order']);
            $table->index(['is_base']);
        });

        // 기본 통화 데이터 삽입
        $this->insertDefaultCurrencies();
    }

    /**
     * 기본 통화 데이터 삽입
     */
    private function insertDefaultCurrencies()
    {
        $currencies = [
            [
                'code' => 'KRW',
                'name' => 'Korean Won',
                'symbol' => '₩',
                'description' => '대한민국 원',
                'decimal_places' => 0,
                'enable' => true,
                'is_base' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'description' => '미국 달러',
                'decimal_places' => 2,
                'enable' => true,
                'is_base' => false,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
                'description' => '유로',
                'decimal_places' => 2,
                'enable' => true,
                'is_base' => false,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'JPY',
                'name' => 'Japanese Yen',
                'symbol' => '¥',
                'description' => '일본 엔',
                'decimal_places' => 0,
                'enable' => true,
                'is_base' => false,
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'GBP',
                'name' => 'British Pound',
                'symbol' => '£',
                'description' => '영국 파운드',
                'decimal_places' => 2,
                'enable' => true,
                'is_base' => false,
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'CNY',
                'name' => 'Chinese Yuan',
                'symbol' => '¥',
                'description' => '중국 위안',
                'decimal_places' => 2,
                'enable' => false,
                'is_base' => false,
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('site_currencies')->insert($currencies);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_currencies');
    }
};