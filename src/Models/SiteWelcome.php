<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

/**
 * Site Welcome 블록 모델
 *
 * @description
 * Welcome 페이지의 블록들을 관리하는 모델입니다.
 * 그룹별 관리, 스케줄링, 미리보기 기능을 지원합니다.
 *
 * @property int $id
 * @property string $group_name 그룹명
 * @property string|null $group_title 그룹 제목
 * @property string|null $group_description 그룹 설명
 * @property string $block_name 블록 이름
 * @property string $view_template 뷰 템플릿 경로
 * @property array|null $config 블록 설정값
 * @property int $order 블록 순서
 * @property bool $is_enabled 블록 활성화 여부
 * @property Carbon|null $deploy_at 배포 예정일시
 * @property bool $is_active 그룹 활성화 상태
 * @property bool $is_published 그룹 배포 상태
 * @property string $status 상태
 * @property array|null $meta 추가 메타데이터
 * @property int|null $created_by 작성자 ID
 * @property int|null $updated_by 수정자 ID
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class SiteWelcome extends Model
{
    use HasFactory;

    /**
     * 테이블 이름
     */
    protected $table = 'site_welcome';

    /**
     * 대량 할당 가능한 속성
     */
    protected $fillable = [
        'group_name',
        'group_title',
        'group_description',
        'block_name',
        'view_template',
        'config',
        'order',
        'is_enabled',
        'deploy_at',
        'is_active',
        'is_published',
        'status',
        'meta',
        'created_by',
        'updated_by'
    ];

    /**
     * 속성 캐스팅
     */
    protected $casts = [
        'config' => 'array',
        'meta' => 'array',
        'is_enabled' => 'boolean',
        'is_active' => 'boolean',
        'is_published' => 'boolean',
        'deploy_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 기본 정렬 순서
     */
    protected static function booted()
    {
        static::addGlobalScope('ordered', function (Builder $builder) {
            $builder->orderBy('group_name')->orderBy('order')->orderBy('id');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | 스코프 (Scopes)
    |--------------------------------------------------------------------------
    */

    /**
     * 특정 그룹의 블록들만 조회
     */
    public function scopeGroup(Builder $query, string $groupName): Builder
    {
        return $query->where('group_name', $groupName);
    }

    /**
     * 활성화된 블록들만 조회
     */
    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('is_enabled', true);
    }

    /**
     * 현재 활성화된 그룹의 블록들만 조회
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * 배포된 그룹의 블록들만 조회
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * 배포 예정일이 지난 블록들 조회
     */
    public function scopeDeployable(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereNull('deploy_at')
              ->orWhere('deploy_at', '<=', now());
        });
    }

    /**
     * 특정 상태의 블록들만 조회
     */
    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * 순서대로 정렬
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order')->orderBy('id');
    }

    /**
     * 그룹별로 그룹화
     */
    public function scopeGrouped(Builder $query): Builder
    {
        return $query->orderBy('group_name')->orderBy('order');
    }

    /*
    |--------------------------------------------------------------------------
    | 정적 메서드 (Static Methods)
    |--------------------------------------------------------------------------
    */

    /**
     * 현재 활성화된 그룹의 활성화된 블록들 가져오기
     */
    public static function getCurrentBlocks(): \Illuminate\Database\Eloquent\Collection
    {
        return static::active()
            ->enabled()
            ->deployable()
            ->ordered()
            ->get();
    }

    /**
     * 특정 그룹의 활성화된 블록들 가져오기
     */
    public static function getGroupBlocks(string $groupName): \Illuminate\Database\Eloquent\Collection
    {
        return static::group($groupName)
            ->enabled()
            ->ordered()
            ->get();
    }

    /**
     * 미리보기용 블록들 가져오기 (활성화 여부 무관)
     */
    public static function getPreviewBlocks(string $groupName): \Illuminate\Database\Eloquent\Collection
    {
        return static::group($groupName)
            ->ordered()
            ->get();
    }

    /**
     * 모든 그룹 목록 가져오기
     */
    public static function getAllGroups(): \Illuminate\Database\Eloquent\Collection
    {
        $groups = static::select('group_name', 'group_title', 'group_description', 'is_active', 'is_published', 'deploy_at', 'status')
            ->distinct('group_name')
            ->orderBy('group_name')
            ->get()
            ->groupBy('group_name')
            ->map(function ($items) {
                $group = $items->first();
                // deploy_status 액세서 확인을 위해 전체 모델 인스턴스를 가져옴
                $fullGroup = static::where('group_name', $group->group_name)->first();
                if ($fullGroup) {
                    $group->deploy_status = $fullGroup->deploy_status;
                }
                return $group;
            });

        // Eloquent Collection으로 변환
        return new \Illuminate\Database\Eloquent\Collection($groups->values());
    }

    /**
     * 그룹 전체 활성화
     */
    public static function activateGroup(string $groupName): bool
    {
        // 모든 그룹 비활성화
        static::query()->update(['is_active' => false]);

        // 지정된 그룹만 활성화
        return static::group($groupName)->update([
            'is_active' => true,
            'is_published' => true,
            'status' => 'active'
        ]) > 0;
    }

    /**
     * 스케줄된 그룹들 자동 배포
     */
    public static function deployScheduledGroups(): int
    {
        $deployableGroups = static::select('group_name')
            ->where('status', 'scheduled')
            ->where('deploy_at', '<=', now())
            ->distinct('group_name')
            ->pluck('group_name');

        $deployedCount = 0;

        foreach ($deployableGroups as $groupName) {
            if (static::activateGroup($groupName)) {
                $deployedCount++;
            }
        }

        return $deployedCount;
    }

    /*
    |--------------------------------------------------------------------------
    | 액세서 & 뮤테이터 (Accessors & Mutators)
    |--------------------------------------------------------------------------
    */

    /**
     * 배포 상태 텍스트
     */
    public function getDeployStatusAttribute(): string
    {
        if ($this->is_active) {
            return '활성화';
        }

        if ($this->status === 'scheduled' && $this->deploy_at) {
            if ($this->deploy_at->isFuture()) {
                return '배포 예정';
            } else {
                return '배포 가능';
            }
        }

        return match($this->status) {
            'draft' => '임시저장',
            'scheduled' => '스케줄됨',
            'active' => '활성화',
            'archived' => '보관됨',
            default => '알 수 없음'
        };
    }

    /**
     * 블록 설정값을 JSON 문자열로 반환
     */
    public function getConfigJsonAttribute(): string
    {
        return json_encode($this->config ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /*
    |--------------------------------------------------------------------------
    | 관계 (Relationships)
    |--------------------------------------------------------------------------
    */

    /**
     * 작성자 관계 (User 모델이 있는 경우)
     */
    public function creator()
    {
        return $this->belongsTo(config('auth.providers.users.model', 'App\Models\User'), 'created_by');
    }

    /**
     * 수정자 관계 (User 모델이 있는 경우)
     */
    public function updater()
    {
        return $this->belongsTo(config('auth.providers.users.model', 'App\Models\User'), 'updated_by');
    }
}