<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Facades\File;

class FooterService
{
    private string $jsonPath;

    public function __construct()
    {
        $this->jsonPath = __DIR__ . '/../../config/footers.json';
    }

    /**
     * Get all footer templates from JSON file
     */
    public function getAllFooters(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        // 새로운 구조에서 template 배열 반환, 없으면 기존 배열 구조 유지
        return $data['template'] ?? $data;
    }

    /**
     * Get footer configuration (copyright, logo, etc.)
     */
    public function getFooterConfig(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [
                'copyright' => '',
                'logo' => ''
            ];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        return [
            'copyright' => $data['copyright'] ?? '',
            'logo' => $data['logo'] ?? ''
        ];
    }

    /**
     * Get complete footer information including config and templates
     */
    public function getFooterInfo(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [
                'config' => [
                    'copyright' => '',
                    'logo' => ''
                ],
                'templates' => []
            ];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        return [
            'config' => [
                'copyright' => $data['copyright'] ?? '',
                'logo' => $data['logo'] ?? ''
            ],
            'templates' => $data['template'] ?? $data
        ];
    }

    /**
     * Get a specific footer by ID (1-indexed)
     */
    public function getFooterById(int $id): ?array
    {
        $footers = $this->getAllFooters();
        $index = $id - 1;

        if (!isset($footers[$index]) || $index < 0) {
            return null;
        }

        $footer = $footers[$index];
        $footer['id'] = $id;

        return $footer;
    }

