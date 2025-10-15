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
        Schema::create('site_shipping_zone_countries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // 관계 필드
            $table->foreignId('shipping_zone_id')->constrained('site_shipping_zones')->onDelete('cascade')->comment('배송 지역 ID');
            $table->string('country_code', 2)->comment('국가 코드 (ISO 3166-1 alpha-2)');

            // 상태 관련
            $table->boolean('enable')->default(true)->comment('활성화 여부');

            // 유니크 제약 (한 국가는 하나의 배송 지역에만 속함)
            $table->unique(['country_code'], 'unique_country_in_zone');

            $table->index(['shipping_zone_id']);
            $table->index(['enable']);
            $table->foreign('country_code')->references('code')->on('site_countries')->onDelete('cascade');
        });

        // 기본 국가-배송지역 매핑 데이터 삽입
        $this->insertDefaultZoneCountries();
    }

    /**
     * 기본 국가-배송지역 매핑 데이터 삽입
     */
    private function insertDefaultZoneCountries()
    {
        // 배송 지역 ID 가져오기
        $domesticZone = DB::table('site_shipping_zones')->where('name', 'Domestic')->first();
        $asiaZone = DB::table('site_shipping_zones')->where('name', 'Asia')->first();
        $northAmericaZone = DB::table('site_shipping_zones')->where('name', 'North America')->first();
        $europeZone = DB::table('site_shipping_zones')->where('name', 'Europe')->first();
        $restOfWorldZone = DB::table('site_shipping_zones')->where('name', 'Rest of World')->first();

        $mappings = [];

        // 국내 (한국)
        if ($domesticZone) {
            $mappings[] = [
                'shipping_zone_id' => $domesticZone->id,
                'country_code' => 'KR',
                'enable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 아시아 지역
        if ($asiaZone) {
            $asiaCountries = ['JP', 'CN', 'TH', 'VN', 'SG', 'MY', 'ID', 'PH', 'TW', 'HK', 'MO', 'IN', 'BD', 'LK', 'MM', 'KH', 'LA', 'BN', 'MN', 'KZ', 'UZ', 'KG', 'TJ', 'TM'];

            foreach ($asiaCountries as $countryCode) {
                $mappings[] = [
                    'shipping_zone_id' => $asiaZone->id,
                    'country_code' => $countryCode,
                    'enable' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // 북미 지역
        if ($northAmericaZone) {
            $northAmericaCountries = ['US', 'CA', 'MX'];

            foreach ($northAmericaCountries as $countryCode) {
                $mappings[] = [
                    'shipping_zone_id' => $northAmericaZone->id,
                    'country_code' => $countryCode,
                    'enable' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // 유럽 지역
        if ($europeZone) {
            $europeCountries = ['GB', 'DE', 'FR', 'IT', 'ES', 'NL', 'BE', 'AT', 'CH', 'SE', 'NO', 'DK', 'FI', 'IE', 'PT', 'GR', 'PL', 'CZ', 'HU', 'SK', 'SI', 'HR', 'BG', 'RO', 'EE', 'LV', 'LT', 'LU', 'MT', 'CY'];

            foreach ($europeCountries as $countryCode) {
                $mappings[] = [
                    'shipping_zone_id' => $europeZone->id,
                    'country_code' => $countryCode,
                    'enable' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // 기타 지역 (남미, 아프리카, 오세아니아 등)
        if ($restOfWorldZone) {
            $restOfWorldCountries = ['AU', 'NZ', 'BR', 'AR', 'CL', 'PE', 'CO', 'VE', 'UY', 'PY', 'BO', 'EC', 'GY', 'SR', 'GF', 'ZA', 'NG', 'EG', 'MA', 'DZ', 'TN', 'LY', 'SD', 'ET', 'KE', 'UG', 'TZ', 'RW', 'BI', 'DJ', 'SO', 'ER', 'SS', 'TD', 'CF', 'CM', 'GQ', 'GA', 'CG', 'CD', 'ST', 'AO', 'ZM', 'ZW', 'BW', 'NA', 'SZ', 'LS', 'MW', 'MZ', 'MG', 'MU', 'SC', 'KM', 'CV', 'GW', 'SN', 'GM', 'GN', 'SL', 'LR', 'CI', 'GH', 'TG', 'BJ', 'NE', 'BF', 'ML', 'MR'];

            foreach ($restOfWorldCountries as $countryCode) {
                $mappings[] = [
                    'shipping_zone_id' => $restOfWorldZone->id,
                    'country_code' => $countryCode,
                    'enable' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // 존재하는 국가 코드만 삽입 (site_countries 테이블에 있는 국가만)
        $existingCountries = DB::table('site_countries')->pluck('code')->toArray();
        $validMappings = array_filter($mappings, function($mapping) use ($existingCountries) {
            return in_array($mapping['country_code'], $existingCountries);
        });

        if (!empty($validMappings)) {
            DB::table('site_shipping_zone_countries')->insert($validMappings);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_shipping_zone_countries');
    }
};