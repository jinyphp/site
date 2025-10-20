<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteTestimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'site_testimonials';

    protected $fillable = [
        'type',
        'item_id',
        'user_id',
        'name',
        'email',
        'title',
        'company',
        'avatar',
        'headline',
        'content',
        'rating',
        'likes_count',
        'featured',
        'enable',
        'verified',
        'metadata',
    ];

    protected $casts = [
        'rating' => 'integer',
        'likes_count' => 'integer',
        'featured' => 'boolean',
        'enable' => 'boolean',
        'verified' => 'boolean',
        'metadata' => 'array',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * 사용자 관계
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * 상품 관계 (type이 'product'일 때)
     */
    public function product()
    {
        return $this->belongsTo(\Jiny\Site\Models\SiteProduct::class, 'item_id')
                    ->where('type', 'product');
    }

    /**
     * 서비스 관계 (type이 'service'일 때)
     */
    public function service()
    {
        return $this->belongsTo(\Jiny\Site\Models\SiteService::class, 'item_id')
                    ->where('type', 'service');
    }

    /**
     * 좋아요 관계
     */
    public function likes()
    {
        return $this->hasMany(\Jiny\Site\Models\SiteTestimonialLike::class, 'testimonial_id');
    }

    /**
     * 활성화된 후기만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 추천 후기만 조회
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * 검증된 후기만 조회
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    /**
     * 별점별 조회
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * 최소 별점 이상 조회
     */
    public function scopeMinRating($query, $minRating)
    {
        return $query->where('rating', '>=', $minRating);
    }

    /**
     * 타입별 조회 (product/service)
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * 아이템별 조회
     */
    public function scopeForItem($query, $itemId, $type = null)
    {
        $query = $query->where('item_id', $itemId);

        if ($type) {
            $query->where('type', $type);
        }

        return $query;
    }

    /**
     * 검색
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('headline', 'like', '%' . $keyword . '%')
              ->orWhere('content', 'like', '%' . $keyword . '%')
              ->orWhere('name', 'like', '%' . $keyword . '%')
              ->orWhere('company', 'like', '%' . $keyword . '%');
        });
    }

    /**
     * 최근 후기 조회
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * 별점을 별 아이콘으로 표시
     */
    public function getStarsAttribute()
    {
        $fullStars = floor($this->rating);
        $halfStar = ($this->rating - $fullStars) >= 0.5;
        $emptyStars = 5 - ceil($this->rating);

        return [
            'full' => $fullStars,
            'half' => $halfStar ? 1 : 0,
            'empty' => $emptyStars,
        ];
    }

    /**
     * 짧은 내용 (요약)
     */
    public function getExcerptAttribute($length = 150)
    {
        return \Str::limit(strip_tags($this->content), $length);
    }

    /**
     * 아바타 URL (기본값 포함)
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return $this->avatar;
        }

        // 기본 아바타 생성 (Gravatar 사용)
        if ($this->email) {
            $hash = md5(strtolower(trim($this->email)));
            return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=80";
        }

        return null;
    }

    /**
     * 표시용 이름 (제목 포함)
     */
    public function getDisplayNameAttribute()
    {
        $name = $this->name;

        if ($this->title) {
            $name .= ', ' . $this->title;
        }

        if ($this->company) {
            $name .= ' at ' . $this->company;
        }

        return $name;
    }
}