    /**
     * Check if a footer key already exists (excluding specific index)
     */
    public function isDuplicateKey(string $key, ?int $excludeIndex = null): bool
    {
        $footers = $this->getAllFooters();

        foreach ($footers as $index => $footer) {
            if ($excludeIndex !== null && $index === $excludeIndex) {
                continue;
            }
            if ($footer['footer_key'] === $key) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add a new footer to the JSON file
     */
    public function addFooter(array $data): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();
            $footers = $currentData['template'] ?? [];

            // 새 푸터 데이터 준비
            $newFooter = [
                'footer_key' => $data['footer_key'],
                'name' => $data['name'],
                'description' => $data['description'] ?? '',
                'template' => $data['template'] ?? '',
                'copyright' => isset($data['copyright']),
                'links' => isset($data['links']),
                'social' => isset($data['social']),
            ];

            // footer_links가 있다면 추가
            if (isset($data['footer_links']) && is_array($data['footer_links'])) {
                $newFooter['footer_links'] = $data['footer_links'];
            }

            $footers[] = $newFooter;
            $currentData['template'] = $footers;

            return $this->saveJsonDataPrivate($currentData);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Update an existing footer
     */
    public function updateFooter(int $id, array $data): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();
            $footers = $currentData['template'] ?? [];
            $index = $id - 1;

            if (!isset($footers[$index]) || $index < 0) {
                return false;
            }

            // 푸터 데이터 업데이트
            $footers[$index] = [
                'footer_key' => $data['footer_key'],
                'name' => $data['name'],
                'description' => $data['description'] ?? '',
                'template' => $data['template'] ?? '',
                'copyright' => isset($data['copyright']),
                'links' => isset($data['links']),
                'social' => isset($data['social']),
            ];

            // footer_links가 있다면 추가
            if (isset($data['footer_links']) && is_array($data['footer_links'])) {
                $footers[$index]['footer_links'] = $data['footer_links'];
            }

            $currentData['template'] = $footers;

            return $this->saveJsonDataPrivate($currentData);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Delete a footer by ID
     */
    public function deleteFooter(int $id): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();
            $footers = $currentData['template'] ?? [];
            $index = $id - 1;

            if (!isset($footers[$index]) || $index < 0) {
                return false;
            }

            // 순차배열에서 요소 제거 후 재정렬
            array_splice($footers, $index, 1);
            $currentData['template'] = $footers;

            return $this->saveJsonDataPrivate($currentData);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Update footer configuration (copyright, logo)
     */
    public function updateConfig(array $config): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();

            if (isset($config['copyright'])) {
                $currentData['copyright'] = $config['copyright'];
            }

            if (isset($config['logo'])) {
                $currentData['logo'] = $config['logo'];
            }

            return $this->saveJsonDataPrivate($currentData);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the complete JSON data structure (private method for backward compatibility)
     */
    private function getFullJsonDataPrivate(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [
                'copyright' => '',
                'logo' => '',
                'template' => []
            ];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        // Ensure required structure
        if (!isset($data['template'])) {
            $data = [
                'copyright' => $data['copyright'] ?? '',
                'logo' => $data['logo'] ?? '',
                'template' => is_array($data) && !isset($data['copyright']) ? $data : []
            ];
        }

        return $data;
    }

    /**
     * Get all footers (alias for getAllFooters)
     */
    public function getAll(): array
    {
        return $this->getAllFooters();
    }

    /**
     * Get footer configuration (alias for getFooterConfig)
     */
    public function getConfig(): array
    {
        return $this->getFooterConfig();
    }

    /**
     * Get complete footer information (alias for getFooterInfo)
     */
    public function getInfo(): array
    {
        return $this->getFooterInfo();
    }

    /**
     * Get footer by ID (alias for getFooterById)
     */
    public function getById(int $id): ?array
    {
        return $this->getFooterById($id);
    }

    /**
     * Get footer by key
     */
    public function getByKey(string $key): ?array
    {
        $footers = $this->getAllFooters();

        foreach ($footers as $index => $footer) {
            if ($footer['footer_key'] === $key) {
                $footer['id'] = $index + 1;
                return $footer;
            }
        }

        return null;
    }

    /**
     * Get footer links from the first footer template that has footer_links
     */
    public function getLinks(): array
    {
        $footers = $this->getAllFooters();

        foreach ($footers as $footer) {
            if (isset($footer['footer_links']) && is_array($footer['footer_links'])) {
                return $footer['footer_links'];
            }
        }

        return [];
    }

    /**
     * Get copyright text
     */
    public function getCopyright(): string
    {
        $config = $this->getFooterConfig();
        return $config['copyright'] ?? '';
    }

    /**
     * Get logo
     */
    public function getLogo(): string
    {
        $config = $this->getFooterConfig();
        return $config['logo'] ?? '';
    }

    /**
     * Get company information
     */
    public function getCompany(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        return $data['company'] ?? [];
    }

    /**
     * Get social media links
     */
    public function getSocial(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        return $data['social'] ?? [];
    }

    /**
     * Get menu sections
     */
    public function getMenuSections(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        return $data['menu_sections'] ?? [];
    }

    /**
     * Get specific menu section by key
     */
    public function getMenuSection(string $key): array
    {
        $menuSections = $this->getMenuSections();
        return $menuSections[$key] ?? [];
    }

    /**
     * Add footer (alias for addFooter)
     */
    public function add(array $data): bool
    {
        return $this->addFooter($data);
    }

    /**
     * Update footer (alias for updateFooter)
     */
    public function update(int $id, array $data): bool
    {
        return $this->updateFooter($id, $data);
    }

    /**
     * Delete footer (alias for deleteFooter)
     */
    public function delete(int $id): bool
    {
        return $this->deleteFooter($id);
    }

    /**
     * Get the complete JSON data structure (public method for ConfigController)
     */
    public function getFullJsonData(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [
                'copyright' => '',
                'logo' => '',
                'company' => [],
                'social' => [],
                'menu_sections' => [],
                'template' => []
            ];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        // Ensure required structure
        if (!isset($data['template'])) {
            $data = [
                'copyright' => $data['copyright'] ?? '',
                'logo' => $data['logo'] ?? '',
                'company' => $data['company'] ?? [],
                'social' => $data['social'] ?? [],
                'menu_sections' => $data['menu_sections'] ?? [],
                'template' => is_array($data) && !isset($data['copyright']) ? $data : []
            ];
        }

        return $data;
    }

    /**
     * Save JSON data to file (public method for ConfigController)
     */
    public function saveJsonData(array $data): bool
    {
        try {
            $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            File::put($this->jsonPath, $json);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Save JSON data to file (private method - keeping for backward compatibility)
     */
    private function saveJsonDataPrivate(array $data): bool
    {
        return $this->saveJsonData($data);
    }
}