<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class SiteSupport extends Model
{
    use HasFactory;

    protected $table = 'site_support';

    protected $fillable = [
        'enable',
        'user_id',
        'name',
        'email',
        'phone',
        'company',
        'type',
        'subject',
        'content',
        'priority',
        'attachments',
        'status',
        'admin_reply',
        'assigned_to',
        'started_at',
        'resolved_at',
        // 'resolved_by', // 컬럼이 존재하지 않음
        'closed_at',
        // 'closed_by', // 컬럼이 존재하지 않음
        'reopened_at',
        // 'reopened_by', // 컬럼이 존재하지 않음
        'ip_address',
        'user_agent',
        'referrer',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'attachments' => 'array',
        'started_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
        'reopened_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    /**
     * 지원 요청을 한 사용자와의 관계
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 담당자와의 관계
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * 해결 처리자와의 관계
     * 컬럼이 존재하지 않아 주석 처리
     */
    // public function resolvedBy()
    // {
    //     return $this->belongsTo(User::class, 'resolved_by');
    // }

    /**
     * 종료 처리자와의 관계
     * 컬럼이 존재하지 않아 주석 처리
     */
    // public function closedBy()
    // {
    //     return $this->belongsTo(User::class, 'closed_by');
    // }

    /**
     * 재오픈 처리자와의 관계
     * 컬럼이 존재하지 않아 주석 처리
     */
    // public function reopenedBy()
    // {
    //     return $this->belongsTo(User::class, 'reopened_by');
    // }

    /**
     * 활성화된 지원 요청만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 상태별 조회
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
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
        return $query->where('priority', $priority);
    }

    /**
     * 사용자별 조회
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * 담당자별 조회
     */
    public function scopeByAssignee($query, $assigneeId)
    {
        return $query->where('assigned_to', $assigneeId);
    }

    /**
     * 검색
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('subject', 'like', '%' . $keyword . '%')
              ->orWhere('content', 'like', '%' . $keyword . '%')
              ->orWhere('name', 'like', '%' . $keyword . '%')
              ->orWhere('email', 'like', '%' . $keyword . '%');
        });
    }

    /**
     * 처리중인 요청들
     */
    public function scopeInProgress($query)
    {
        return $query->whereIn('status', ['pending', 'in_progress']);
    }

    /**
     * 완료된 요청들
     */
    public function scopeCompleted($query)
    {
        return $query->whereIn('status', ['resolved', 'closed']);
    }

    /**
     * 수정 가능한 상태인지 확인
     */
    public function isEditable()
    {
        return in_array($this->status, ['pending']);
    }

    /**
     * 삭제 가능한 상태인지 확인
     */
    public function isDeletable()
    {
        return in_array($this->status, ['pending']);
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

        return $labels[$this->priority] ?? '보통';
    }

    /**
     * 상태 라벨
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => '대기중',
            'in_progress' => '처리중',
            'resolved' => '해결완료',
            'closed' => '종료',
        ];

        return $labels[$this->status] ?? '대기중';
    }

    /**
     * 상태별 CSS 클래스
     */
    public function getStatusClassAttribute()
    {
        $classes = [
            'pending' => 'bg-warning text-dark',
            'in_progress' => 'bg-primary text-white',
            'resolved' => 'bg-success text-white',
            'closed' => 'bg-secondary text-white',
        ];

        return $classes[$this->status] ?? 'bg-secondary text-white';
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
            'low' => 'bg-light text-dark',
        ];

        return $classes[$this->priority] ?? 'bg-info text-white';
    }

    /**
     * 내용 요약
     */
    public function getExcerptAttribute($length = 100)
    {
        return \Str::limit(strip_tags($this->content), $length);
    }

    /**
     * 지원 유형 라벨
     */
    public function getTypeLabelAttribute()
    {
        $labels = [
            'technical' => '기술 지원',
            'billing' => '결제 문의',
            'general' => '일반 문의',
            'bug_report' => '버그 리포트',
        ];

        return $labels[$this->type] ?? $this->type;
    }

    /**
     * 지원 요청 해결
     */
    public function resolve($adminReply = null)
    {
        $this->update([
            'status' => 'resolved',
            'admin_reply' => $adminReply,
            'resolved_at' => now(),
        ]);
    }

    /**
     * 지원 요청 종료
     */
    public function close()
    {
        $this->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);
    }

    /**
     * 할당 이력과의 관계
     */
    public function assignments()
    {
        return $this->hasMany(\Jiny\Site\Models\SiteSupportAssignment::class, 'support_id');
    }

    /**
     * 최근 할당 이력
     */
    public function latestAssignment()
    {
        return $this->hasOne(\Jiny\Site\Models\SiteSupportAssignment::class, 'support_id')->latest();
    }

    /**
     * 담당자 배정
     */
    public function assignTo($userId, $assignedFrom = null, $note = null)
    {
        $previousAssignee = $this->assigned_to;

        $this->update([
            'assigned_to' => $userId,
            'status' => 'in_progress',
        ]);

        // 할당 이력 생성
        $action = $previousAssignee ? 'transfer' : 'assign';
        \Jiny\Site\Models\SiteSupportAssignment::createAssignment(
            $this->id,
            $userId,
            $assignedFrom,
            $action,
            $note
        );
    }

    /**
     * 자가 할당
     */
    public function selfAssign($userId)
    {
        $this->update([
            'assigned_to' => $userId,
            'status' => 'in_progress',
        ]);

        // 자가 할당 이력 생성
        \Jiny\Site\Models\SiteSupportAssignment::createAssignment(
            $this->id,
            $userId,
            $userId,
            'self_assign'
        );
    }

    /**
     * 할당 해제
     */
    public function unassign($unassignedBy = null, $note = null)
    {
        $previousAssignee = $this->assigned_to;

        $this->update([
            'assigned_to' => null,
            'status' => 'pending',
        ]);

        // 할당 해제 이력 생성
        if ($previousAssignee) {
            \Jiny\Site\Models\SiteSupportAssignment::create([
                'support_id' => $this->id,
                'assigned_from' => $unassignedBy,
                'assigned_to' => $previousAssignee,
                'action' => 'unassign',
                'note' => $note,
            ]);
        }
    }

    /**
     * 다른 담당자에게 이전
     */
    public function transferTo($newAssigneeId, $currentUserId, $note = null)
    {
        $previousAssignee = $this->assigned_to;

        $this->update([
            'assigned_to' => $newAssigneeId,
            'status' => 'in_progress',
        ]);

        // 이전 이력 생성
        \Jiny\Site\Models\SiteSupportAssignment::createTransfer(
            $this->id,
            $currentUserId,
            $newAssigneeId,
            $note
        );
    }

    /**
     * 자동 할당 시도
     */
    public function autoAssign()
    {
        $assignee = \Jiny\Site\Models\SiteSupportAutoAssignment::findAssigneeFor($this->type, $this->priority);

        if ($assignee) {
            $this->assignTo($assignee->id, null, '자동 할당');
            return true;
        }

        return false;
    }

    /**
     * 할당 가능 여부 확인
     */
    public function canBeAssigned()
    {
        return in_array($this->status, ['pending', 'in_progress']);
    }

    /**
     * 특정 사용자가 이 요청의 담당자인지 확인
     */
    public function isAssignedTo($userId)
    {
        return $this->assigned_to == $userId;
    }

    /**
     * 할당되지 않은 요청들
     */
    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    /**
     * 답변 및 이력과의 관계
     */
    public function replies()
    {
        return $this->hasMany(\Jiny\Site\Models\SiteSupportReply::class, 'support_id');
    }

    /**
     * 공개 답변들만 조회 (고객이 볼 수 있는)
     */
    public function publicReplies()
    {
        return $this->hasMany(\Jiny\Site\Models\SiteSupportReply::class, 'support_id')
            ->where('is_private', false)
            ->orderBy('created_at', 'asc');
    }

    /**
     * 내부 메모들만 조회 (관리자만 볼 수 있는)
     */
    public function privateReplies()
    {
        return $this->hasMany(\Jiny\Site\Models\SiteSupportReply::class, 'support_id')
            ->where('is_private', true)
            ->orderBy('created_at', 'asc');
    }

    /**
     * 관리자 답변들만 조회
     */
    public function adminReplies()
    {
        return $this->hasMany(\Jiny\Site\Models\SiteSupportReply::class, 'support_id')
            ->where('sender_type', 'admin')
            ->orderBy('created_at', 'asc');
    }

    /**
     * 고객 문의들만 조회
     */
    public function customerReplies()
    {
        return $this->hasMany(\Jiny\Site\Models\SiteSupportReply::class, 'support_id')
            ->where('sender_type', 'customer')
            ->orderBy('created_at', 'asc');
    }

    /**
     * 최근 답변
     */
    public function latestReply()
    {
        return $this->hasOne(\Jiny\Site\Models\SiteSupportReply::class, 'support_id')->latest();
    }

    /**
     * 다중 관리자 할당과의 관계
     */
    public function multipleAssignments()
    {
        return $this->hasMany(\Jiny\Site\Models\SiteSupportMultipleAssignment::class, 'support_id');
    }

    /**
     * 활성 다중 할당들
     */
    public function activeAssignments()
    {
        return $this->hasMany(\Jiny\Site\Models\SiteSupportMultipleAssignment::class, 'support_id')
            ->where('is_active', true)
            ->orderBy('role', 'asc'); // primary 먼저
    }

    /**
     * 주담당자 할당
     */
    public function primaryAssignment()
    {
        return $this->hasOne(\Jiny\Site\Models\SiteSupportMultipleAssignment::class, 'support_id')
            ->where('role', 'primary')
            ->where('is_active', true);
    }

    /**
     * 부담당자 할당들
     */
    public function secondaryAssignments()
    {
        return $this->hasMany(\Jiny\Site\Models\SiteSupportMultipleAssignment::class, 'support_id')
            ->where('role', 'secondary')
            ->where('is_active', true);
    }

    /**
     * 고객 평가와의 관계
     */
    public function evaluations()
    {
        return $this->hasMany(\Jiny\Site\Models\SiteSupportEvaluation::class, 'support_id');
    }

    /**
     * 평가 여부 확인
     */
    public function isEvaluatedBy($userId)
    {
        return $this->evaluations()->where('evaluator_id', $userId)->exists();
    }

    /**
     * 평가 가능 여부 확인 (완료된 상태에서만 평가 가능)
     */
    public function canBeEvaluated()
    {
        return in_array($this->status, ['resolved', 'closed']);
    }

    /**
     * 재오픈 가능 여부 확인
     */
    public function canBeReopened()
    {
        return in_array($this->status, ['resolved', 'closed']);
    }

    /**
     * 지원 요청 재오픈
     */
    public function reopen($note = null)
    {
        $this->update([
            'status' => 'pending',
            'resolved_at' => null,
            'closed_at' => null,
        ]);

        // 재오픈 이력 추가
        if ($note) {
            \Jiny\Site\Models\SiteSupportReply::createAdminReply(
                $this->id,
                auth()->id(),
                "지원 요청이 재오픈되었습니다.\n\n사유: " . $note,
                true // 내부 메모로 저장
            );
        }
    }

    /**
     * 답변 추가 (관리자용)
     */
    public function addAdminReply($content, $isPrivate = false, $attachments = null)
    {
        return \Jiny\Site\Models\SiteSupportReply::createAdminReply(
            $this->id,
            auth()->id(),
            $content,
            $isPrivate,
            $attachments
        );
    }

    /**
     * 고객 문의 추가
     */
    public function addCustomerReply($content, $userId = null, $attachments = null)
    {
        $userId = $userId ?: $this->user_id;

        return \Jiny\Site\Models\SiteSupportReply::createCustomerReply(
            $this->id,
            $userId,
            $content,
            $attachments
        );
    }

    /**
     * 다중 관리자 할당
     */
    public function assignMultipleAdmin($assigneeId, $role = 'secondary', $note = null)
    {
        return \Jiny\Site\Models\SiteSupportMultipleAssignment::assignAdmin(
            $this->id,
            $assigneeId,
            $role,
            auth()->id(),
            $note
        );
    }

    /**
     * 읽지 않은 답변 수 조회
     */
    public function getUnreadRepliesCountAttribute()
    {
        // 관계가 로드되어 있으면 컬렉션에서 필터링, 아니면 쿼리 실행
        if ($this->relationLoaded('replies')) {
            return $this->replies->where('is_read', false)->count();
        }
        return $this->replies()->where('is_read', false)->count();
    }

    /**
     * 총 답변 수 조회
     */
    public function getTotalRepliesCountAttribute()
    {
        // 관계가 로드되어 있으면 컬렉션 카운트, 아니면 쿼리 실행
        if ($this->relationLoaded('replies')) {
            return $this->replies->count();
        }
        return $this->replies()->count();
    }

    /**
     * 활성 할당자 수 조회
     */
    public function getActiveAssigneesCountAttribute()
    {
        // 관계가 로드되어 있으면 컬렉션에서 필터링, 아니면 쿼리 실행
        if ($this->relationLoaded('activeAssignments')) {
            return $this->activeAssignments->count();
        }
        return $this->activeAssignments()->count();
    }
}