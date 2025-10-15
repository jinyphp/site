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
        Schema::create('site_shipping_zones', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name', 100)->comment('배송 지역명 (예: 국내, 아시아, 유럽)');
            $table->string('name_ko', 100)->nullable()->comment('한국어 배송 지역명');
            $table->text('description')->nullable()->comment('배송 지역 설명');

            // 상태 관련
            $table->boolean('enable')->default(true)->comment('활성화 여부');
            $table->boolean('is_default')->default(false)->comment('기본 배송 지역 여부');

            // 정렬 및 기타
            $table->integer('order')->default(0)->comment('정렬 순서');

            $table->index(['enable', 'order']);
            $table->index(['is_default']);
        });

        // 기본 배송 지역 데이터 삽입
        $this->insertDefaultShippingZones();
    }

    /**
     * 기본 배송 지역 데이터 삽입
     */
    private function insertDefaultShippingZones()
    {
        $zones = [
            [
                'name' => 'Domestic',
                'name_ko' => '국내',
                'description' => '대한민국 내 배송',
                'enable' => true,
                'is_default' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Asia',
                'name_ko' => '아시아',
                'description' => '아시아 지역 (일본, 중국, 동남아시아 등)',
                'enable' => true,
                'is_default' => false,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'North America',
                'name_ko' => '북미',
                'description' => '북미 지역 (미국, 캐나다)',
                'enable' => true,
                'is_default' => false,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Europe',
                'name_ko' => '유럽',
                'description' => '유럽 지역',
                'enable' => true,
                'is_default' => false,
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rest of World',
                'name_ko' => '기타 지역',
                'description' => '기타 모든 지역',
                'enable' => true,
                'is_default' => false,
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('site_shipping_zones')->insert($zones);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_shipping_zones');
    }
};