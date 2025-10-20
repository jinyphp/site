<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteService extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'site_services';

    protected $fillable = [
        'enable',
        'featured',
        'slug',
        'title',
        'description',
        'content',
        'category',
        'category_id',
        'price',
        'sale_price',
        'image',
        'images',
        'features',
        'specifications',
        'tags',
        'meta_title',
        'meta_description',
        'manager',
        'sort_order',
        'status',
        'duration',
        'service_type',
        'availability',
        'booking_required',
        'max_participants',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'featured' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'images' => 'array',
        'features' => 'array',
        'specifications' => 'array',
        'tags' => 'array',
        'sort_order' => 'integer',
        'booking_required' => 'boolean',
        'max_participants' => 'integer',
        'duration' => 'integer', // minutes
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * 카테고리 관계
     */
    public function category()
    {
        return $this->belongsTo(SiteServiceCategory::class, 'category_id');
    }

    /**
     * 후기 관계
     */
    public function testimonials()
    {
        return $this->hasMany(SiteTestimonial::class, 'item_id')
                    ->where('type', 'service');
    }

    /**
     * 활성화된 후기
     */
    public function activeTestimonials()
    {
        return $this->testimonials()->where('enable', true);
    }

    /**
     * 추천 후기
     */
    public function featuredTestimonials()
    {
        return $this->testimonials()->where('featured', true)->where('enable', true);
    }

    /**
     * 활성화된 서비스만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 추천 서비스만 조회
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * 카테고리별 조회
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * 서비스 타입별 조회
     */
    public function scopeByType($query, $type)
    {
        return $query->where('service_type', $type);
    }

    /**
     * 검색
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', '%' . $keyword . '%')
              ->orWhere('description', 'like', '%' . $keyword . '%')
              ->orWhere('content', 'like', '%' . $keyword . '%');
        });
    }

    /**
     * 가격 범위별 조회
     */
    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * 할인 서비스 조회
     */
    public function scopeOnSale($query)
    {
        return $query->whereNotNull('sale_price')->where('sale_price', '>', 0);
    }

    /**
     * 예약 필요 서비스 조회
     */
    public function scopeBookingRequired($query)
    {
        return $query->where('booking_required', true);
    }

    /**
     * 정렬된 서비스 조회
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    /**
     * 판매 가격 계산 (할인가 또는 정가)
     */
    public function getEffectivePriceAttribute()
    {
        return $this->sale_price && $this->sale_price > 0 ? $this->sale_price : $this->price;
    }

    /**
     * 할인율 계산
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->sale_price || $this->sale_price >= $this->price) {
            return 0;
        }

        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    /**
     * 메인 이미지 URL
     */
    public function getMainImageAttribute()
    {
        if ($this->image) {
            return $this->image;
        }

        if ($this->images && is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }

        return null;
    }

    /**
     * SEO용 URL 생성
     */
    public function getUrlAttribute()
    {
        return route('services.show', $this->slug ?: $this->id);
    }

    /**
     * 짧은 설명
     */
    public function getExcerptAttribute($length = 150)
    {
        return \Str::limit(strip_tags($this->description), $length);
    }

    /**
     * 평균 평점 계산
     */
    public function getAverageRatingAttribute()
    {
        return $this->activeTestimonials()->avg('rating') ?: 0;
    }

    /**
     * 후기 개수
     */
    public function getTestimonialsCountAttribute()
    {
        return $this->activeTestimonials()->count();
    }

    /**
     * 서비스 기간 포맷 (시간, 분)
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) {
            return null;
        }

        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}시간 {$minutes}분";
        } elseif ($hours > 0) {
            return "{$hours}시간";
        } else {
            return "{$minutes}분";
        }
    }
}