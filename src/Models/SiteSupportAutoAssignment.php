<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

/**
 * 기술지원 자동 할당 설정 모델
 */
class SiteSupportAutoAssignment extends Model
{
    use HasFactory;

    protected $table = 'site_support_auto_assignments';

    protected $fillable = [
        'type',
        'priority',
        'assignee_id',
        'enable',
        'order',
        'description',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * 할당받을 사용자와의 관계
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * 활성화된 설정만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 유형별 조회
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * 우선순위별 조회
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where(function ($q) use ($priority) {
            $q->where('priority', $priority)
              ->orWhereNull('priority');
        });
    }

    /**
     * 순서대로 정렬
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }

    /**
     * 특정 유형과 우선순위에 대한 자동 할당 대상자 찾기
     */
    public static function findAssigneeFor($type, $priority = null)
    {
        $query = static::enabled()
            ->byType($type)
            ->byPriority($priority)
            ->ordered()
            ->with('assignee');

        return $query->first()?->assignee;
    }

    /**
     * 모든 활성 자동 할당 설정 조회
     */
    public static function getActiveRules()
    {
        return static::enabled()
            ->ordered()
            ->with('assignee')
            ->get()
            ->groupBy(['type', 'priority']);
    }

    /**
     * 우선순위 라벨
     */
    public function getPriorityLabelAttribute()
    {
        if (!$this->priority) {
            return '모든 우선순위';
        }

        $labels = [
            'urgent' => '긴급',
            'high' => '높음',
            'normal' => '보통',
            'low' => '낮음',
        ];

        return $labels[$this->priority] ?? $this->priority;
    }

    /**
     * 유형 라벨 (실제 시스템에서 정의된 유형에 따라 수정 필요)
     */
    public function getTypeLabelAttribute()
    {
        $labels = [
            'technical' => '기술 문의',
            'billing' => '결제 문의',
            'account' => '계정 문의',
            'bug_report' => '버그 신고',
            'feature_request' => '기능 요청',
            'general' => '일반 문의',
        ];

        return $labels[$this->type] ?? $this->type;
    }
}