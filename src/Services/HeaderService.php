<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Facades\File;

class HeaderService
{
    private string $jsonPath;

    public function __construct()
    {
        $this->jsonPath = __DIR__ . '/../../config/headers.json';
    }

    /**
     * Get all header templates from JSON file
     */
    public function getAllHeaders(): array
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
     * Get header configuration (logo, brand_name, etc.)
     */
    public function getHeaderConfig(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [
                'logo' => '',
                'brand_name' => '',
                'brand_tagline' => ''
            ];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        return [
            'logo' => $data['logo'] ?? '',
            'brand_name' => $data['brand_name'] ?? '',
            'brand_tagline' => $data['brand_tagline'] ?? ''
        ];
    }

    /**
     * Get complete header information including config and templates
     */
    public function getHeaderInfo(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [
                'config' => [
                    'logo' => '',
                    'brand_name' => '',
                    'brand_tagline' => ''
                ],
                'templates' => []
            ];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        return [
            'config' => [
                'logo' => $data['logo'] ?? '',
                'brand_name' => $data['brand_name'] ?? '',
                'brand_tagline' => $data['brand_tagline'] ?? ''
            ],
            'templates' => $data['template'] ?? $data
        ];
    }

    /**
     * Get a specific header by ID (1-indexed)
     */
    public function getHeaderById(int $id): ?array
    {
        $headers = $this->getAllHeaders();
        $index = $id - 1;

        if (!isset($headers[$index]) || $index < 0) {
            return null;
        }

        $header = $headers[$index];
        $header['id'] = $id;

        return $header;
    }

