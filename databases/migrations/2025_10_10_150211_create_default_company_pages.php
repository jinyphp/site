<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Models\SitePage;
use Jiny\Site\Models\SitePageContent;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = now();

        // 기본 회사 페이지 데이터
        $pages = [
            // 회사 소개
            [
                'title' => '회사 소개',
                'slug' => 'about',
                'content' => '우리 회사를 소개합니다.',
                'excerpt' => '우리 회사의 역사와 비전을 알아보세요.',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 1,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '연혁',
                'slug' => 'history',
                'content' => '회사의 발전 과정과 주요 이정표를 소개합니다.',
                'excerpt' => '창립부터 현재까지의 회사 발자취',
                'status' => 'published',
                'sort_order' => 2,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '비전',
                'slug' => 'vision',
                'content' => '우리가 꿈꾸는 미래와 지향하는 가치를 소개합니다.',
                'excerpt' => '회사의 비전과 핵심 가치',
                'status' => 'published',
                'sort_order' => 3,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '미션',
                'slug' => 'mission',
                'content' => '우리의 사명과 목표를 소개합니다.',
                'excerpt' => '회사의 사명과 목표',
                'status' => 'published',
                'sort_order' => 4,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '조직도',
                'slug' => 'organization',
                'content' => '회사의 조직 구조를 소개합니다.',
                'excerpt' => '회사의 조직 구조와 부서 소개',
                'status' => 'published',
                'sort_order' => 5,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'CEO 인사말',
                'slug' => 'ceo-message',
                'content' => 'CEO의 인사말을 전합니다.',
                'excerpt' => 'CEO가 전하는 회사의 철학과 비전',
                'status' => 'published',
                'sort_order' => 6,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '오시는 길',
                'slug' => 'location',
                'content' => '회사 위치와 찾아오는 방법을 안내합니다.',
                'excerpt' => '회사 위치 및 교통 안내',
                'status' => 'published',
                'sort_order' => 7,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 포트폴리오/실적
            [
                'title' => '포트폴리오',
                'slug' => 'portfolio',
                'content' => '우리의 프로젝트와 실적을 소개합니다.',
                'excerpt' => '다양한 프로젝트와 성과',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 10,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '프로젝트 사례',
                'slug' => 'projects',
                'content' => '성공적인 프로젝트 사례들을 소개합니다.',
                'excerpt' => '대표적인 프로젝트 성공 사례',
                'status' => 'published',
                'sort_order' => 11,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '고객 후기',
                'slug' => 'testimonials',
                'content' => '고객들의 생생한 후기를 확인하세요.',
                'excerpt' => '고객들이 직접 전하는 경험담',
                'status' => 'published',
                'sort_order' => 12,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '수상 경력',
                'slug' => 'awards',
                'content' => '회사가 수상한 각종 상과 인증을 소개합니다.',
                'excerpt' => '다양한 수상 내역과 인증',
                'status' => 'published',
                'sort_order' => 13,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // IR 정보
            [
                'title' => 'IR 정보',
                'slug' => 'ir',
                'content' => '투자자를 위한 정보를 제공합니다.',
                'excerpt' => '투자자 관계 및 재무 정보',
                'status' => 'published',
                'sort_order' => 20,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '재무제표',
                'slug' => 'financial-statements',
                'content' => '회사의 재무 현황을 투명하게 공개합니다.',
                'excerpt' => '연간 재무제표 및 감사보고서',
                'status' => 'published',
                'sort_order' => 21,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '주주 정보',
                'slug' => 'shareholders',
                'content' => '주주 구성과 지배구조를 소개합니다.',
                'excerpt' => '주주 현황 및 기업 지배구조',
                'status' => 'published',
                'sort_order' => 22,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 추가 기본 페이지들
            [
                'title' => '서비스',
                'slug' => 'services',
                'content' => '우리가 제공하는 다양한 서비스를 소개합니다.',
                'excerpt' => '전문적이고 차별화된 서비스',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 30,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '채용정보',
                'slug' => 'careers',
                'content' => '함께 성장할 인재를 찾습니다.',
                'excerpt' => '채용 공고 및 복리후생 안내',
                'status' => 'published',
                'sort_order' => 40,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '문의하기',
                'slug' => 'contact',
                'content' => '궁금한 점이 있으시면 언제든 연락주세요.',
                'excerpt' => '연락처 및 문의 방법',
                'status' => 'published',
                'sort_order' => 50,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'content' => '자주 묻는 질문과 답변을 확인하세요.',
                'excerpt' => '고객들이 자주 묻는 질문들',
                'status' => 'published',
                'sort_order' => 51,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '뉴스',
                'slug' => 'news',
                'content' => '회사의 최신 소식을 전합니다.',
                'excerpt' => '회사 뉴스 및 공지사항',
                'status' => 'published',
                'sort_order' => 60,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        // 페이지 데이터 삽입 (updateOrCreate 사용)
        foreach ($pages as $pageData) {
            $page = SitePage::updateOrCreate(
                ['slug' => $pageData['slug']], // 검색 조건 (slug로 찾기)
                $pageData // 업데이트할 데이터
            );

            // 기존 블럭이 없는 경우에만 기본 블럭 생성
            if ($page->contents()->count() === 0) {
                $this->createDefaultBlocks($page->id, $page->slug);
            }
        }
    }

    /**
     * 페이지별 기본 블럭 생성
     */
    private function createDefaultBlocks($pageId, $slug)
    {
        $now = now();
        $blocks = [];

        switch ($slug) {
            case 'about':
                $blocks = [
                    [
                        'page_id' => $pageId,
                        'block_type' => 'text',
                        'title' => '회사 개요',
                        'content' => '저희 회사는 혁신적인 기술과 창의적인 솔루션으로 고객의 성공을 돕는 전문 기업입니다.\n\n설립 이후 지속적인 성장을 통해 업계 선두 기업으로 자리매김하였으며, 고객 만족을 위한 끊임없는 노력을 기울이고 있습니다.',
                        'sort_order' => 1,
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'page_id' => $pageId,
                        'block_type' => 'html',
                        'title' => '핵심 가치',
                        'content' => '<div class="row">
                            <div class="col-md-4 text-center">
                                <h4>혁신</h4>
                                <p>끊임없는 기술 혁신으로 미래를 선도합니다</p>
                            </div>
                            <div class="col-md-4 text-center">
                                <h4>신뢰</h4>
                                <p>고객과의 약속을 지키며 신뢰를 쌓아갑니다</p>
                            </div>
                            <div class="col-md-4 text-center">
                                <h4>성장</h4>
                                <p>직원과 회사가 함께 성장하는 문화를 만듭니다</p>
                            </div>
                        </div>',
                        'sort_order' => 2,
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                ];
                break;

            case 'history':
                $blocks = [
                    [
                        'page_id' => $pageId,
                        'block_type' => 'text',
                        'title' => '주요 연혁',
                        'content' => '2020년 - 회사 설립\n2021년 - 첫 번째 제품 출시\n2022년 - Series A 투자 유치\n2023년 - 해외 시장 진출\n2024년 - 업계 1위 달성',
                        'sort_order' => 1,
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                ];
                break;

            case 'ceo-message':
                $blocks = [
                    [
                        'page_id' => $pageId,
                        'block_type' => 'html',
                        'title' => 'CEO 인사말',
                        'content' => '<div class="row">
                            <div class="col-md-3 text-center">
                                <img src="/images/ceo.jpg" alt="CEO" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                                <h5>김대표</h5>
                                <p class="text-muted">대표이사</p>
                            </div>
                            <div class="col-md-9">
                                <p class="lead">안녕하세요. 저희 회사를 찾아주신 여러분께 진심으로 감사드립니다.</p>
                                <p>저희는 항상 고객의 입장에서 생각하며, 최고의 서비스를 제공하기 위해 끊임없이 노력하고 있습니다. 혁신적인 기술과 창의적인 아이디어로 고객의 성공을 돕는 것이 저희의 사명입니다.</p>
                                <p>앞으로도 변함없는 신뢰와 성원을 부탁드리며, 더 나은 미래를 함께 만들어 나가겠습니다.</p>
                                <p><strong>감사합니다.</strong></p>
                            </div>
                        </div>',
                        'sort_order' => 1,
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                ];
                break;

            case 'location':
                $blocks = [
                    [
                        'page_id' => $pageId,
                        'block_type' => 'text',
                        'title' => '회사 위치',
                        'content' => '주소: 서울특별시 강남구 테헤란로 123\n전화: 02-1234-5678\n팩스: 02-1234-5679\n이메일: info@company.com',
                        'sort_order' => 1,
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'page_id' => $pageId,
                        'block_type' => 'html',
                        'title' => '지도',
                        'content' => '<div class="map-container">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3165.4!2d127.0286!3d37.4979!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzfCsDI5JzUyLjQiTiAxMjfCsDA0JzE5LjAiRQ!5e0!3m2!1sko!2skr!4v1234567890" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>',
                        'sort_order' => 2,
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                ];
                break;

            case 'projects':
                $blocks = [
                    [
                        'page_id' => $pageId,
                        'block_type' => 'html',
                        'title' => '주요 프로젝트',
                        'content' => '<div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <img src="/images/project1.jpg" class="card-img-top" alt="프로젝트 1">
                                    <div class="card-body">
                                        <h5 class="card-title">E-커머스 플랫폼 구축</h5>
                                        <p class="card-text">대형 유통업체의 온라인 쇼핑몰 구축 프로젝트</p>
                                        <small class="text-muted">2024년 3월 완료</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <img src="/images/project2.jpg" class="card-img-top" alt="프로젝트 2">
                                    <div class="card-body">
                                        <h5 class="card-title">AI 추천 시스템</h5>
                                        <p class="card-text">머신러닝 기반 개인화 추천 엔진 개발</p>
                                        <small class="text-muted">2024년 1월 완료</small>
                                    </div>
                                </div>
                            </div>
                        </div>',
                        'sort_order' => 1,
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                ];
                break;

            default:
                // 기본 블럭 하나 생성
                $blocks = [
                    [
                        'page_id' => $pageId,
                        'block_type' => 'text',
                        'title' => '콘텐츠',
                        'content' => '이 페이지의 내용을 작성해 주세요.',
                        'sort_order' => 1,
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                ];
                break;
        }

        // 블럭 데이터 삽입
        foreach ($blocks as $blockData) {
            SitePageContent::create($blockData);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 생성된 페이지들 삭제 (관련된 블럭들도 자동으로 삭제됨 - cascade)
        SitePage::whereIn('slug', [
            'about', 'history', 'vision', 'mission', 'organization', 'ceo-message', 'location',
            'portfolio', 'projects', 'testimonials', 'awards',
            'ir', 'financial-statements', 'shareholders',
            'services', 'careers', 'contact', 'faq', 'news'
        ])->delete();
    }
};
