<?php

namespace Jiny\Site\Database\Seeders;

use Illuminate\Database\Seeder;
use Jiny\Site\Models\SiteWelcome;
use Illuminate\Support\Facades\DB;

/**
 * Site Welcome Blocks Seeder
 *
 * @description
 * index02~index08 파일의 블록들을 각각의 그룹으로 추가합니다.
 * 각 그룹은 다른 테마와 용도를 가지고 있습니다.
 */
class SiteWelcomeBlocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 기존 데이터 삭제 (선택사항)
        // SiteWelcome::truncate();

        $this->createGroup2Blocks(); // Academy
        $this->createGroup3Blocks(); // Abroad
        $this->createGroup4Blocks(); // Courses
        $this->createGroup5Blocks(); // Education
        $this->createGroup6Blocks(); // Job
        $this->createGroup7Blocks(); // SASS
        $this->createGroup8Blocks(); // Request Access

        $this->command->info('Welcome blocks seeded successfully!');
    }

    /**
     * Group2 - Academy Theme Blocks
     */
    protected function createGroup2Blocks(): void
    {
        $blocks = [
            [
                'block_name' => 'Academy Hero Main',
                'view_template' => 'jiny-site::www.blocks.hero02_main',
                'order' => 1,
            ],
            [
                'block_name' => 'Academy Courses',
                'view_template' => 'jiny-site::www.blocks.hero02_courses',
                'order' => 2,
            ],
            [
                'block_name' => 'Academy Content',
                'view_template' => 'jiny-site::www.blocks.hero02_content',
                'order' => 3,
            ],
            [
                'block_name' => 'Academy Testimonials',
                'view_template' => 'jiny-site::www.blocks.hero02_testimonials',
                'order' => 4,
            ],
            [
                'block_name' => 'Academy Call to Action',
                'view_template' => 'jiny-site::www.blocks.hero02_cta',
                'order' => 5,
            ],
        ];

        $this->insertGroupBlocks('group2', 'Academy Theme', 'Bootstrap 5 Academy template blocks', $blocks);
    }

    /**
     * Group3 - Abroad Theme Blocks
     */
    protected function createGroup3Blocks(): void
    {
        $blocks = [
            [
                'block_name' => 'Abroad Hero',
                'view_template' => 'jiny-site::www.blocks.hero03_hero',
                'order' => 1,
            ],
            [
                'block_name' => 'Abroad Features',
                'view_template' => 'jiny-site::www.blocks.hero03_features',
                'order' => 2,
            ],
            [
                'block_name' => 'Abroad Courses',
                'view_template' => 'jiny-site::www.blocks.hero03_courses',
                'order' => 3,
            ],
            [
                'block_name' => 'Abroad Benefits',
                'view_template' => 'jiny-site::www.blocks.hero03_benefits',
                'order' => 4,
            ],
            [
                'block_name' => 'Abroad Testimonials',
                'view_template' => 'jiny-site::www.blocks.hero03_testimonials',
                'order' => 5,
            ],
            [
                'block_name' => 'Abroad Statistics',
                'view_template' => 'jiny-site::www.blocks.hero03_stats',
                'order' => 6,
            ],
            [
                'block_name' => 'Abroad Call to Action',
                'view_template' => 'jiny-site::www.blocks.hero03_cta',
                'order' => 7,
            ],
        ];

        $this->insertGroupBlocks('group3', 'Abroad Theme', 'Landing page for abroad education programs', $blocks);
    }

    /**
     * Group4 - Courses Theme Blocks
     */
    protected function createGroup4Blocks(): void
    {
        $blocks = [
            [
                'block_name' => 'Courses Hero',
                'view_template' => 'jiny-site::www.blocks.hero04_hero',
                'order' => 1,
            ],
            [
                'block_name' => 'Courses Features',
                'view_template' => 'jiny-site::www.blocks.hero04_features',
                'order' => 2,
            ],
            [
                'block_name' => 'Courses Catalog',
                'view_template' => 'jiny-site::www.blocks.hero04_courses',
                'order' => 3,
            ],
            [
                'block_name' => 'Courses Testimonials',
                'view_template' => 'jiny-site::www.blocks.hero04_testimonials',
                'order' => 4,
            ],
            [
                'block_name' => 'Course Instructors',
                'view_template' => 'jiny-site::www.blocks.hero04_instructors',
                'order' => 5,
            ],
            [
                'block_name' => 'Courses Call to Action',
                'view_template' => 'jiny-site::www.blocks.hero04_cta',
                'order' => 6,
            ],
        ];

        $this->insertGroupBlocks('group4', 'Courses Theme', 'Landing page focused on course offerings', $blocks);
    }

    /**
     * Group5 - Education Theme Blocks
     */
    protected function createGroup5Blocks(): void
    {
        $blocks = [
            [
                'block_name' => 'Education Hero',
                'view_template' => 'jiny-site::www.blocks.hero05_hero',
                'order' => 1,
            ],
            [
                'block_name' => 'Education Features',
                'view_template' => 'jiny-site::www.blocks.hero05_features',
                'order' => 2,
            ],
            [
                'block_name' => 'Education Courses',
                'view_template' => 'jiny-site::www.blocks.hero05_courses',
                'order' => 3,
            ],
            [
                'block_name' => 'Education Numbers',
                'view_template' => 'jiny-site::www.blocks.hero05_numbers',
                'order' => 4,
            ],
            [
                'block_name' => 'Education Testimonials',
                'view_template' => 'jiny-site::www.blocks.hero05_testimonials',
                'order' => 5,
            ],
            [
                'block_name' => 'Education Call to Action',
                'view_template' => 'jiny-site::www.blocks.hero05_cta',
                'order' => 6,
            ],
        ];

        $this->insertGroupBlocks('group5', 'Education Theme', 'General education platform layout', $blocks);
    }

    /**
     * Group6 - Job Theme Blocks
     */
    protected function createGroup6Blocks(): void
    {
        $blocks = [
            [
                'block_name' => 'Job Hero',
                'view_template' => 'jiny-site::www.blocks.hero06_hero',
                'order' => 1,
            ],
            [
                'block_name' => 'Job Partner Brands',
                'view_template' => 'jiny-site::www.blocks.hero06_brands',
                'order' => 2,
            ],
            [
                'block_name' => 'Job Listings',
                'view_template' => 'jiny-site::www.blocks.hero06_jobs',
                'order' => 3,
            ],
            [
                'block_name' => 'Job Testimonials',
                'view_template' => 'jiny-site::www.blocks.hero06_testimonials',
                'order' => 4,
            ],
            [
                'block_name' => 'Job Companies',
                'view_template' => 'jiny-site::www.blocks.hero06_companies',
                'order' => 5,
            ],
            [
                'block_name' => 'Job Features',
                'view_template' => 'jiny-site::www.blocks.hero06_features',
                'order' => 6,
            ],
            [
                'block_name' => 'Job Call to Action',
                'view_template' => 'jiny-site::www.blocks.hero06_cta',
                'order' => 7,
            ],
        ];

        $this->insertGroupBlocks('group6', 'Job Theme', 'Job portal and career platform layout', $blocks);
    }

    /**
     * Group7 - SASS Theme Blocks
     */
    protected function createGroup7Blocks(): void
    {
        $blocks = [
            [
                'block_name' => 'SASS Hero',
                'view_template' => 'jiny-site::www.blocks.hero07_hero',
                'order' => 1,
            ],
            [
                'block_name' => 'SASS Features',
                'view_template' => 'jiny-site::www.blocks.hero07_features',
                'order' => 2,
            ],
            [
                'block_name' => 'SASS How It Works',
                'view_template' => 'jiny-site::www.blocks.hero07_how',
                'order' => 3,
            ],
            [
                'block_name' => 'SASS Pricing',
                'view_template' => 'jiny-site::www.blocks.hero07_pricing',
                'order' => 4,
            ],
            [
                'block_name' => 'SASS Testimonials',
                'view_template' => 'jiny-site::www.blocks.hero07_testimonials',
                'order' => 5,
            ],
            [
                'block_name' => 'SASS Call to Action',
                'view_template' => 'jiny-site::www.blocks.hero07_cta',
                'order' => 6,
            ],
        ];

        $this->insertGroupBlocks('group7', 'SASS Theme', 'Software as a Service landing page', $blocks);
    }

    /**
     * Group8 - Request Access Theme Blocks
     */
    protected function createGroup8Blocks(): void
    {
        $blocks = [
            [
                'block_name' => 'Request Access Hero',
                'view_template' => 'jiny-site::www.blocks.hero08_hero',
                'order' => 1,
            ],
            [
                'block_name' => 'Request Access Form',
                'view_template' => 'jiny-site::www.blocks.hero08_form',
                'order' => 2,
            ],
            [
                'block_name' => 'Request Access Features',
                'view_template' => 'jiny-site::www.blocks.hero08_features',
                'order' => 3,
            ],
            [
                'block_name' => 'Request Access Testimonials',
                'view_template' => 'jiny-site::www.blocks.hero08_testimonials',
                'order' => 4,
            ],
            [
                'block_name' => 'Request Access Call to Action',
                'view_template' => 'jiny-site::www.blocks.hero08_cta',
                'order' => 5,
            ],
        ];

        $this->insertGroupBlocks('group8', 'Request Access Theme', 'Early access and beta signup page', $blocks);
    }

    /**
     * Insert blocks for a specific group
     */
    protected function insertGroupBlocks(string $groupName, string $groupTitle, string $groupDescription, array $blocks): void
    {
        foreach ($blocks as $block) {
            SiteWelcome::create([
                'group_name' => $groupName,
                'group_title' => $groupTitle,
                'group_description' => $groupDescription,
                'block_name' => $block['block_name'],
                'view_template' => $block['view_template'],
                'config' => [],
                'order' => $block['order'],
                'is_enabled' => true,
                'deploy_at' => null,
                'is_active' => false, // 기본적으로 비활성
                'is_published' => false, // 기본적으로 미배포
                'status' => 'draft',
                'meta' => [
                    'theme' => str_replace('group', '', $groupName),
                    'created_by_seeder' => true,
                    'seeded_at' => now()->toISOString()
                ]
            ]);
        }

        $this->command->info("Created {$groupName} ({$groupTitle}) with " . count($blocks) . " blocks");
    }
}