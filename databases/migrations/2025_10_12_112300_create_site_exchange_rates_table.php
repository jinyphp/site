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
        Schema::create('site_exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // 통화 쌍 정보
            $table->string('from_currency', 3)->comment('기준 통화 (예: USD)');
            $table->string('to_currency', 3)->comment('대상 통화 (예: KRW)');

            // 외래키 제약조건
            $table->foreign('from_currency')->references('code')->on('site_currencies');
            $table->foreign('to_currency')->references('code')->on('site_currencies');

            // 환율 정보
            $table->decimal('rate', 15, 6)->comment('환율 (1 from_currency = rate * to_currency)');
            $table->decimal('inverse_rate', 15, 6)->comment('역환율 (1 to_currency = inverse_rate * from_currency)');

            // 메타데이터
            $table->string('source', 50)->default('manual')->comment('환율 출처 (manual, api, bank 등)');
            $table->string('provider', 100)->nullable()->comment('환율 제공업체');
            $table->timestamp('rate_date')->comment('환율 기준일시');
            $table->timestamp('expires_at')->nullable()->comment('환율 만료일시');

            // 상태
            $table->boolean('is_active')->default(true)->comment('활성화 여부');
            $table->text('notes')->nullable()->comment('비고');

            // 인덱스
            $table->unique(['from_currency', 'to_currency'], 'unique_currency_pair');
            $table->index(['is_active', 'rate_date']);
            $table->index(['source']);
            $table->index(['expires_at']);
        });

        // 기본 환율 데이터 삽입
        $this->insertDefaultExchangeRates();
    }

    /**
     * 기본 환율 데이터 삽입 (KRW 기준)
     */
    private function insertDefaultExchangeRates()
    {
        $rates = [
            // USD to KRW
            [
                'from_currency' => 'USD',
                'to_currency' => 'KRW',
                'rate' => 1350.00,
                'inverse_rate' => 0.000741,
                'source' => 'manual',
                'provider' => 'Default',
                'rate_date' => now(),
                'expires_at' => now()->addDays(1),
                'is_active' => true,
                'notes' => '기본 설정 환율',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // EUR to KRW
            [
                'from_currency' => 'EUR',
                'to_currency' => 'KRW',
                'rate' => 1450.00,
                'inverse_rate' => 0.000690,
                'source' => 'manual',
                'provider' => 'Default',
                'rate_date' => now(),
                'expires_at' => now()->addDays(1),
                'is_active' => true,
                'notes' => '기본 설정 환율',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // JPY to KRW (100 JPY 기준)
            [
                'from_currency' => 'JPY',
                'to_currency' => 'KRW',
                'rate' => 9.10,
                'inverse_rate' => 0.109890,
                'source' => 'manual',
                'provider' => 'Default',
                'rate_date' => now(),
                'expires_at' => now()->addDays(1),
                'is_active' => true,
                'notes' => '기본 설정 환율 (100 JPY 기준)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // GBP to KRW
            [
                'from_currency' => 'GBP',
                'to_currency' => 'KRW',
                'rate' => 1650.00,
                'inverse_rate' => 0.000606,
                'source' => 'manual',
                'provider' => 'Default',
                'rate_date' => now(),
                'expires_at' => now()->addDays(1),
                'is_active' => true,
                'notes' => '기본 설정 환율',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // CNY to KRW
            [
                'from_currency' => 'CNY',
                'to_currency' => 'KRW',
                'rate' => 190.00,
                'inverse_rate' => 0.005263,
                'source' => 'manual',
                'provider' => 'Default',
                'rate_date' => now(),
                'expires_at' => now()->addDays(1),
                'is_active' => true,
                'notes' => '기본 설정 환율',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('site_exchange_rates')->insert($rates);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_exchange_rates');
    }
};