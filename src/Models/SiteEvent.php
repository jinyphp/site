<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 사이트 이벤트 모델
 */
class SiteEvent extends Model
{
    /**
     * 테이블명
     *
     * @var string
     */
    protected $table = 'site_event';

    /**
     * 대량 할당 가능한 속성
     *
     * @var array
     */
    protected $fillable = [
        'enable',
        'code',
        'blade',
        'image',
        'title',
        'description',
        'manager',
        'status',
        'view_count',
        'last_viewed_at',
        'allow_participation',
        'max_participants',
        'participation_start_date',
        'participation_end_date',
        'approval_type',
        'participation_description',
        'total_participants',
        'approved_participants',
        'pending_participants',
        'rejected_participants',
    ];

    /**
     * 속성 캐스팅
     *
     * @var array
     */
    protected $casts = [
        'enable' => 'boolean',
        'view_count' => 'integer',
        'last_viewed_at' => 'datetime',
        'allow_participation' => 'boolean',
        'max_participants' => 'integer',
        'participation_start_date' => 'datetime',
        'participation_end_date' => 'datetime',
        'total_participants' => 'integer',
        'approved_participants' => 'integer',
        'pending_participants' => 'integer',
        'rejected_participants' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * 기본값
     *
     * @var array
     */
    protected $attributes = [
        'enable' => true,
        'status' => 'active',
        'view_count' => 0,
        'allow_participation' => false,
        'approval_type' => 'auto',
        'total_participants' => 0,
        'approved_participants' => 0,
        'pending_participants' => 0,
        'rejected_participants' => 0,
    ];

    /**
     * 활성 이벤트 스코프
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 상태별 스코프
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * 검색 스코프
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%");
        });
    }

    /**
     * 정렬 스코프
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * 조회수 증가
     *
     * @param string|null $ip 방문자 IP (중복 조회 방지용)
     * @return $this
     */
    public function incrementViewCount($ip = null)
    {
        // 간단한 중복 방지: 같은 IP에서 1시간 이내 재조회는 카운트하지 않음
        if ($ip && $this->last_viewed_at) {
            $lastViewTime = $this->last_viewed_at;
            $oneHourAgo = now()->subHour();

            // 1시간 이내에 조회한 기록이 있으면 카운트하지 않음
            if ($lastViewTime->greaterThan($oneHourAgo)) {
                return $this;
            }
        }

        $this->increment('view_count');
        $this->update(['last_viewed_at' => now()]);

        return $this;
    }

    /**
     * 조회수를 포맷팅하여 반환
     *
     * @return string
     */
    public function getFormattedViewCountAttribute()
    {
        $count = $this->view_count;

        if ($count >= 1000000) {
            return number_format($count / 1000000, 1) . 'M';
        } elseif ($count >= 1000) {
            return number_format($count / 1000, 1) . 'K';
        }

        return number_format($count);
    }

    /**
     * 인기도 스코프 (조회수 기준)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    /**
     * 참여자들과의 관계
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(SiteEventUser::class, 'event_id');
    }

    /**
     * 승인된 참여자들과의 관계
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvedParticipants()
    {
        return $this->hasMany(SiteEventUser::class, 'event_id')->where('status', 'approved');
    }

    /**
     * 대기중인 참여자들과의 관계
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pendingParticipants()
    {
        return $this->hasMany(SiteEventUser::class, 'event_id')->where('status', 'pending');
    }

    /**
     * 참여 신청이 가능한지 확인
     *
     * @return bool
     */
    public function canParticipate(): bool
    {
        // 참여 신청 기능이 비활성화된 경우
        if (!$this->allow_participation) {
            return false;
        }

        // 참여 기간 체크
        $now = now();
        if ($this->participation_start_date && $now->lt($this->participation_start_date)) {
            return false;
        }
        if ($this->participation_end_date && $now->gt($this->participation_end_date)) {
            return false;
        }

        // 참여 인원 제한 체크
        if ($this->max_participants) {
            $approvedCount = $this->approvedParticipants()->count();
            if ($approvedCount >= $this->max_participants) {
                return false;
            }
        }

        return true;
    }

    /**
     * 사용자의 참여 신청 여부 확인
     *
     * @param string $email
     * @return bool
     */
    public function hasParticipated(string $email): bool
    {
        return $this->participants()->where('email', $email)->exists();
    }

    /**
     * 사용자의 참여 신청 정보 조회
     *
     * @param string $email
     * @return SiteEventUser|null
     */
    public function getParticipation(string $email): ?SiteEventUser
    {
        return $this->participants()->where('email', $email)->first();
    }

    /**
     * 남은 참여 가능 인원 수
     *
     * @return int|null null이면 무제한
     */
    public function getRemainingSpots(): ?int
    {
        if (!$this->max_participants) {
            return null; // 무제한
        }

        $approvedCount = $this->approvedParticipants()->count();
        return max(0, $this->max_participants - $approvedCount);
    }

    /**
     * 참여율 계산 (승인된 참여자 / 최대 참여자)
     *
     * @return float|null null이면 무제한이므로 계산 불가
     */
    public function getParticipationRate(): ?float
    {
        if (!$this->max_participants) {
            return null;
        }

        $approvedCount = $this->approvedParticipants()->count();
        return ($approvedCount / $this->max_participants) * 100;
    }

    /**
     * 참여 신청이 마감되었는지 확인
     *
     * @return bool
     */
    public function isParticipationClosed(): bool
    {
        // 참여 기간이 지났거나 인원이 다 찬 경우
        if ($this->participation_end_date && now()->gt($this->participation_end_date)) {
            return true;
        }

        if ($this->max_participants) {
            $approvedCount = $this->approvedParticipants()->count();
            if ($approvedCount >= $this->max_participants) {
                return true;
            }
        }

        return false;
    }

    /**
     * 참여 가능한 이벤트만 조회하는 스코프
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParticipationOpen($query)
    {
        return $query->where('allow_participation', true)
                    ->where(function ($q) {
                        $q->whereNull('participation_start_date')
                          ->orWhere('participation_start_date', '<=', now());
                    })
                    ->where(function ($q) {
                        $q->whereNull('participation_end_date')
                          ->orWhere('participation_end_date', '>=', now());
                    });
    }

    /**
     * 참여자 통계를 데이터베이스에서 새로고침
     *
     * @return $this
     */
    public function refreshParticipantStats(): self
    {
        $stats = $this->participants()
            ->selectRaw('
                COUNT(*) as total,
                COUNT(CASE WHEN status = "approved" THEN 1 END) as approved,
                COUNT(CASE WHEN status = "pending" THEN 1 END) as pending,
                COUNT(CASE WHEN status = "rejected" THEN 1 END) as rejected
            ')
            ->first();

        $this->update([
            'total_participants' => $stats->total ?? 0,
            'approved_participants' => $stats->approved ?? 0,
            'pending_participants' => $stats->pending ?? 0,
            'rejected_participants' => $stats->rejected ?? 0,
        ]);

        return $this;
    }

    /**
     * 참여자 통계 증가
     *
     * @param string $status 'approved', 'pending', 'rejected'
     * @return $this
     */
    public function incrementParticipantStats(string $status): self
    {
        $this->increment('total_participants');

        switch ($status) {
            case 'approved':
                $this->increment('approved_participants');
                break;
            case 'pending':
                $this->increment('pending_participants');
                break;
            case 'rejected':
                $this->increment('rejected_participants');
                break;
        }

        return $this;
    }

    /**
     * 참여자 통계 감소
     *
     * @param string $status 'approved', 'pending', 'rejected'
     * @return $this
     */
    public function decrementParticipantStats(string $status): self
    {
        $this->decrement('total_participants');

        switch ($status) {
            case 'approved':
                $this->decrement('approved_participants');
                break;
            case 'pending':
                $this->decrement('pending_participants');
                break;
            case 'rejected':
                $this->decrement('rejected_participants');
                break;
        }

        return $this;
    }

    /**
     * 참여자 상태 변경 시 통계 업데이트
     *
     * @param string $oldStatus 기존 상태
     * @param string $newStatus 새로운 상태
     * @return $this
     */
    public function updateParticipantStats(string $oldStatus, string $newStatus): self
    {
        // 기존 상태 감소
        switch ($oldStatus) {
            case 'approved':
                $this->decrement('approved_participants');
                break;
            case 'pending':
                $this->decrement('pending_participants');
                break;
            case 'rejected':
                $this->decrement('rejected_participants');
                break;
        }

        // 새로운 상태 증가
        switch ($newStatus) {
            case 'approved':
                $this->increment('approved_participants');
                break;
            case 'pending':
                $this->increment('pending_participants');
                break;
            case 'rejected':
                $this->increment('rejected_participants');
                break;
        }

        return $this;
    }

    /**
     * 통계 데이터 기반으로 남은 참여 가능 인원 수 (성능 최적화)
     *
     * @return int|null null이면 무제한
     */
    public function getRemainingSpotsCached(): ?int
    {
        if (!$this->max_participants) {
            return null; // 무제한
        }

        return max(0, $this->max_participants - $this->approved_participants);
    }

    /**
     * 통계 데이터 기반으로 참여율 계산 (성능 최적화)
     *
     * @return float|null null이면 무제한이므로 계산 불가
     */
    public function getParticipationRateCached(): ?float
    {
        if (!$this->max_participants) {
            return null;
        }

        return ($this->approved_participants / $this->max_participants) * 100;
    }
}