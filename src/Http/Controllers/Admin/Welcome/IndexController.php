<?php

namespace Jiny\Site\Http\Controllers\Admin\Welcome;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Jiny\Site\Models\SiteWelcome;

/**
 * Welcome CMS 관리 컨트롤러
 *
 * @description
 * 웹사이트 초기 welcome 페이지의 블록들을 관리하는 컨트롤러입니다.
 * 데이터베이스를 통해 블록 구성을 관리하며, 그룹별 관리와 스케줄링 기능을 지원합니다.
 */
class IndexController extends Controller
{
    /**
     * Welcome 블록 관리 페이지 표시
     */
    public function __invoke(Request $request)
    {
        // 현재 선택된 그룹 (기본값: 'default')
        $currentGroup = $request->get('group', 'default');

        // 모든 그룹 목록
        $groups = $this->getAllGroups();

        // 현재 그룹의 블록들
        $blocks = $this->loadBlocks($currentGroup);

        // 그룹 정보
        $groupInfo = $this->getGroupInfo($currentGroup);

        return view('jiny-site::admin.welcome.index', [
            'blocks' => $blocks,
            'groups' => $groups,
            'currentGroup' => $currentGroup,
            'groupInfo' => $groupInfo
        ]);
    }

    /**
     * 모든 그룹 목록 가져오기
     */
    protected function getAllGroups()
    {
        try {
            $groups = SiteWelcome::getAllGroups();

            // 데이터베이스에 그룹이 없으면 기본 그룹 생성
            if ($groups->isEmpty()) {
                $this->createDefaultGroup();
                $groups = SiteWelcome::getAllGroups();
            }

            return $groups->values(); // 인덱스 재정렬
        } catch (\Exception $e) {
            // 데이터베이스 오류 시 JSON 파일에서 로드 (폴백)
            return $this->getGroupsFromJson();
        }
    }

    /**
     * 기본 그룹 생성
     */
    protected function createDefaultGroup()
    {
        try {
            // JSON 파일에서 기본 데이터 로드하여 데이터베이스에 생성
            $jsonData = $this->loadBlocksFromJson();

            if (!empty($jsonData)) {
                foreach ($jsonData as $block) {
                    SiteWelcome::create([
                        'group_name' => 'default',
                        'group_title' => 'Default Group',
                        'group_description' => 'Default welcome blocks',
                        'block_name' => $block['name'] ?? 'Unnamed Block',
                        'view_template' => $block['view'] ?? '',
                        'config' => $block['config'] ?? [],
                        'order' => $block['order'] ?? 0,
                        'is_enabled' => $block['enabled'] ?? true,
                        'is_active' => false,
                        'is_published' => false,
                        'status' => 'draft'
                    ]);
                }
            } else {
                // JSON도 없으면 최소한의 기본 그룹만 생성
                SiteWelcome::create([
                    'group_name' => 'default',
                    'group_title' => 'Default Group',
                    'group_description' => 'Default welcome blocks',
                    'block_name' => 'Welcome Hero',
                    'view_template' => 'jiny-site::www.blocks.hero',
                    'config' => [],
                    'order' => 1,
                    'is_enabled' => true,
                    'is_active' => false,
                    'is_published' => false,
                    'status' => 'draft'
                ]);
            }
        } catch (\Exception $e) {
            // 오류 발생 시 무시 (폴백 처리됨)
        }
    }

    /**
     * 특정 그룹의 블록들 로드
     */
    protected function loadBlocks($groupName)
    {
        try {
            return SiteWelcome::group($groupName)
                ->ordered()
                ->get()
                ->map(function ($block) {
                    return [
                        'id' => $block->id,
                        'name' => $block->block_name,
                        'view' => $block->view_template,
                        'enabled' => $block->is_enabled,
                        'order' => $block->order,
                        'config' => $block->config ?? [],
                        'group_name' => $block->group_name,
                        'deploy_status' => $block->deploy_status,
                        'is_active' => $block->is_active,
                        'deploy_at' => $block->deploy_at?->format('Y-m-d H:i:s'),
                        'status' => $block->status
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            // 데이터베이스 오류 시 JSON 파일에서 로드 (폴백)
            return $this->loadBlocksFromJson();
        }
    }

    /**
     * 그룹 정보 가져오기
     */
    protected function getGroupInfo($groupName)
    {
        try {
            $block = SiteWelcome::group($groupName)->first();

            if (!$block) {
                return [
                    'group_name' => $groupName,
                    'group_title' => ucfirst($groupName) . ' Group',
                    'group_description' => 'Welcome blocks for ' . $groupName . ' group',
                    'is_active' => false,
                    'is_published' => false,
                    'deploy_at' => null,
                    'status' => 'draft',
                    'deploy_status' => '임시저장'
                ];
            }

            return [
                'group_name' => $block->group_name,
                'group_title' => $block->group_title ?: ucfirst($groupName) . ' Group',
                'group_description' => $block->group_description ?: 'Welcome blocks for ' . $groupName . ' group',
                'is_active' => $block->is_active,
                'is_published' => $block->is_published,
                'deploy_at' => $block->deploy_at,
                'status' => $block->status,
                'deploy_status' => $block->deploy_status
            ];
        } catch (\Exception $e) {
            return [
                'group_name' => $groupName,
                'group_title' => ucfirst($groupName) . ' Group',
                'group_description' => 'Welcome blocks for ' . $groupName . ' group',
                'is_active' => false,
                'is_published' => false,
                'deploy_at' => null,
                'status' => 'draft',
                'deploy_status' => '임시저장'
            ];
        }
    }

    /**
     * JSON 파일에서 그룹 목록 가져오기 (폴백)
     */
    protected function getGroupsFromJson()
    {
        $configPath = __DIR__ . '/../../Welcome/Welcome.json';

        if (!File::exists($configPath)) {
            return collect([]);
        }

        try {
            $content = File::get($configPath);
            $data = json_decode($content, true);

            if (!$data || !isset($data['blocks'])) {
                return collect([]);
            }

            // 기본 그룹 객체 생성
            $defaultGroup = (object) [
                'group_name' => 'default',
                'group_title' => 'Default Group',
                'group_description' => 'Default welcome blocks from JSON',
                'is_active' => true,
                'is_published' => true,
                'deploy_at' => null,
                'status' => 'active',
                'deploy_status' => '활성화'
            ];

            return collect([$defaultGroup]);
        } catch (\Exception $e) {
            // 최소한의 기본 그룹 반환
            $defaultGroup = (object) [
                'group_name' => 'default',
                'group_title' => 'Default Group',
                'group_description' => 'Default welcome blocks',
                'is_active' => false,
                'is_published' => false,
                'deploy_at' => null,
                'status' => 'draft',
                'deploy_status' => '임시저장'
            ];

            return collect([$defaultGroup]);
        }
    }

    /**
     * JSON 파일에서 블록들 로드 (폴백)
     */
    protected function loadBlocksFromJson()
    {
        $configPath = __DIR__ . '/../../Welcome/Welcome.json';

        if (!File::exists($configPath)) {
            return [];
        }

        try {
            $content = File::get($configPath);
            $data = json_decode($content, true);

            if (!$data || !isset($data['blocks'])) {
                return [];
            }

            // order 기준으로 정렬
            $blocks = $data['blocks'];
            usort($blocks, function($a, $b) {
                return ($a['order'] ?? 0) - ($b['order'] ?? 0);
            });

            return $blocks;
        } catch (\Exception $e) {
            return [];
        }
    }
}