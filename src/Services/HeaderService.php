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
     * Get only enabled headers
     */
    public function getEnabledHeaders(): array
    {
        $headers = $this->getAllHeaders();

        return array_filter($headers, function($header) {
            return isset($header['enable']) ? $header['enable'] : true;
        });
    }

    /**
     * Get only active headers
     */
    public function getActiveHeaders(): array
    {
        $headers = $this->getAllHeaders();

        return array_filter($headers, function($header) {
            // active와 enable 모두 true여야 함
            $isEnabled = isset($header['enable']) ? $header['enable'] : true;
            $isActive = isset($header['active']) ? $header['active'] : false;
            return $isEnabled && $isActive;
        });
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
     * Check if a header path already exists (excluding specific index)
     */
    public function isDuplicatePath(string $path, ?int $excludeIndex = null): bool
    {
        $headers = $this->getAllHeaders();

        foreach ($headers as $index => $header) {
            if ($excludeIndex !== null && $index === $excludeIndex) {
                continue;
            }
            if ($header['path'] === $path) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a header key already exists (excluding specific index)
     * @deprecated Use isDuplicatePath instead
     */
    public function isDuplicateKey(string $key, ?int $excludeIndex = null): bool
    {
        return $this->isDuplicatePath($key, $excludeIndex);
    }

    /**
     * Add a new header to the JSON file
     */
    public function addHeader(array $data): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();
            $headers = $currentData['template'] ?? [];

            // 새 헤더 데이터 준비 (새로운 구조)
            $newHeader = [
                'path' => $data['path'] ?? $data['header_key'] ?? '',
                'title' => $data['title'] ?? $data['name'] ?? '',
                'description' => $data['description'] ?? '',
                'default' => isset($data['default']) ? (bool)$data['default'] : false,
            ];

            // 기존 구조 지원 (하위 호환성)
            if (isset($data['template'])) {
                $newHeader['template'] = $data['template'];
            }
            if (isset($data['navbar'])) {
                $newHeader['navbar'] = (bool)$data['navbar'];
            }
            if (isset($data['logo'])) {
                $newHeader['logo'] = (bool)$data['logo'];
            }
            if (isset($data['search'])) {
                $newHeader['search'] = (bool)$data['search'];
            }

            $headers[] = $newHeader;
            $currentData['template'] = $headers;

            return $this->saveJsonData($currentData);
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

            // 헤더 데이터 업데이트 (새로운 구조)
            $updatedHeader = [
                'path' => $data['path'] ?? $data['header_key'] ?? $headers[$index]['path'] ?? '',
                'title' => $data['title'] ?? $data['name'] ?? $headers[$index]['title'] ?? '',
                'description' => $data['description'] ?? $headers[$index]['description'] ?? '',
                'menu_code' => $data['menu_code'] ?? $headers[$index]['menu_code'] ?? 'default',
                'enable' => isset($data['enable']) ? (bool)$data['enable'] : ($headers[$index]['enable'] ?? true),
                'active' => isset($data['active']) ? (bool)$data['active'] : ($headers[$index]['active'] ?? false),
                'default' => isset($data['default']) ? (bool)$data['default'] : ($headers[$index]['default'] ?? false),
            ];

            // 기존 구조 지원 (하위 호환성)
            if (isset($data['template'])) {
                $updatedHeader['template'] = $data['template'];
            } elseif (isset($headers[$index]['template'])) {
                $updatedHeader['template'] = $headers[$index]['template'];
            }

            if (isset($data['navbar'])) {
                $updatedHeader['navbar'] = (bool)$data['navbar'];
            } elseif (isset($headers[$index]['navbar'])) {
                $updatedHeader['navbar'] = $headers[$index]['navbar'];
            }

            if (isset($data['logo'])) {
                $updatedHeader['logo'] = (bool)$data['logo'];
            } elseif (isset($headers[$index]['logo'])) {
                $updatedHeader['logo'] = $headers[$index]['logo'];
            }

            if (isset($data['search'])) {
                $updatedHeader['search'] = (bool)$data['search'];
            } elseif (isset($headers[$index]['search'])) {
                $updatedHeader['search'] = $headers[$index]['search'];
            }

            $headers[$index] = $updatedHeader;
            $currentData['template'] = $headers;

            return $this->saveJsonData($currentData);
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

            return $this->saveJsonData($currentData);
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

            return $this->saveJsonData($currentData);
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
                'brand' => '',
                'search' => '',
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
                'brand' => $data['brand'] ?? '',
                'search' => $data['search'] ?? '',
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
     * Get header by path
     */
    public function getByPath(string $path): ?array
    {
        $headers = $this->getAllHeaders();

        foreach ($headers as $index => $header) {
            if ($header['path'] === $path) {
                $header['id'] = $index + 1;
                return $header;
            }
        }

        return null;
    }

    /**
     * Get header by key
     * @deprecated Use getByPath instead
     */
    public function getByKey(string $key): ?array
    {
        $headers = $this->getAllHeaders();

        foreach ($headers as $index => $header) {
            // Try new structure first, then fallback to old structure
            $headerKey = $header['path'] ?? $header['header_key'] ?? '';
            if ($headerKey === $key) {
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
        $data = $this->getFullJsonDataPrivate();
        return $data['logo'] ?? '';
    }

    /**
     * Get brand name
     */
    public function getBrandName(): string
    {
        $data = $this->getFullJsonDataPrivate();
        return $data['brand'] ?? $data['brand_name'] ?? '';
    }

    /**
     * Get brand tagline
     */
    public function getBrandTagline(): string
    {
        $data = $this->getFullJsonDataPrivate();
        return $data['brand_tagline'] ?? '';
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
     * Get the default header template (must be enabled and active)
     */
    public function getDefaultHeader(): ?array
    {
        $headers = $this->getAllHeaders();

        // 1순위: enable=true, active=true, default=true인 헤더
        foreach ($headers as $index => $header) {
            $isEnabled = isset($header['enable']) ? $header['enable'] : true;
            $isActive = isset($header['active']) ? $header['active'] : false;
            $isDefault = isset($header['default']) ? $header['default'] : false;

            if ($isEnabled && $isActive && $isDefault) {
                $header['id'] = $index + 1;
                return $header;
            }
        }

        // 2순위: enable=true, active=true인 첫 번째 헤더
        foreach ($headers as $index => $header) {
            $isEnabled = isset($header['enable']) ? $header['enable'] : true;
            $isActive = isset($header['active']) ? $header['active'] : false;

            if ($isEnabled && $isActive) {
                $header['id'] = $index + 1;
                return $header;
            }
        }

        // 3순위: enable=true인 첫 번째 헤더
        foreach ($headers as $index => $header) {
            $isEnabled = isset($header['enable']) ? $header['enable'] : true;

            if ($isEnabled) {
                $header['id'] = $index + 1;
                return $header;
            }
        }

        // 4순위: 첫 번째 헤더 (모든 헤더가 비활성화된 경우)
        if (!empty($headers)) {
            $headers[0]['id'] = 1;
            return $headers[0];
        }

        return null;
    }

    /**
     * Set a header as default by ID (automatically enables and activates)
     */
    public function setDefaultHeader(int $id): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();
            $headers = $currentData['template'] ?? [];
            $index = $id - 1;

            if (!isset($headers[$index]) || $index < 0) {
                return false;
            }

            // Remove default from all headers
            foreach ($headers as &$header) {
                $header['default'] = false;
            }

            // Set the selected header as default, enabled, and active
            $headers[$index]['default'] = true;
            $headers[$index]['enable'] = true;
            $headers[$index]['active'] = true;

            $currentData['template'] = $headers;

            return $this->saveJsonData($currentData);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Set a header as active by ID (must be enabled)
     */
    public function setActiveHeader(int $id): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();
            $headers = $currentData['template'] ?? [];
            $index = $id - 1;

            if (!isset($headers[$index]) || $index < 0) {
                return false;
            }

            // Check if header is enabled
            $isEnabled = isset($headers[$index]['enable']) ? $headers[$index]['enable'] : true;
            if (!$isEnabled) {
                return false; // Cannot activate disabled header
            }

            // Remove active from all headers
            foreach ($headers as &$header) {
                $header['active'] = false;
            }

            // Set the selected header as active
            $headers[$index]['active'] = true;

            $currentData['template'] = $headers;

            return $this->saveJsonData($currentData);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Toggle header enable status by ID
     */
    public function toggleHeaderEnable(int $id): bool
    {
        try {
            $currentData = $this->getFullJsonDataPrivate();
            $headers = $currentData['template'] ?? [];
            $index = $id - 1;

            if (!isset($headers[$index]) || $index < 0) {
                return false;
            }

            // Toggle enable status
            $currentEnable = isset($headers[$index]['enable']) ? $headers[$index]['enable'] : true;
            $headers[$index]['enable'] = !$currentEnable;

            // If disabling, also deactivate and remove default
            if (!$headers[$index]['enable']) {
                $headers[$index]['active'] = false;
                $headers[$index]['default'] = false;
            }

            $currentData['template'] = $headers;

            return $this->saveJsonData($currentData);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get header template statistics
     */
    public function getTemplateStats(): array
    {
        $headers = $this->getAllHeaders();
        $defaultHeader = $this->getDefaultHeader();

        return [
            'total_templates' => count($headers),
            'default_template' => $defaultHeader ? $defaultHeader['title'] ?? $defaultHeader['name'] ?? 'Unknown' : 'None',
            'default_path' => $defaultHeader ? $defaultHeader['path'] ?? $defaultHeader['header_key'] ?? '' : '',
            'templates_with_description' => count(array_filter($headers, function($header) {
                return !empty($header['description']);
            })),
        ];
    }

    /**
     * Get the default header path for view layouts
     */
    public function getDefaultHeaderPath(): string
    {
        $defaultHeader = $this->getDefaultHeader();

        if ($defaultHeader) {
            return $defaultHeader['path'] ?? $defaultHeader['header_key'] ?? '';
        }

        // Fallback to a default path if no default header is found
        return 'jiny-site::partials.headers.header-default';
    }

    /**
     * Get brand name from configuration
     */
    public function getBrand(): string
    {
        $data = $this->getFullJsonDataPrivate();
        return $data['brand'] ?? '';
    }

    /**
     * Get search configuration
     */
    public function getSearch(): string
    {
        $data = $this->getFullJsonDataPrivate();
        return $data['search'] ?? '';
    }

    /**
     * Update logo path
     */
    public function updateLogo(string $logo): bool
    {
        $data = $this->getFullJsonDataPrivate();
        $data['logo'] = $logo;
        return $this->saveJsonData($data);
    }

    /**
     * Update brand name
     */
    public function updateBrand(string $brand): bool
    {
        $data = $this->getFullJsonDataPrivate();
        $data['brand'] = $brand;
        return $this->saveJsonData($data);
    }

    /**
     * Update search configuration
     */
    public function updateSearch(string $search): bool
    {
        $data = $this->getFullJsonDataPrivate();
        $data['search'] = $search;
        return $this->saveJsonData($data);
    }

    /**
     * Get the default header's menu code
     */
    public function getDefaultMenuCode(): string
    {
        $defaultHeader = $this->getDefaultHeader();

        if ($defaultHeader) {
            return $defaultHeader['menu_code'] ?? 'default';
        }

        // Fallback to 'default' if no default header is found
        return 'default';
    }

}