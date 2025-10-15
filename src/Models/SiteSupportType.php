<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

/**
 * 지원 요청 유형 모델
 */
class SiteSupportType extends Model
{
    use HasFactory;

    protected $table = 'site_support_types';

    protected $fillable = [
        'enable',
        'name',
        'code',
        'description',
        'icon',
        'color',
        'sort_order',
        'default_priority',
        'default_assignee_id',
        'expected_resolution_hours',
        'customer_instructions',
        'required_fields',
        'total_requests',
        'pending_requests',
        'in_progress_requests',
        'resolved_requests',
        'closed_requests',
        'avg_resolution_hours',
        'last_stats_updated_at',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'required_fields' => 'array',
        'sort_order' => 'integer',
        'expected_resolution_hours' => 'integer',
        'total_requests' => 'integer',
        'pending_requests' => 'integer',
        'in_progress_requests' => 'integer',
        'resolved_requests' => 'integer',
        'closed_requests' => 'integer',
        'avg_resolution_hours' => 'decimal:2',
        'last_stats_updated_at' => 'datetime',
    ];

    /**
     * 기본 담당자와의 관계
     */
    public function defaultAssignee()
    {
        return $this->belongsTo(User::class, 'default_assignee_id');
    }

    /**
     * 이 유형의 지원 요청들과의 관계
     */
    public function supportRequests()
    {
        return $this->hasMany(SiteSupport::class, 'type', 'code');
    }

    /**
     * 활성화된 유형만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 정렬 순서대로 조회
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * 코드로 조회
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    /**
     * 우선순위별 조회
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('default_priority', $priority);
    }

    /**
     * 담당자별 조회
     */
    public function scopeByAssignee($query, $assigneeId)
    {
        return $query->where('default_assignee_id', $assigneeId);
    }

    /**
     * 해결률 계산
     */
    public function getResolutionRateAttribute()
    {
        if ($this->total_requests == 0) {
            return 0;
        }

        return round(($this->resolved_requests / $this->total_requests) * 100, 2);
    }

    /**
     * 우선순위 라벨
     */
    public function getPriorityLabelAttribute()
    {
        $labels = [
            'urgent' => '긴급',
            'high' => '높음',
            'normal' => '보통',
            'low' => '낮음',
        ];

        return $labels[$this->default_priority] ?? '보통';
    }

    /**
     * 우선순위별 CSS 클래스
     */
    public function getPriorityClassAttribute()
    {
        $classes = [
            'urgent' => 'bg-danger text-white',
            'high' => 'bg-warning text-dark',
            'normal' => 'bg-info text-white',
            'low' => 'bg-secondary text-white',
        ];

        return $classes[$this->default_priority] ?? 'bg-info text-white';
    }

    /**
     * 상태별 CSS 클래스
     */
    public function getStatusClassAttribute()
    {
        return $this->enable ? 'bg-success text-white' : 'bg-secondary text-white';
    }

    /**
     * 상태 라벨
     */
    public function getStatusLabelAttribute()
    {
        return $this->enable ? '활성' : '비활성';
    }

    /**
     * 필수 필드 목록 (배열)
     */
    public function getRequiredFieldsListAttribute()
    {
        return $this->required_fields ?? [];
    }

    /**
     * 예상 해결 시간 포맷팅
     */
    public function getFormattedResolutionTimeAttribute()
    {
        $hours = $this->expected_resolution_hours;

        if ($hours >= 24) {
            $days = floor($hours / 24);
            $remainingHours = $hours % 24;

            if ($remainingHours > 0) {
                return $days . '일 ' . $remainingHours . '시간';
            }
            return $days . '일';
        }

        return $hours . '시간';
    }

    /**
     * 통계 업데이트
     */
    public function updateStatistics()
    {
        $supports = $this->supportRequests();

        $this->update([
            'total_requests' => $supports->count(),
            'pending_requests' => $supports->where('status', 'pending')->count(),
            'in_progress_requests' => $supports->where('status', 'in_progress')->count(),
            'resolved_requests' => $supports->where('status', 'resolved')->count(),
            'closed_requests' => $supports->where('status', 'closed')->count(),
            'avg_resolution_hours' => $this->calculateAverageResolutionTime(),
            'last_stats_updated_at' => now(),
        ]);
    }

    /**
     * 평균 해결 시간 계산
     */
    private function calculateAverageResolutionTime()
    {
        $resolved = $this->supportRequests()
            ->where('status', 'resolved')
            ->whereNotNull('resolved_at')
            ->whereNotNull('created_at')
            ->get();

        if ($resolved->isEmpty()) {
            return 0;
        }

        $totalHours = $resolved->sum(function ($support) {
            return $support->created_at->diffInHours($support->resolved_at);
        });

        return round($totalHours / $resolved->count(), 2);
    }

    /**
     * 코드 중복 체크
     */
    public static function isCodeUnique($code, $excludeId = null)
    {
        $query = static::where('code', $code);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->doesntExist();
    }

    /**
     * 정렬 순서 자동 생성
     */
    public static function getNextSortOrder()
    {
        return static::max('sort_order') + 1;
    }

    /**
     * 기본 필수 필드 목록
     */
    public static function getDefaultRequiredFields()
    {
        return [
            'subject' => '제목',
            'content' => '내용',
            'browser_info' => '브라우저 정보',
            'order_number' => '주문번호',
            'user_email' => '사용자 이메일',
            'reproduction_steps' => '재현 단계',
            'error_screenshot' => '오류 스크린샷',
            'urgency_reason' => '긴급 사유',
        ];
    }

    /**
     * 사용 가능한 아이콘 목록
     */
    public static function getAvailableIcons()
    {
        return [
            'fe fe-code' => '기술지원',
            'fe fe-credit-card' => '결제',
            'fe fe-help-circle' => '도움말',
            'fe fe-alert-triangle' => '경고',
            'fe fe-user' => '사용자',
            'fe fe-settings' => '설정',
            'fe fe-mail' => '메일',
            'fe fe-phone' => '전화',
            'fe fe-message-circle' => '메시지',
            'fe fe-tool' => '도구',
            'fe fe-shield' => '보안',
            'fe fe-globe' => '네트워크',
        ];
    }

    /**
     * 기본 색상 목록
     */
    public static function getDefaultColors()
    {
        return [
            '#007bff' => '파랑',
            '#28a745' => '초록',
            '#dc3545' => '빨강',
            '#ffc107' => '노랑',
            '#17a2b8' => '청록',
            '#6c757d' => '회색',
            '#343a40' => '검정',
            '#fd7e14' => '주황',
            '#e83e8c' => '분홍',
            '#6f42c1' => '보라',
        ];
    }
}