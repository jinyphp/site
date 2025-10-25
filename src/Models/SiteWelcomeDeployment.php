<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

/**
 * Site Welcome 배포 이력 모델
 *
 * @description
 * Welcome 페이지 그룹들의 배포 이력을 관리하는 모델입니다.
 * 배포 추적, 롤백 지원, 배포 통계 기능을 제공합니다.
 *
 * @property int $id
 * @property string $group_name 배포된 그룹명
 * @property string|null $group_title 배포된 그룹 제목
 * @property string|null $group_description 배포된 그룹 설명
 * @property string $deployment_type 배포 타입
 * @property string $deployment_status 배포 상태
 * @property int $blocks_count 배포된 블록 수
 * @property array|null $blocks_deployed 배포된 블록들의 상세 정보
 * @property string|null $previous_active_group 이전 활성 그룹
 * @property Carbon $deployed_at 실제 배포된 시간
 * @property Carbon|null $scheduled_at 예약된 배포 시간
 * @property int|null $deployed_by 배포를 실행한 사용자 ID
 * @property string|null $deployed_by_name 배포를 실행한 사용자 이름
 * @property string|null $deployment_notes 배포 메모
 * @property array|null $deployment_metadata 배포 관련 추가 정보
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class SiteWelcomeDeployment extends Model
{
    use HasFactory;

    /**
     * 테이블 이름
     */
    protected $table = 'site_welcome_deployments';

    /**
     * 대량 할당 가능한 속성
     */
    protected $fillable = [
        'group_name',
        'group_title',
        'group_description',
        'deployment_type',
        'deployment_status',
        'blocks_count',
        'blocks_deployed',
        'previous_active_group',
        'deployed_at',
        'scheduled_at',
        'deployed_by',
        'deployed_by_name',
        'deployment_notes',
        'deployment_metadata'
    ];

    /**
     * 속성 캐스팅
     */
    protected $casts = [
        'blocks_deployed' => 'array',
        'deployment_metadata' => 'array',
        'deployed_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /*
    |--------------------------------------------------------------------------
    | 스코프 (Scopes)
    |--------------------------------------------------------------------------
    */

    /**
     * 특정 그룹의 배포 이력만 조회
     */
    public function scopeGroup($query, string $groupName)
    {
        return $query->where('group_name', $groupName);
    }

    /**
     * 성공한 배포만 조회
     */
    public function scopeSuccessful($query)
    {
        return $query->where('deployment_status', 'success');
    }

    /**
     * 실패한 배포만 조회
     */
    public function scopeFailed($query)
    {
        return $query->where('deployment_status', 'failed');
    }

    /**
     * 수동 배포만 조회
     */
    public function scopeManual($query)
    {
        return $query->where('deployment_type', 'manual');
    }

    /**
     * 스케줄된 배포만 조회
     */
    public function scopeScheduled($query)
    {
        return $query->where('deployment_type', 'scheduled');
    }

    /**
     * 최신 순으로 정렬
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('deployed_at', 'desc');
    }

    /*
    |--------------------------------------------------------------------------
    | 정적 메서드 (Static Methods)
    |--------------------------------------------------------------------------
    */

    /**
     * 배포 이력 기록
     */
    public static function recordDeployment(
        string $groupName,
        string $deploymentType = 'manual',
        array $blocks = [],
        string $previousActiveGroup = null,
        array $metadata = []
    ): self {
        // 그룹 정보 가져오기
        $welcomeGroup = SiteWelcome::group($groupName)->first();

        return static::create([
            'group_name' => $groupName,
            'group_title' => $welcomeGroup?->group_title,
            'group_description' => $welcomeGroup?->group_description,
            'deployment_type' => $deploymentType,
            'deployment_status' => 'success',
            'blocks_count' => count($blocks),
            'blocks_deployed' => $blocks,
            'previous_active_group' => $previousActiveGroup,
            'deployed_at' => now(),
            'deployed_by' => auth()->id(),
            'deployed_by_name' => auth()->user()?->name ?? 'System',
            'deployment_metadata' => $metadata
        ]);
    }

    /**
     * 최근 배포 이력 가져오기
     */
    public static function getRecentDeployments(int $limit = 10)
    {
        return static::latest()
            ->limit($limit)
            ->get();
    }

    /**
     * 그룹별 배포 통계
     */
    public static function getDeploymentStats()
    {
        return static::selectRaw('
                group_name,
                COUNT(*) as total_deployments,
                SUM(CASE WHEN deployment_status = "success" THEN 1 ELSE 0 END) as successful_deployments,
                SUM(CASE WHEN deployment_status = "failed" THEN 1 ELSE 0 END) as failed_deployments,
                MAX(deployed_at) as last_deployment_at
            ')
            ->groupBy('group_name')
            ->orderBy('last_deployment_at', 'desc')
            ->get();
    }

    /**
     * 특정 그룹의 마지막 배포 정보
     */
    public static function getLastDeployment(string $groupName): ?self
    {
        return static::group($groupName)
            ->successful()
            ->latest()
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | 액세서 & 뮤테이터 (Accessors & Mutators)
    |--------------------------------------------------------------------------
    */

    /**
     * 배포 타입 한글명
     */
    public function getDeploymentTypeKoreanAttribute(): string
    {
        return match($this->deployment_type) {
            'manual' => '수동 배포',
            'scheduled' => '예약 배포',
            'auto' => '자동 배포',
            default => '알 수 없음'
        };
    }

    /**
     * 배포 상태 한글명
     */
    public function getDeploymentStatusKoreanAttribute(): string
    {
        return match($this->deployment_status) {
            'success' => '성공',
            'failed' => '실패',
            'partial' => '부분 성공',
            default => '알 수 없음'
        };
    }

    /**
     * 배포 소요 시간 (생성 시간과 배포 시간의 차이)
     */
    public function getDeploymentDurationAttribute(): string
    {
        $diff = $this->created_at->diffInSeconds($this->deployed_at);

        if ($diff < 60) {
            return $diff . '초';
        } elseif ($diff < 3600) {
            return round($diff / 60) . '분';
        } else {
            return round($diff / 3600, 1) . '시간';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 관계 (Relationships)
    |--------------------------------------------------------------------------
    */

    /**
     * 배포를 실행한 사용자 관계
     */
    public function deployer()
    {
        return $this->belongsTo(config('auth.providers.users.model', 'App\\Models\\User'), 'deployed_by');
    }

    /**
     * 배포된 그룹의 현재 블록들
     */
    public function currentBlocks()
    {
        return SiteWelcome::group($this->group_name)->ordered()->get();
    }
}