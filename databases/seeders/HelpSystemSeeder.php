<?php

namespace Jiny\Site\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HelpSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Help 카테고리 생성
        $helpCategories = [
            [
                'code' => 'getting-started',
                'title' => '시작하기',
                'content' => '서비스 이용을 위한 기본 가이드입니다.',
                'icon' => 'fe fe-play-circle',
                'image' => null,
                'pos' => 1,
                'enable' => true,
                'manager' => 'system',
                'like' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'account',
                'title' => '계정 관리',
                'content' => '계정 생성, 수정, 삭제에 관한 도움말입니다.',
                'icon' => 'fe fe-user',
                'image' => null,
                'pos' => 2,
                'enable' => true,
                'manager' => 'system',
                'like' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'features',
                'title' => '기능 가이드',
                'content' => '주요 기능 사용법에 대한 상세 가이드입니다.',
                'icon' => 'fe fe-settings',
                'image' => null,
                'pos' => 3,
                'enable' => true,
                'manager' => 'system',
                'like' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'troubleshooting',
                'title' => '문제 해결',
                'content' => '자주 발생하는 문제와 해결 방법입니다.',
                'icon' => 'fe fe-tool',
                'image' => null,
                'pos' => 4,
                'enable' => true,
                'manager' => 'system',
                'like' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('site_help_cate')->insert($helpCategories);

        // Help 문서 생성
        $helpDocs = [
            [
                'title' => '서비스 가입하기',
                'content' => '<h2>서비스 가입 방법</h2><p>다음 단계를 따라 쉽게 가입하실 수 있습니다:</p><ol><li>회원가입 페이지로 이동</li><li>필수 정보 입력</li><li>이메일 인증</li><li>가입 완료</li></ol><p>가입 과정에서 문제가 발생하면 고객센터로 문의하세요.</p>',
                'category' => 'getting-started',
                'order' => 1,
                'enable' => true,
                'views' => 150,
                'created_at' => $now->copy()->subDays(10),
                'updated_at' => $now->copy()->subDays(10),
            ],
            [
                'title' => '프로필 수정하기',
                'content' => '<h2>프로필 정보 수정</h2><p>개인정보는 마이페이지에서 수정할 수 있습니다:</p><ul><li>마이페이지 접속</li><li>프로필 수정 클릭</li><li>변경할 정보 입력</li><li>저장하기</li></ul><p><strong>주의:</strong> 이메일 변경 시 재인증이 필요합니다.</p>',
                'category' => 'account',
                'order' => 1,
                'enable' => true,
                'views' => 89,
                'created_at' => $now->copy()->subDays(8),
                'updated_at' => $now->copy()->subDays(5),
            ],
            [
                'title' => '비밀번호 재설정',
                'content' => '<h2>비밀번호를 잊으셨나요?</h2><p>비밀번호 재설정 방법:</p><ol><li>로그인 페이지의 "비밀번호 찾기" 클릭</li><li>등록된 이메일 주소 입력</li><li>이메일로 전송된 링크 클릭</li><li>새 비밀번호 설정</li></ol><p>보안을 위해 강력한 비밀번호를 사용하세요.</p>',
                'category' => 'account',
                'order' => 2,
                'enable' => true,
                'views' => 234,
                'created_at' => $now->copy()->subDays(7),
                'updated_at' => $now->copy()->subDays(3),
            ],
            [
                'title' => '대시보드 사용법',
                'content' => '<h2>대시보드 활용하기</h2><p>대시보드에서 다음과 같은 정보를 확인할 수 있습니다:</p><ul><li>최근 활동 내역</li><li>주요 통계</li><li>빠른 작업 메뉴</li><li>알림 및 공지사항</li></ul><p>각 위젯을 클릭하면 상세 정보를 확인할 수 있습니다.</p>',
                'category' => 'features',
                'order' => 1,
                'enable' => true,
                'views' => 67,
                'created_at' => $now->copy()->subDays(6),
                'updated_at' => $now->copy()->subDays(2),
            ],
            [
                'title' => '파일 업로드 문제',
                'content' => '<h2>파일 업로드 시 오류 해결</h2><p>파일 업로드가 되지 않을 때:</p><ol><li>파일 크기 확인 (최대 10MB)</li><li>지원 파일 형식 확인</li><li>브라우저 새로고침</li><li>다른 브라우저에서 시도</li></ol><p>계속 문제가 발생하면 고객센터로 연락하세요.</p>',
                'category' => 'troubleshooting',
                'order' => 1,
                'enable' => true,
                'views' => 45,
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(1),
            ],
            [
                'title' => '로그인 문제 해결',
                'content' => '<h2>로그인이 안 될 때</h2><p>로그인 문제 해결 방법:</p><ul><li>아이디와 비밀번호 재확인</li><li>Caps Lock 상태 확인</li><li>브라우저 쿠키 삭제</li><li>다른 기기에서 시도</li></ul><p>계정이 잠긴 경우 고객센터에 문의하세요.</p>',
                'category' => 'troubleshooting',
                'order' => 2,
                'enable' => true,
                'views' => 178,
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subHours(12),
            ],
        ];

        DB::table('site_help')->insert($helpDocs);

        // FAQ 카테고리 생성
        $faqCategories = [
            [
                'code' => 'general',
                'title' => '일반',
                'content' => '서비스 이용에 관한 일반적인 질문입니다.',
                'icon' => 'fe fe-help-circle',
                'image' => null,
                'pos' => 1,
                'enable' => true,
                'manager' => 'system',
                'like' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'billing',
                'title' => '결제/환불',
                'content' => '결제 및 환불에 관한 질문입니다.',
                'icon' => 'fe fe-credit-card',
                'image' => null,
                'pos' => 2,
                'enable' => true,
                'manager' => 'system',
                'like' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'technical',
                'title' => '기술적 문제',
                'content' => '기술적인 문제에 대한 질문입니다.',
                'icon' => 'fe fe-settings',
                'image' => null,
                'pos' => 3,
                'enable' => true,
                'manager' => 'system',
                'like' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('site_faq_cate')->insert($faqCategories);

        // FAQ 생성
        $faqs = [
            [
                'question' => '서비스 이용에 비용이 발생하나요?',
                'answer' => '기본 서비스는 무료로 이용하실 수 있습니다. 프리미엄 기능을 원하시는 경우에만 별도 요금이 발생합니다.',
                'cate' => 'general',
                'pos' => 1,
                'enable' => true,
                'manager' => 'system',
                'like' => 25,
                'created_at' => $now->copy()->subDays(9),
                'updated_at' => $now->copy()->subDays(9),
            ],
            [
                'question' => '회원 탈퇴는 어떻게 하나요?',
                'answer' => '마이페이지 > 계정 설정 > 회원 탈퇴에서 탈퇴 신청이 가능합니다. 탈퇴 시 모든 데이터가 삭제되니 신중하게 결정해 주세요.',
                'cate' => 'general',
                'pos' => 2,
                'enable' => true,
                'manager' => 'system',
                'like' => 18,
                'created_at' => $now->copy()->subDays(8),
                'updated_at' => $now->copy()->subDays(6),
            ],
            [
                'question' => '결제 후 환불이 가능한가요?',
                'answer' => '서비스 이용 전이라면 100% 환불이 가능합니다. 이용 후에는 이용 정책에 따라 부분 환불이 가능할 수 있습니다.',
                'cate' => 'billing',
                'pos' => 1,
                'enable' => true,
                'manager' => 'system',
                'like' => 32,
                'created_at' => $now->copy()->subDays(7),
                'updated_at' => $now->copy()->subDays(4),
            ],
            [
                'question' => '어떤 결제 방법을 지원하나요?',
                'answer' => '신용카드, 계좌이체, 가상계좌, 휴대폰 결제를 지원합니다. 법인 고객의 경우 세금계산서 발행도 가능합니다.',
                'cate' => 'billing',
                'pos' => 2,
                'enable' => true,
                'manager' => 'system',
                'like' => 15,
                'created_at' => $now->copy()->subDays(6),
                'updated_at' => $now->copy()->subDays(3),
            ],
            [
                'question' => '모바일에서도 이용할 수 있나요?',
                'answer' => '네, 반응형 웹으로 제작되어 모바일 브라우저에서도 최적화된 환경으로 이용하실 수 있습니다.',
                'cate' => 'technical',
                'pos' => 1,
                'enable' => true,
                'manager' => 'system',
                'like' => 42,
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(2),
            ],
        ];

        DB::table('site_faq')->insert($faqs);

        // Contact 타입 생성
        $contactTypes = [
            [
                'code' => 'general',
                'title' => '일반 문의',
                'description' => '서비스 이용에 관한 일반적인 문의사항',
                'pos' => 1,
                'enable' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'technical',
                'title' => '기술 지원',
                'description' => '기술적인 문제나 오류 신고',
                'pos' => 2,
                'enable' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'billing',
                'title' => '결제/환불',
                'description' => '결제, 환불, 요금에 관한 문의',
                'pos' => 3,
                'enable' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'business',
                'title' => '사업 문의',
                'description' => '파트너십, B2B 제휴 등 사업 관련 문의',
                'pos' => 4,
                'enable' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('site_contact_type')->insert($contactTypes);

        // 샘플 Contact 생성
        $contacts = [
            [
                'name' => '김철수',
                'email' => 'kim@example.com',
                'phone' => '010-1234-5678',
                'subject' => '서비스 이용 방법 문의',
                'message' => '안녕하세요. 서비스 이용이 처음인데 어떻게 시작하면 좋을지 궁금합니다.',
                'type' => 'general',
                'status' => 'replied',
                'read_at' => $now->copy()->subDays(2),
                'reply' => '안녕하세요. 도움말 페이지의 "시작하기" 섹션을 참고해 주세요. 추가 문의사항이 있으시면 언제든 연락 주세요.',
                'replied_at' => $now->copy()->subDays(1),
                'replied_by' => 'admin@example.com',
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(1),
            ],
            [
                'name' => '이영희',
                'email' => 'lee@example.com',
                'phone' => '010-2345-6789',
                'subject' => '로그인 오류 신고',
                'message' => '로그인을 시도하면 계속 오류가 발생합니다. 확인 부탁드립니다.',
                'type' => 'technical',
                'status' => 'pending',
                'read_at' => $now->copy()->subHours(6),
                'reply' => null,
                'replied_at' => null,
                'replied_by' => null,
                'created_at' => $now->copy()->subDays(1),
                'updated_at' => $now->copy()->subHours(6),
            ],
            [
                'name' => '박민수',
                'email' => 'park@example.com',
                'phone' => '010-3456-7890',
                'subject' => '환불 신청',
                'message' => '어제 결제한 프리미엄 서비스 환불을 신청합니다.',
                'type' => 'billing',
                'status' => 'closed',
                'read_at' => $now->copy()->subHours(12),
                'reply' => '환불 처리가 완료되었습니다. 3-5 영업일 내에 계좌로 입금됩니다.',
                'replied_at' => $now->copy()->subHours(8),
                'replied_by' => 'admin@example.com',
                'created_at' => $now->copy()->subHours(18),
                'updated_at' => $now->copy()->subHours(8),
            ],
        ];

        DB::table('site_contact')->insert($contacts);
    }
}