    /**
     * Check if a header key already exists (excluding specific index)
     */
    public function isDuplicateKey(string $key, ?int $excludeIndex = null): bool
    {
        $headers = $this->getAllHeaders();

        foreach ($headers as $index => $header) {
            if ($excludeIndex !== null && $index === $excludeIndex) {
                continue;
            }
            if ($header['header_key'] === $key) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add a new header to the JSON file
     */
    public function addHeader(array $data): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();
            $headers = $currentData['template'] ?? [];

            // 새 헤더 데이터 준비
            $newHeader = [
                'header_key' => $data['header_key'],
                'name' => $data['name'],
                'description' => $data['description'] ?? '',
                'template' => $data['template'] ?? '',
                'navbar' => isset($data['navbar']),
                'logo' => isset($data['logo']),
                'search' => isset($data['search']),
            ];

            $headers[] = $newHeader;
            $currentData['template'] = $headers;

            return $this->saveJsonDataPrivate($currentData);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Update an existing header
     */
    public function updateHeader(int $id, array $data): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();
            $headers = $currentData['template'] ?? [];
            $index = $id - 1;

            if (!isset($headers[$index]) || $index < 0) {
                return false;
            }

            // 헤더 데이터 업데이트
            $headers[$index] = [
                'header_key' => $data['header_key'],
                'name' => $data['name'],
                'description' => $data['description'] ?? '',
                'template' => $data['template'] ?? '',
                'navbar' => isset($data['navbar']),
                'logo' => isset($data['logo']),
                'search' => isset($data['search']),
            ];

            $currentData['template'] = $headers;

            return $this->saveJsonDataPrivate($currentData);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Delete a header by ID
     */
    public function deleteHeader(int $id): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();
            $headers = $currentData['template'] ?? [];
            $index = $id - 1;

            if (!isset($headers[$index]) || $index < 0) {
                return false;
            }

            // 순차배열에서 요소 제거 후 재정렬
            array_splice($headers, $index, 1);
            $currentData['template'] = $headers;

            return $this->saveJsonDataPrivate($currentData);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Update header configuration (logo, brand_name, brand_tagline)
     */
    public function updateConfig(array $config): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();

            if (isset($config['logo'])) {
                $currentData['logo'] = $config['logo'];
            }

            if (isset($config['brand_name'])) {
                $currentData['brand_name'] = $config['brand_name'];
            }

            if (isset($config['brand_tagline'])) {
                $currentData['brand_tagline'] = $config['brand_tagline'];
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
                'logo' => '',
                'brand_name' => '',
                'brand_tagline' => '',
                'navigation' => [],
                'settings' => [],
                'template' => []
            ];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        // Ensure required structure
        if (!isset($data['template'])) {
            $data = [
                'logo' => $data['logo'] ?? '',
                'brand_name' => $data['brand_name'] ?? '',
                'brand_tagline' => $data['brand_tagline'] ?? '',
                'navigation' => $data['navigation'] ?? [],
                'settings' => $data['settings'] ?? [],
                'template' => is_array($data) && !isset($data['logo']) ? $data : []
            ];
        }

        return $data;
    }

    /**
     * Get all headers (alias for getAllHeaders)
     */
    public function getAll(): array
    {
        return $this->getAllHeaders();
    }

    /**
     * Get header configuration (alias for getHeaderConfig)
     */
    public function getConfig(): array
    {
        return $this->getHeaderConfig();
    }

    /**
     * Get complete header information (alias for getHeaderInfo)
     */
    public function getInfo(): array
    {
        return $this->getHeaderInfo();
    }

    /**
     * Get header by ID (alias for getHeaderById)
     */
    public function getById(int $id): ?array
    {
        return $this->getHeaderById($id);
    }

    /**
     * Get header by key
     */
    public function getByKey(string $key): ?array
    {
        $headers = $this->getAllHeaders();

        foreach ($headers as $index => $header) {
            if ($header['header_key'] === $key) {
                $header['id'] = $index + 1;
                return $header;
            }
        }

        return null;
    }

    /**
     * Get logo
     */
    public function getLogo(): string
    {
        $config = $this->getHeaderConfig();
        return $config['logo'] ?? '';
    }

    /**
     * Get brand name
     */
    public function getBrandName(): string
    {
        $config = $this->getHeaderConfig();
        return $config['brand_name'] ?? '';
    }

    /**
     * Get brand tagline
     */
    public function getBrandTagline(): string
    {
        $config = $this->getHeaderConfig();
        return $config['brand_tagline'] ?? '';
    }

    /**
     * Get navigation information
     */
    public function getNavigation(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        return $data['navigation'] ?? [];
    }

    /**
     * Get primary navigation
     */
    public function getPrimaryNavigation(): array
    {
        $navigation = $this->getNavigation();
        return $navigation['primary'] ?? [];
    }

    /**
     * Get secondary navigation
     */
    public function getSecondaryNavigation(): array
    {
        $navigation = $this->getNavigation();
        return $navigation['secondary'] ?? [];
    }

    /**
     * Get header settings
     */
    public function getSettings(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        return $data['settings'] ?? [];
    }

    /**
     * Add header (alias for addHeader)
     */
    public function add(array $data): bool
    {
        return $this->addHeader($data);
    }

    /**
     * Update header (alias for updateHeader)
     */
    public function update(int $id, array $data): bool
    {
        return $this->updateHeader($id, $data);
    }

    /**
     * Delete header (alias for deleteHeader)
     */
    public function delete(int $id): bool
    {
        return $this->deleteHeader($id);
    }

    /**
     * Get the complete JSON data structure (public method for ConfigController)
     */
    public function getFullJsonData(): array
    {
        if (!File::exists($this->jsonPath)) {
            return [
                'logo' => '',
                'brand_name' => '',
                'brand_tagline' => '',
                'navigation' => [],
                'settings' => [],
                'template' => []
            ];
        }

        $json = File::get($this->jsonPath);
        $data = json_decode($json, true) ?? [];

        // Ensure required structure
        if (!isset($data['template'])) {
            $data = [
                'logo' => $data['logo'] ?? '',
                'brand_name' => $data['brand_name'] ?? '',
                'brand_tagline' => $data['brand_tagline'] ?? '',
                'navigation' => $data['navigation'] ?? [],
                'settings' => $data['settings'] ?? [],
                'template' => is_array($data) && !isset($data['logo']) ? $data : []
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