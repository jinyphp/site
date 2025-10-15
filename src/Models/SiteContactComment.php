<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class SiteContactComment extends Model
{
    protected $table = 'site_contact_comments';

    protected $fillable = [
        'contact_id',
        'user_id',
        'comment',
        'is_internal'
    ];

    protected $casts = [
        'is_internal' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            if (Auth::check()) {
                $comment->user_id = Auth::id();
            }
        });
    }

    /**
     * 상담 요청과의 관계
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(SiteContact::class, 'contact_id');
    }

    /**
     * 작성자와의 관계
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * 공개 댓글만 조회
     */
    public function scopePublic($query)
    {
        return $query->where('is_internal', false);
    }

    /**
     * 내부 댓글만 조회
     */
    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    /**
     * 최신순 정렬
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * 오래된순 정렬
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    /**
     * 댓글 유형 텍스트 반환
     */
    public function getTypeTextAttribute(): string
    {
        return $this->is_internal ? '내부 메모' : '공개 답변';
    }

    /**
     * 댓글 유형 클래스 반환
     */
    public function getTypeClassAttribute(): string
    {
        return $this->is_internal ? 'warning' : 'info';
    }
}