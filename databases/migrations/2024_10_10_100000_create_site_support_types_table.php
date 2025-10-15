<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Support Types 테이블 생성
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_support_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            ## 활성화
            $table->boolean('enable')->default(true);

            ## 기본 정보
            $table->string('name'); // 유형 이름 (예: 기술지원, 결제문의)
            $table->string('code')->unique(); // 시스템 코드 (예: technical, billing)
            $table->text('description')->nullable(); // 상세 설명

            ## 표시 설정
            $table->string('icon')->nullable(); // 아이콘 클래스 (fe fe-code, fe fe-credit-card 등)
            $table->string('color')->default('#007bff'); // 색상 코드
            $table->integer('sort_order')->default(0); // 정렬 순서

            ## 처리 설정
            $table->string('default_priority')->default('normal'); // 기본 우선순위
            $table->unsignedBigInteger('default_assignee_id')->nullable(); // 기본 담당자
            $table->integer('expected_resolution_hours')->default(24); // 예상 해결 시간(시간)

            ## 고객 안내
            $table->text('customer_instructions')->nullable(); // 고객 안내 메시지
            $table->json('required_fields')->nullable(); // 필수 입력 필드 설정

            ## 통계
            $table->integer('total_requests')->default(0); // 총 요청 수
            $table->integer('resolved_requests')->default(0); // 해결된 요청 수
            $table->decimal('avg_resolution_hours', 8, 2)->default(0); // 평균 해결 시간

            ## 인덱스
            $table->index('enable');
            $table->index('code');
            $table->index('sort_order');
            $table->index('default_assignee_id');
        });

        // 기본 데이터 삽입
        DB::table('site_support_types')->insert([
            [
                'name' => '기술 지원',
                'code' => 'technical',
                'description' => '시스템 오류, 기능 문의, 사용법 등 기술적인 문제',
                'icon' => 'fe fe-code',
                'color' => '#007bff',
                'sort_order' => 1,
                'default_priority' => 'normal',
                'expected_resolution_hours' => 8,
                'customer_instructions' => '오류 발생 시 스크린샷과 함께 문의해 주세요.',
                'required_fields' => json_encode(['subject', 'content', 'browser_info']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '결제 문의',
                'code' => 'billing',
                'description' => '결제 오류, 환불 요청, 요금제 문의 등',
                'icon' => 'fe fe-credit-card',
                'color' => '#28a745',
                'sort_order' => 2,
                'default_priority' => 'high',
                'expected_resolution_hours' => 4,
                'customer_instructions' => '결제 관련 증빙 자료를 첨부해 주세요.',
                'required_fields' => json_encode(['subject', 'content', 'order_number']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '일반 문의',
                'code' => 'general',
                'description' => '일반적인 문의사항, 제안사항 등',
                'icon' => 'fe fe-help-circle',
                'color' => '#6c757d',
                'sort_order' => 3,
                'default_priority' => 'normal',
                'expected_resolution_hours' => 24,
                'customer_instructions' => '구체적인 문의 내용을 작성해 주세요.',
                'required_fields' => json_encode(['subject', 'content']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '버그 리포트',
                'code' => 'bug_report',
                'description' => '시스템 버그, 오작동 신고',
                'icon' => 'fe fe-alert-triangle',
                'color' => '#dc3545',
                'sort_order' => 4,
                'default_priority' => 'urgent',
                'expected_resolution_hours' => 2,
                'customer_instructions' => '버그 재현 단계와 스크린샷을 첨부해 주세요.',
                'required_fields' => json_encode(['subject', 'content', 'reproduction_steps', 'browser_info']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '계정 지원',
                'code' => 'account',
                'description' => '로그인 문제, 비밀번호 재설정, 계정 관련 문의',
                'icon' => 'fe fe-user',
                'color' => '#fd7e14',
                'sort_order' => 5,
                'default_priority' => 'high',
                'expected_resolution_hours' => 4,
                'customer_instructions' => '본인 확인을 위해 가입 시 사용한 정보를 제공해 주세요.',
                'required_fields' => json_encode(['subject', 'content', 'user_email']),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_support_types');
    }
};