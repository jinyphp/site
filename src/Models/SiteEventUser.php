<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteEventUser extends Model
{
    use HasFactory;

    protected $table = 'site_event_users';

    protected $fillable = [
        'event_id',
        'user_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
        'applied_at',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * 이벤트와의 관계
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(SiteEvent::class, 'event_id', 'id');
    }

    /**
     * 사용자와의 관계 (회원인 경우)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * 참여 상태 텍스트 반환
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => '대기중',
            'approved' => '승인됨',
            'rejected' => '거부됨',
            'cancelled' => '취소됨',
            default => $this->status,
        };
    }

    /**
     * 참여 상태 클래스 반환 (Bootstrap)
     */
    public function getStatusClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * 승인 여부 확인
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * 대기중 여부 확인
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * 거부됨 여부 확인
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * 취소됨 여부 확인
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * 승인 처리
     */
    public function approve(string $approvedBy = null): bool
    {
        return $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $approvedBy,
        ]);
    }

    /**
     * 거부 처리
     */
    public function reject(string $approvedBy = null): bool
    {
        return $this->update([
            'status' => 'rejected',
            'approved_by' => $approvedBy,
        ]);
    }

    /**
     * 취소 처리
     */
    public function cancel(): bool
    {
        return $this->update([
            'status' => 'cancelled',
        ]);
    }

    /**
     * 스코프: 승인된 참여자만
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * 스코프: 대기중인 참여자만
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * 스코프: 특정 이벤트의 참여자
     */
    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    /**
     * 모델 이벤트 등록
     */
    protected static function boot()
    {
        parent::boot();

        // 새 참여자 등록 시
        static::created(function ($participant) {
            if ($participant->event_id && in_array($participant->status, ['pending', 'approved', 'rejected'])) {
                $event = SiteEvent::find($participant->event_id);
                if ($event) {
                    $event->incrementParticipantStats($participant->status);
                }
            }
        });

        // 참여자 정보 수정 시 (상태 변경 포함)
        static::updated(function ($participant) {
            if ($participant->event_id && $participant->wasChanged('status')) {
                $event = SiteEvent::find($participant->event_id);
                if ($event) {
                    $oldStatus = $participant->getOriginal('status');
                    $newStatus = $participant->status;

                    // cancelled 상태는 통계에서 제외하므로 특별 처리
                    if ($newStatus === 'cancelled') {
                        // 기존 상태만 감소시키고 total도 감소
                        if (in_array($oldStatus, ['pending', 'approved', 'rejected'])) {
                            $event->decrementParticipantStats($oldStatus);
                        }
                    } elseif ($oldStatus === 'cancelled') {
                        // cancelled에서 다른 상태로 변경되는 경우, 새 상태만 증가
                        if (in_array($newStatus, ['pending', 'approved', 'rejected'])) {
                            $event->incrementParticipantStats($newStatus);
                        }
                    } else {
                        // 일반적인 상태 변경
                        $event->updateParticipantStats($oldStatus, $newStatus);
                    }
                }
            }
        });

        // 참여자 삭제 시
        static::deleted(function ($participant) {
            if ($participant->event_id && in_array($participant->status, ['pending', 'approved', 'rejected'])) {
                $event = SiteEvent::find($participant->event_id);
                if ($event) {
                    $event->decrementParticipantStats($participant->status);
                }
            }
        });
    }

}