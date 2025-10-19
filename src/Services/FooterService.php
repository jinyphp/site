<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Collection;

class FooterService
{
    private string $configPath;
    private ?array $footers = null;

    public function __construct()
    {
        $this->configPath = base_path('vendor/jiny/site/config/footers.json');
    }

    /**
     * 모든 footer 데이터를 로드
     */
    private function loadFooters(): array
    {
        if ($this->footers === null) {
            if (!file_exists($this->configPath)) {
                $this->footers = ['template' => []];
            } else {
                $content = file_get_contents($this->configPath);
                $this->footers = json_decode($content, true) ?? ['template' => []];
            }
        }

        return $this->footers;
    }

    /**
     * footers.json 파일에 저장
     */
    private function saveFooters(array $footers): bool
    {
        $json = json_encode($footers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $result = file_put_contents($this->configPath, $json);

        if ($result !== false) {
            $this->footers = $footers; // 캐시 업데이트
            return true;
        }

        return false;
    }

    /**
     * 모든 footer 목록 반환
     */
    public function getAllFooters(): array
    {
        $footers = $this->loadFooters();

        // ID 추가 (인덱스 기반)
        foreach ($footers['template'] as $index => $footer) {
            $footers['template'][$index]['id'] = $index + 1;
        }

        return $footers['template'] ?? [];
    }

    /**
     * 특정 ID의 footer 반환
     */
    public function getFooterById(int $id): ?array
    {
        $footers = $this->getAllFooters();

        // ID는 1부터 시작하므로 인덱스는 ID-1
        $index = $id - 1;

        if (isset($footers[$index])) {
            return $footers[$index];
        }

        return null;
    }

    /**
     * 기본 footer 경로 반환
     */
    public function getDefaultFooterPath(): string
    {
        $footers = $this->loadFooters();

        // 1순위: enable=true, active=true, default=true
        foreach ($footers['template'] as $footer) {
            if (($footer['enable'] ?? true) &&
                ($footer['active'] ?? false) &&
                ($footer['default'] ?? false)) {
                return $footer['path'];
            }
        }

        // 2순위: enable=true, active=true
        foreach ($footers['template'] as $footer) {
            if (($footer['enable'] ?? true) && ($footer['active'] ?? false)) {
                return $footer['path'];
            }
        }

        // 3순위: enable=true
        foreach ($footers['template'] as $footer) {
            if ($footer['enable'] ?? true) {
                return $footer['path'];
            }
        }

        // 4순위: 첫 번째 footer
        if (!empty($footers['template'])) {
            return $footers['template'][0]['path'];
        }

        return 'jiny-site::partials.footers.footer-default';
    }

    /**
     * 활성 footer 반환
     */
    public function getActiveFooter(): ?array
    {
        $footers = $this->loadFooters();

        foreach ($footers['template'] as $index => $footer) {
            if (($footer['enable'] ?? true) && ($footer['active'] ?? false)) {
                $footer['id'] = $index + 1;
                return $footer;
            }
        }

        return null;
    }

    /**
     * footer 경로 중복 체크
     */
    public function isDuplicatePath(string $path, ?int $excludeIndex = null): bool
    {
        $footers = $this->loadFooters();

        foreach ($footers['template'] as $index => $footer) {
            if ($excludeIndex !== null && $index === $excludeIndex) {
                continue;
            }

            if (($footer['path'] ?? $footer['footer_key'] ?? '') === $path) {
                return true;
            }
        }

        return false;
    }

    /**
     * 새 footer 추가
     */
    public function addFooter(array $footerData): bool
    {
        $footers = $this->loadFooters();

        // 기본값 설정
        $footerData = array_merge([
            'enable' => true,
            'active' => false,
            'default' => false,
        ], $footerData);

        $footers['template'][] = $footerData;

        return $this->saveFooters($footers);
    }

    /**
     * footer 업데이트
     */
    public function updateFooter(int $id, array $footerData): bool
    {
        $footers = $this->loadFooters();
        $index = $id - 1; // ID는 1부터 시작

        if (!isset($footers['template'][$index])) {
            return false;
        }

        // 기존 데이터와 병합
        $footers['template'][$index] = array_merge(
            $footers['template'][$index],
            $footerData
        );

        return $this->saveFooters($footers);
    }

    /**
     * footer 삭제
     */
    public function deleteFooter(int $id): bool
    {
        $footers = $this->loadFooters();
        $index = $id - 1; // ID는 1부터 시작

        if (!isset($footers['template'][$index])) {
            return false;
        }

        array_splice($footers['template'], $index, 1);

        return $this->saveFooters($footers);
    }

    /**
     * 기본 footer 설정
     */
    public function setDefaultFooter(int $id): bool
    {
        $footers = $this->loadFooters();
        $index = $id - 1; // ID는 1부터 시작

        if (!isset($footers['template'][$index])) {
            return false;
        }

        // 모든 footer의 default를 false로 설정
        foreach ($footers['template'] as &$footer) {
            $footer['default'] = false;
        }

        // 선택한 footer만 default=true, active=true, enable=true 설정
        $footers['template'][$index]['default'] = true;
        $footers['template'][$index]['active'] = true;
        $footers['template'][$index]['enable'] = true;

        return $this->saveFooters($footers);
    }

    /**
     * 활성 footer 설정
     */
    public function setActiveFooter(int $id): bool
    {
        $footers = $this->loadFooters();
        $index = $id - 1; // ID는 1부터 시작

        if (!isset($footers['template'][$index])) {
            return false;
        }

        // footer가 enable 상태인지 확인
        if (!($footers['template'][$index]['enable'] ?? true)) {
            return false; // 비활성화된 footer는 active로 설정할 수 없음
        }

        // 모든 footer의 active를 false로 설정
        foreach ($footers['template'] as &$footer) {
            $footer['active'] = false;
        }

        // 선택한 footer만 active=true 설정
        $footers['template'][$index]['active'] = true;

        return $this->saveFooters($footers);
    }

    /**
     * footer enable 상태 토글
     */
    public function toggleFooterEnable(int $id): bool
    {
        $footers = $this->loadFooters();
        $index = $id - 1; // ID는 1부터 시작

        if (!isset($footers['template'][$index])) {
            return false;
        }

        $currentEnable = $footers['template'][$index]['enable'] ?? true;
        $footers['template'][$index]['enable'] = !$currentEnable;

        // enable이 false가 되면 active와 default도 false로 설정
        if (!$footers['template'][$index]['enable']) {
            $footers['template'][$index]['active'] = false;
            $footers['template'][$index]['default'] = false;
        }

        return $this->saveFooters($footers);
    }

    /**
     * footer 통계 반환
     */
    public function getFooterStats(): array
    {
        $footers = $this->loadFooters();
        $total = count($footers['template'] ?? []);
        $enabled = 0;
        $active = 0;
        $default = 0;

        foreach ($footers['template'] as $footer) {
            if ($footer['enable'] ?? true) $enabled++;
            if ($footer['active'] ?? false) $active++;
            if ($footer['default'] ?? false) $default++;
        }

        return [
            'total' => $total,
            'enabled' => $enabled,
            'active' => $active,
            'default' => $default,
        ];
    }

    /**
     * 회사 정보 반환
     */
    public function getCompany(): ?array
    {
        $footers = $this->loadFooters();
        return $footers['company'] ?? null;
    }

    /**
     * 저작권 정보 반환
     */
    public function getCopyright(): string
    {
        $footers = $this->loadFooters();
        return $footers['copyright'] ?? '';
    }

    /**
     * 로고 경로 반환
     */
    public function getLogo(): string
    {
        $footers = $this->loadFooters();
        return $footers['logo'] ?? '';
    }

    /**
     * 소셜 미디어 링크 반환
     */
    public function getSocial(): array
    {
        $footers = $this->loadFooters();
        return $footers['social'] ?? [];
    }

    /**
     * 메뉴 섹션 반환
     */
    public function getMenuSections(): array
    {
        $footers = $this->loadFooters();
        return $footers['menu_sections'] ?? [];
    }

    /**
     * 특정 메뉴 섹션 반환
     */
    public function getMenuSection(string $section): ?array
    {
        $menuSections = $this->getMenuSections();
        return $menuSections[$section] ?? null;
    }

    /**
     * 푸터 링크 반환 (기본 푸터의)
     */
    public function getFooterLinks(): array
    {
        $footers = $this->loadFooters();

        // 기본 푸터의 footer_links 찾기
        foreach ($footers['template'] as $footer) {
            if (($footer['default'] ?? false) && isset($footer['footer_links'])) {
                return $footer['footer_links'];
            }
        }

        // 기본 푸터가 없으면 활성 푸터에서 찾기
        foreach ($footers['template'] as $footer) {
            if (($footer['active'] ?? false) && isset($footer['footer_links'])) {
                return $footer['footer_links'];
            }
        }

        return [];
    }

    /**
     * 회사 정보 업데이트
     */
    public function updateCompany(array $companyData): bool
    {
        $footers = $this->loadFooters();
        $footers['company'] = array_merge($footers['company'] ?? [], $companyData);
        return $this->saveFooters($footers);
    }

    /**
     * 소셜 미디어 정보 업데이트
     */
    public function updateSocial(array $socialData): bool
    {
        $footers = $this->loadFooters();
        $footers['social'] = $socialData;
        return $this->saveFooters($footers);
    }

    /**
     * 메뉴 섹션 업데이트
     */
    public function updateMenuSections(array $menuSections): bool
    {
        $footers = $this->loadFooters();
        $footers['menu_sections'] = $menuSections;
        return $this->saveFooters($footers);
    }

    /**
     * 저작권 정보 업데이트
     */
    public function updateCopyright(string $copyright): bool
    {
        $footers = $this->loadFooters();
        $footers['copyright'] = $copyright;
        return $this->saveFooters($footers);
    }

    /**
     * 로고 경로 업데이트
     */
    public function updateLogo(string $logo): bool
    {
        $footers = $this->loadFooters();
        $footers['logo'] = $logo;
        return $this->saveFooters($footers);
    }
}