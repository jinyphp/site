<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;

/**
 * 사이트 메뉴 모델 - JSON 기반 트리 구조 관리
 */
class SiteMenu extends Model
{
    /**
     * 테이블명
     *
     * @var string
     */
    protected $table = 'site_menus';

    /**
     * 대량 할당 가능한 속성
     *
     * @var array
     */
    protected $fillable = [
        'menu_code',
        'enable',
        'code', // 기존 호환성을 위해 유지
        'description',
        'blade',
        'manager',
        'json_path',
        'menu_data',
        'json_updated_at',
    ];

    /**
     * 속성 캐스팅
     *
     * @var array
     */
    protected $casts = [
        'enable' => 'boolean',
        'menu_data' => 'array',
        'json_updated_at' => 'datetime',
    ];

    /**
     * 메뉴 아이템 관계 (기존 호환성을 위해 유지)
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(SiteMenuItem::class, 'menu_id');
    }

    /**
     * JSON 파일 경로 반환
     *
     * @return string
     */
    public function getJsonFilePath(): string
    {
        return resource_path('menu/' . $this->menu_code . '.json');
    }

    /**
     * JSON 파일이 존재하는지 확인
     *
     * @return bool
     */
    public function hasJsonFile(): bool
    {
        return File::exists($this->getJsonFilePath());
    }

    /**
     * JSON 파일에서 메뉴 데이터 로드
     *
     * @return array|null
     */
    public function loadJsonData(): ?array
    {
        if (!$this->hasJsonFile()) {
            return null;
        }

        $content = File::get($this->getJsonFilePath());
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return $data;
    }

    /**
     * JSON 파일에 메뉴 데이터 저장
     *
     * @param array $data
     * @return bool
     */
    public function saveJsonData(array $data): bool
    {
        try {
            $jsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $filePath = $this->getJsonFilePath();

            // 디렉토리가 없으면 생성
            $directory = dirname($filePath);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // 백업 생성
            if (File::exists($filePath)) {
                $backupPath = resource_path('menu/backups');
                if (!File::exists($backupPath)) {
                    File::makeDirectory($backupPath, 0755, true);
                }
                $backupFile = $backupPath . '/' . $this->menu_code . '_' . date('Y-m-d_H-i-s') . '.json';
                File::copy($filePath, $backupFile);
            }

            // 파일 저장
            File::put($filePath, $jsonContent);

            // 캐시 업데이트
            $this->update([
                'menu_data' => $data,
                'json_updated_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('SiteMenu saveJsonData failed', [
                'menu_code' => $this->menu_code,
                'menu_id' => $this->id,
                'file_path' => $filePath,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'data_size' => strlen(json_encode($data))
            ]);
            return false;
        }
    }

    /**
     * JSON 파일과 DB 동기화
     *
     * @return bool
     */
    public function syncWithJsonFile(): bool
    {
        if (!$this->hasJsonFile()) {
            return false;
        }

        $fileModified = File::lastModified($this->getJsonFilePath());
        $dbModified = $this->json_updated_at ? $this->json_updated_at->timestamp : 0;

        // 파일이 더 최신이면 DB 업데이트
        if ($fileModified > $dbModified) {
            $data = $this->loadJsonData();
            if ($data !== null) {
                $this->update([
                    'menu_data' => $data,
                    'json_updated_at' => now(),
                ]);
                return true;
            }
        }

        return false;
    }

    /**
     * 메뉴 트리 통계 계산
     *
     * @return array
     */
    public function getMenuStats(): array
    {
        $data = $this->menu_data ?: $this->loadJsonData();

        if (!$data) {
            return [
                'total_items' => 0,
                'max_depth' => 0,
                'top_level_items' => 0,
                'items_with_children' => 0,
            ];
        }

        $stats = [
            'total_items' => 0,
            'max_depth' => 0,
            'top_level_items' => count($data),
            'items_with_children' => 0,
        ];

        $this->countMenuItems($data, $stats, 0);

        return $stats;
    }

    /**
     * 메뉴 아이템 수 계산 (재귀)
     *
     * @param array $items
     * @param array &$stats
     * @param int $level
     * @return void
     */
    private function countMenuItems(array $items, array &$stats, int $level): void
    {
        foreach ($items as $item) {
            $stats['total_items']++;
            $stats['max_depth'] = max($stats['max_depth'], $level);

            if (isset($item['children']) && is_array($item['children']) && count($item['children']) > 0) {
                $stats['items_with_children']++;
                $this->countMenuItems($item['children'], $stats, $level + 1);
            }
        }
    }

    /**
     * 기존 JSON 파일들을 데이터베이스에 등록
     *
     * @return array
     */
    public static function registerExistingJsonFiles(): array
    {
        $menuPath = resource_path('menu');
        $results = [
            'registered' => [],
            'skipped' => [],
            'errors' => []
        ];

        if (!File::exists($menuPath)) {
            $results['errors'][] = 'Menu directory does not exist: ' . $menuPath;
            return $results;
        }

        $jsonFiles = File::glob($menuPath . '/*.json');

        foreach ($jsonFiles as $filePath) {
            $fileName = pathinfo($filePath, PATHINFO_FILENAME);

            try {
                // 이미 등록된 메뉴인지 확인
                $existingMenu = static::where('menu_code', $fileName)->first();

                if ($existingMenu) {
                    // 기존 메뉴가 있으면 JSON 파일과 동기화만 수행
                    $existingMenu->syncWithJsonFile();
                    $results['skipped'][] = $fileName . ' (already exists)';
                    continue;
                }

                // JSON 파일 내용 읽기
                $content = File::get($filePath);
                $jsonData = json_decode($content, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $results['errors'][] = $fileName . ' (invalid JSON)';
                    continue;
                }

                // 새 메뉴 레코드 생성
                $menu = static::create([
                    'menu_code' => $fileName,
                    'code' => $fileName, // 기존 호환성을 위해 추가
                    'description' => ucfirst($fileName) . ' Menu',
                    'enable' => true,
                    'menu_data' => $jsonData,
                    'json_updated_at' => now(),
                ]);

                $results['registered'][] = $fileName;

            } catch (\Exception $e) {
                $results['errors'][] = $fileName . ' (' . $e->getMessage() . ')';
            }
        }

        return $results;
    }
}
