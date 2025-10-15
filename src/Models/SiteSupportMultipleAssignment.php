<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class SiteSupportMultipleAssignment extends Model
{
    use HasFactory;

    protected $table = 'site_support_multiple_assignments';

    protected $fillable = [
        'support_id',
        'assignee_id',
        'role',
        'assigned_by',
        'is_active',
        'note',
        'assigned_at',
        'deactivated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'assigned_at' => 'datetime',
        'deactivated_at' => 'datetime',
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
     * 할당받은 관리자와의 관계
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * 할당한 관리자와의 관계
     */
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * 활성 할당만 조회
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * 비활성 할당만 조회
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * 주담당자만 조회
     */
    public function scopePrimary($query)
    {
        return $query->where('role', 'primary');
    }

    /**
     * 부담당자만 조회
     */
    public function scopeSecondary($query)
    {
        return $query->where('role', 'secondary');
    }

    /**
     * 특정 지원 요청의 할당 내역 조회
     */
    public function scopeForSupport($query, $supportId)
    {
        return $query->where('support_id', $supportId);
    }

    /**
     * 특정 관리자의 할당 내역 조회
     */
    public function scopeForAssignee($query, $assigneeId)
    {
        return $query->where('assignee_id', $assigneeId);
    }

    /**
     * 역할 라벨
     */
    public function getRoleLabelAttribute()
    {
        $labels = [
            'primary' => '주담당자',
            'secondary' => '부담당자',
        ];

        return $labels[$this->role] ?? '부담당자';
    }

    /**
     * 상태 라벨
     */
    public function getStatusLabelAttribute()
    {
        return $this->is_active ? '활성' : '비활성';
    }

    /**
     * 할당 비활성화
     */
    public function deactivate()
    {
        $this->update([
            'is_active' => false,
            'deactivated_at' => now(),
        ]);
    }

    /**
     * 할당 활성화
     */
    public function activate()
    {
        $this->update([
            'is_active' => true,
            'deactivated_at' => null,
        ]);
    }

    /**
     * 주담당자로 승격
     */
    public function promoteToPrimary()
    {
        // 기존 주담당자를 부담당자로 변경
        self::where('support_id', $this->support_id)
            ->where('role', 'primary')
            ->where('is_active', true)
            ->update(['role' => 'secondary']);

        // 현재 할당을 주담당자로 변경
        $this->update(['role' => 'primary']);
    }

    /**
     * 부담당자로 강등
     */
    public function demoteToSecondary()
    {
        $this->update(['role' => 'secondary']);
    }

    /**
     * 관리자 할당
     */
    public static function assignAdmin($supportId, $assigneeId, $role = 'secondary', $assignedBy = null, $note = null)
    {
        // 기존 할당이 있는지 확인
        $existing = self::where('support_id', $supportId)
            ->where('assignee_id', $assigneeId)
            ->first();

        if ($existing) {
            // 기존 할당이 있으면 활성화
            $existing->activate();
            return $existing;
        }

        // 주담당자를 할당하는 경우, 기존 주담당자를 부담당자로 변경
        if ($role === 'primary') {
            self::where('support_id', $supportId)
                ->where('role', 'primary')
                ->where('is_active', true)
                ->update(['role' => 'secondary']);
        }

        return self::create([
            'support_id' => $supportId,
            'assignee_id' => $assigneeId,
            'role' => $role,
            'assigned_by' => $assignedBy,
            'note' => $note,
            'is_active' => true,
            'assigned_at' => now(),
        ]);
    }

    /**
     * 특정 지원 요청의 활성 주담당자 조회
     */
    public static function getPrimaryAssignee($supportId)
    {
        return self::with('assignee')
            ->where('support_id', $supportId)
            ->where('role', 'primary')
            ->where('is_active', true)
            ->first();
    }

    /**
     * 특정 지원 요청의 활성 부담당자들 조회
     */
    public static function getSecondaryAssignees($supportId)
    {
        return self::with('assignee')
            ->where('support_id', $supportId)
            ->where('role', 'secondary')
            ->where('is_active', true)
            ->get();
    }

    /**
     * 특정 지원 요청의 모든 활성 할당자들 조회
     */
    public static function getAllActiveAssignees($supportId)
    {
        return self::with('assignee')
            ->where('support_id', $supportId)
            ->where('is_active', true)
            ->orderBy('role', 'asc') // primary 먼저
            ->get();
    }
}