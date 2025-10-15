<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class SiteContact extends Model
{
    protected $table = 'site_contacts';

    protected $fillable = [
        'contact_type_id',
        'user_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'priority',
        'assigned_to',
        'contact_number',
        'is_public',
        'processed_at'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'processed_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contact) {
            if (empty($contact->contact_number)) {
                $contact->contact_number = static::generateContactNumber();
            }

            if (Auth::check()) {
                $contact->user_id = Auth::id();
            }
        });

        static::updating(function ($contact) {
            if ($contact->isDirty('status') && in_array($contact->status, ['completed', 'cancelled'])) {
                $contact->processed_at = now();
            }
        });
    }

    /**
     * 상담 번호 생성
     */
    public static function generateContactNumber(): string
    {
        $date = now()->format('Ymd');
        $lastNumber = static::where('contact_number', 'like', "CT{$date}%")
                           ->orderBy('contact_number', 'desc')
                           ->first();

        if ($lastNumber) {
            $lastSequence = (int)substr($lastNumber->contact_number, -4);
            $newSequence = $lastSequence + 1;
        } else {
            $newSequence = 1;
        }

        return sprintf('CT%s%04d', $date, $newSequence);
    }

    /**
     * 상담 유형과의 관계
     */
    public function contactType(): BelongsTo
    {
        return $this->belongsTo(SiteContactType::class, 'contact_type_id');
    }

    /**
     * 사용자와의 관계
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * 담당자와의 관계
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    /**
     * 댓글과의 관계
     */
    public function comments(): HasMany
    {
        return $this->hasMany(SiteContactComment::class, 'contact_id');
    }

    /**
     * 공개 댓글과의 관계 (사용자가 볼 수 있는)
     */
    public function publicComments(): HasMany
    {
        return $this->hasMany(SiteContactComment::class, 'contact_id')
                    ->where('is_internal', false);
    }

    /**
     * 내부 댓글과의 관계 (관리자만 볼 수 있는)
     */
    public function internalComments(): HasMany
    {
        return $this->hasMany(SiteContactComment::class, 'contact_id')
                    ->where('is_internal', true);
    }

    /**
     * 상태별 조회 스코프
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * 우선순위별 조회 스코프
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * 담당자별 조회 스코프
     */
    public function scopeByAssignee($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    /**
     * 이메일로 조회 스코프
     */
    public function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    /**
     * 상태 텍스트 반환
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => '대기 중',
            'processing' => '처리 중',
            'completed' => '완료',
            'cancelled' => '취소',
            default => $this->status
        };
    }

    /**
     * 우선순위 텍스트 반환
     */
    public function getPriorityTextAttribute(): string
    {
        return match($this->priority) {
            'low' => '낮음',
            'normal' => '보통',
            'high' => '높음',
            'urgent' => '긴급',
            default => $this->priority
        };
    }

    /**
     * 상태 클래스 반환 (Bootstrap 색상)
     */
    public function getStatusClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'cancelled' => 'secondary',
            default => 'secondary'
        };
    }

    /**
     * 우선순위 클래스 반환 (Bootstrap 색상)
     */
    public function getPriorityClassAttribute(): string
    {
        return match($this->priority) {
            'low' => 'success',
            'normal' => 'primary',
            'high' => 'warning',
            'urgent' => 'danger',
            default => 'primary'
        };
    }

    /**
     * 진행 중인지 확인
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * 완료된지 확인
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * 취소된지 확인
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
}