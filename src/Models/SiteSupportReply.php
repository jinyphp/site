<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class SiteSupportReply extends Model
{
    use HasFactory;

    protected $table = 'site_support_replies';

    protected $fillable = [
        'support_id',
        'user_id',
        'type',
        'sender_type',
        'content',
        'attachments',
        'is_private',
        'is_read',
        'read_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_private' => 'boolean',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
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
     * 작성자와의 관계
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 관리자가 작성한 답변들
     */
    public function scopeAdminReplies($query)
    {
        return $query->where('sender_type', 'admin');
    }

    /**
     * 고객이 작성한 문의들
     */
    public function scopeCustomerReplies($query)
    {
        return $query->where('sender_type', 'customer');
    }

    /**
     * 공개 답변 (고객이 볼 수 있는)
     */
    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    /**
     * 내부 메모 (관리자만 볼 수 있는)
     */
    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }

    /**
     * 읽지 않은 답변들
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * 유형별 조회
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * 답변을 읽음으로 표시
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * 발송자 유형 라벨
     */
    public function getSenderTypeLabelAttribute()
    {
        $labels = [
            'customer' => '고객',
            'admin' => '관리자',
        ];

        return $labels[$this->sender_type] ?? '알 수 없음';
    }

    /**
     * 유형 라벨
     */
    public function getTypeLabelAttribute()
    {
        $labels = [
            'question' => '질문',
            'answer' => '답변',
            'note' => '내부 메모',
        ];

        return $labels[$this->type] ?? '답변';
    }

    /**
     * 내용 요약
     */
    public function getExcerptAttribute($length = 100)
    {
        return \Str::limit(strip_tags($this->content), $length);
    }

    /**
     * 답변 생성 (관리자용)
     */
    public static function createAdminReply($supportId, $userId, $content, $isPrivate = false, $attachments = null)
    {
        return self::create([
            'support_id' => $supportId,
            'user_id' => $userId,
            'type' => $isPrivate ? 'note' : 'answer',
            'sender_type' => 'admin',
            'content' => $content,
            'attachments' => $attachments,
            'is_private' => $isPrivate,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * 고객 문의 생성
     */
    public static function createCustomerReply($supportId, $userId, $content, $attachments = null)
    {
        return self::create([
            'support_id' => $supportId,
            'user_id' => $userId,
            'type' => 'question',
            'sender_type' => 'customer',
            'content' => $content,
            'attachments' => $attachments,
            'is_private' => false,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}