<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'site_products';

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
        'stock_status',
        'sku',
        'weight',
        'dimensions',
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
        'dimensions' => 'array',
        'sort_order' => 'integer',
        'weight' => 'decimal:2',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * 카테고리 관계
     */
    public function category()
    {
        return $this->belongsTo(SiteProductCategory::class, 'category_id');
    }

    /**
     * 후기 관계
     */
    public function testimonials()
    {
        return $this->hasMany(SiteTestimonial::class, 'item_id')
                    ->where('type', 'product');
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
     * 활성화된 상품만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 추천 상품만 조회
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
     * 검색
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', '%' . $keyword . '%')
              ->orWhere('description', 'like', '%' . $keyword . '%')
              ->orWhere('content', 'like', '%' . $keyword . '%')
              ->orWhere('sku', 'like', '%' . $keyword . '%');
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
     * 할인 상품 조회
     */
    public function scopeOnSale($query)
    {
        return $query->whereNotNull('sale_price')->where('sale_price', '>', 0);
    }

    /**
     * 정렬된 상품 조회
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
        return route('products.show', $this->slug ?: $this->id);
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
}