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
        Schema::create('site_shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name', 100)->comment('배송 방식명 (예: 일반배송, 택배, 특급배송)');
            $table->string('name_ko', 100)->nullable()->comment('한국어 배송 방식명');
            $table->string('code', 50)->unique()->comment('배송 방식 코드 (예: standard, express, overnight)');
            $table->text('description')->nullable()->comment('배송 방식 설명');

            // 배송 정보
            $table->integer('delivery_days_min')->default(1)->comment('최소 배송일 (일)');
            $table->integer('delivery_days_max')->default(3)->comment('최대 배송일 (일)');
            $table->string('delivery_time')->nullable()->comment('배송 시간 설명 (예: 1-3일, 당일배송)');

            // 추가 옵션
            $table->boolean('requires_signature')->default(false)->comment('서명 필요 여부');
            $table->boolean('insured')->default(false)->comment('보험 적용 여부');
            $table->boolean('trackable')->default(true)->comment('추적 가능 여부');

            // 중량/크기 제한
            $table->decimal('max_weight', 8, 2)->nullable()->comment('최대 무게 (kg)');
            $table->decimal('max_length', 8, 2)->nullable()->comment('최대 길이 (cm)');
            $table->decimal('max_width', 8, 2)->nullable()->comment('최대 너비 (cm)');
            $table->decimal('max_height', 8, 2)->nullable()->comment('최대 높이 (cm)');

            // 상태 관련
            $table->boolean('enable')->default(true)->comment('활성화 여부');
            $table->boolean('is_default')->default(false)->comment('기본 배송 방식 여부');

            // 정렬 및 기타
            $table->integer('order')->default(0)->comment('정렬 순서');

            $table->index(['enable', 'order']);
            $table->index(['is_default']);
            $table->index(['code']);
        });

        // 기본 배송 방식 데이터 삽입
        $this->insertDefaultShippingMethods();
    }

    /**
     * 기본 배송 방식 데이터 삽입
     */
    private function insertDefaultShippingMethods()
    {
        $methods = [
            [
                'name' => 'Standard Delivery',
                'name_ko' => '일반배송',
                'code' => 'standard',
                'description' => '일반적인 배송 서비스',
                'delivery_days_min' => 2,
                'delivery_days_max' => 5,
                'delivery_time' => '2-5일',
                'requires_signature' => false,
                'insured' => false,
                'trackable' => true,
                'max_weight' => 30.00,
                'max_length' => 100.00,
                'max_width' => 100.00,
                'max_height' => 100.00,
                'enable' => true,
                'is_default' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Express Delivery',
                'name_ko' => '특급배송',
                'code' => 'express',
                'description' => '빠른 배송 서비스',
                'delivery_days_min' => 1,
                'delivery_days_max' => 2,
                'delivery_time' => '1-2일',
                'requires_signature' => false,
                'insured' => true,
                'trackable' => true,
                'max_weight' => 20.00,
                'max_length' => 80.00,
                'max_width' => 80.00,
                'max_height' => 80.00,
                'enable' => true,
                'is_default' => false,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Overnight Delivery',
                'name_ko' => '당일배송',
                'code' => 'overnight',
                'description' => '당일 배송 서비스',
                'delivery_days_min' => 0,
                'delivery_days_max' => 1,
                'delivery_time' => '당일-1일',
                'requires_signature' => true,
                'insured' => true,
                'trackable' => true,
                'max_weight' => 10.00,
                'max_length' => 50.00,
                'max_width' => 50.00,
                'max_height' => 50.00,
                'enable' => true,
                'is_default' => false,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Economy Delivery',
                'name_ko' => '경제배송',
                'code' => 'economy',
                'description' => '저렴한 배송 서비스',
                'delivery_days_min' => 5,
                'delivery_days_max' => 10,
                'delivery_time' => '5-10일',
                'requires_signature' => false,
                'insured' => false,
                'trackable' => false,
                'max_weight' => 50.00,
                'max_length' => 150.00,
                'max_width' => 150.00,
                'max_height' => 150.00,
                'enable' => true,
                'is_default' => false,
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Free Shipping',
                'name_ko' => '무료배송',
                'code' => 'free',
                'description' => '무료 배송 서비스 (조건부)',
                'delivery_days_min' => 3,
                'delivery_days_max' => 7,
                'delivery_time' => '3-7일',
                'requires_signature' => false,
                'insured' => false,
                'trackable' => true,
                'max_weight' => 25.00,
                'max_length' => 80.00,
                'max_width' => 80.00,
                'max_height' => 80.00,
                'enable' => true,
                'is_default' => false,
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('site_shipping_methods')->insert($methods);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_shipping_methods');
    }
};