<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

/**
 * 기술지원 할당 이력 모델
 */
class SiteSupportAssignment extends Model
{
    use HasFactory;

    protected $table = 'site_support_assignments';

    protected $fillable = [
        'support_id',
        'assigned_from',
        'assigned_to',
        'action',
        'note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * 지원 요청과의 관계
     */
    public function support()
    {
        return $this->belongsTo(SiteSupport::class, 'support_id');
    }

    /**
     * 할당한 사용자와의 관계
     */
    public function assignedFrom()
    {
        return $this->belongsTo(User::class, 'assigned_from');
    }

    /**
     * 할당받은 사용자와의 관계
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * 액션별 조회
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * 지원 요청별 조회
     */
    public function scopeBySupport($query, $supportId)
    {
        return $query->where('support_id', $supportId);
    }

    /**
     * 할당받은 사용자별 조회
     */
    public function scopeByAssignee($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    /**
     * 할당한 사용자별 조회
     */
    public function scopeByAssigner($query, $userId)
    {
        return $query->where('assigned_from', $userId);
    }

    /**
     * 액션 라벨
     */
    public function getActionLabelAttribute()
    {
        $labels = [
            'assign' => '할당',
            'unassign' => '할당 해제',
            'transfer' => '이전',
            'self_assign' => '자가 할당',
        ];

        return $labels[$this->action] ?? $this->action;
    }

    /**
     * 할당 이력 생성
     */
    public static function createAssignment($supportId, $assignedTo, $assignedFrom = null, $action = 'assign', $note = null)
    {
        return static::create([
            'support_id' => $supportId,
            'assigned_from' => $assignedFrom,
            'assigned_to' => $assignedTo,
            'action' => $action,
            'note' => $note,
        ]);
    }

    /**
     * 이전 이력 생성
     */
    public static function createTransfer($supportId, $fromUserId, $toUserId, $note = null)
    {
        return static::create([
            'support_id' => $supportId,
            'assigned_from' => $fromUserId,
            'assigned_to' => $toUserId,
            'action' => 'transfer',
            'note' => $note,
        ]);
    }
}