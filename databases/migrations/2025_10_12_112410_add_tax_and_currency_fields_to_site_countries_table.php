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
        Schema::table('site_countries', function (Blueprint $table) {
            // 통화 정보 필드 추가
            $table->string('currency_code', 3)->nullable()->after('currency')->comment('기본 통화 코드 (site_currencies 참조)');

            // 세율 정보 필드 추가
            $table->decimal('tax_rate', 5, 4)->default(0.0000)->after('currency_code')->comment('부가세율 (예: 0.1000 = 10%)');
            $table->string('tax_name', 50)->default('VAT')->after('tax_rate')->comment('세금 명칭 (예: VAT, GST, Sales Tax)');
            $table->text('tax_description')->nullable()->after('tax_name')->comment('세금 설명');

            // 기타 필드 추가
            $table->string('name_ko', 100)->nullable()->after('name')->comment('한국어 국가명');
            $table->string('continent', 20)->nullable()->after('region')->comment('대륙');
            $table->string('timezone', 50)->nullable()->after('continent')->comment('기본 시간대');
        });

        // 기존 데이터 업데이트
        $this->updateExistingCountries();
    }

    /**
     * 기존 국가 데이터 업데이트
     */
    private function updateExistingCountries()
    {
        $updates = [
            'KR' => [
                'name_ko' => '대한민국',
                'currency_code' => 'KRW',
                'tax_rate' => 0.1000,
                'tax_name' => 'VAT',
                'tax_description' => '부가가치세',
                'continent' => 'Asia',
                'timezone' => 'Asia/Seoul',
            ],
            'US' => [
                'name_ko' => '미국',
                'currency_code' => 'USD',
                'tax_rate' => 0.0875,
                'tax_name' => 'Sales Tax',
                'tax_description' => '판매세 (평균)',
                'continent' => 'North America',
                'timezone' => 'America/New_York',
            ],
            'JP' => [
                'name_ko' => '일본',
                'currency_code' => 'JPY',
                'tax_rate' => 0.1000,
                'tax_name' => 'Consumption Tax',
                'tax_description' => '소비세',
                'continent' => 'Asia',
                'timezone' => 'Asia/Tokyo',
            ],
            'GB' => [
                'name_ko' => '영국',
                'currency_code' => 'GBP',
                'tax_rate' => 0.2000,
                'tax_name' => 'VAT',
                'tax_description' => '부가가치세',
                'continent' => 'Europe',
                'timezone' => 'Europe/London',
            ],
            'DE' => [
                'name_ko' => '독일',
                'currency_code' => 'EUR',
                'tax_rate' => 0.1900,
                'tax_name' => 'VAT',
                'tax_description' => '부가가치세',
                'continent' => 'Europe',
                'timezone' => 'Europe/Berlin',
            ],
            'CN' => [
                'name_ko' => '중국',
                'currency_code' => 'CNY',
                'tax_rate' => 0.1300,
                'tax_name' => 'VAT',
                'tax_description' => '증치세',
                'continent' => 'Asia',
                'timezone' => 'Asia/Shanghai',
            ],
        ];

        foreach ($updates as $code => $data) {
            DB::table('site_countries')
                ->where('code', $code)
                ->update($data);
        }

        // 기본 국가 설정이 없다면 KR을 기본으로 설정
        $defaultCount = DB::table('site_countries')->where('is_default', true)->count();
        if ($defaultCount === 0) {
            DB::table('site_countries')
                ->where('code', 'KR')
                ->update(['is_default' => true]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_countries', function (Blueprint $table) {
            $table->dropColumn([
                'currency_code',
                'tax_rate',
                'tax_name',
                'tax_description',
                'name_ko',
                'continent',
                'timezone'
            ]);
        });
    }
};