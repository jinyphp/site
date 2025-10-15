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
    ];

    protected $casts = [
        'enable' => 'boolean',
        'featured' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'images' => 'array',
        'features' => 'array',
        'specifications' => 'array',
    ];

    protected $dates = [
        'deleted_at',
    ];

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
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
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
              ->orWhere('tags', 'like', '%' . $keyword . '%');
        });
    }

    /**
     * 가격 범위로 조회
     */
    public function scopePriceRange($query, $min = null, $max = null)
    {
        if ($min !== null) {
            $query->where('price', '>=', $min);
        }
        if ($max !== null) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    /**
     * 할인 여부 확인
     */
    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    /**
     * 할인율 계산
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->is_on_sale) {
            return 0;
        }
        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    /**
     * 현재 가격 (할인가 우선)
     */
    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?: $this->price;
    }

    /**
     * 설명 요약
     */
    public function getExcerptAttribute($length = 150)
    {
        return \Str::limit(strip_tags($this->description), $length);
    }

    /**
     * 메인 이미지 URL
     */
    public function getMainImageAttribute()
    {
        return $this->image ?: (is_array($this->images) && count($this->images) > 0 ? $this->images[0] : null);
    }

    /**
     * 태그 배열
     */
    public function getTagListAttribute()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    /**
     * 카테고리와의 관계
     */
    public function productCategory()
    {
        return $this->belongsTo(SiteProductCategory::class, 'category_id');
    }

    /**
     * 가격 옵션들과의 관계
     */
    public function pricingOptions()
    {
        return $this->hasMany(SiteProductPricing::class, 'product_id')
            ->where('enable', true)
            ->orderBy('pos');
    }

    /**
     * 기본 가격 옵션
     */
    public function defaultPricing()
    {
        return $this->hasOne(SiteProductPricing::class, 'product_id')
            ->where('enable', true)
            ->orderBy('pos');
    }

    /**
     * 카테고리별 조회 (새로운 방식)
     */
    public function scopeByCategoryId($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * 가격 범위 조회 (가격 옵션 기반)
     */
    public function scopePriceRangeFromOptions($query, $min = null, $max = null)
    {
        return $query->whereHas('pricingOptions', function ($q) use ($min, $max) {
            if ($min !== null) {
                $q->where(function ($sq) use ($min) {
                    $sq->where('sale_price', '>=', $min)
                      ->orWhere(function ($ssq) use ($min) {
                          $ssq->whereNull('sale_price')->where('price', '>=', $min);
                      });
                });
            }
            if ($max !== null) {
                $q->where(function ($sq) use ($max) {
                    $sq->where('sale_price', '<=', $max)
                      ->orWhere(function ($ssq) use ($max) {
                          $ssq->whereNull('sale_price')->where('price', '<=', $max);
                      });
                });
            }
        });
    }

    /**
     * 최저가격 (가격 옵션 기반)
     */
    public function getMinPriceAttribute()
    {
        $minOption = $this->pricingOptions()
            ->selectRaw('COALESCE(sale_price, price) as current_price')
            ->orderBy('current_price')
            ->first();

        return $minOption ? $minOption->current_price : $this->current_price;
    }

    /**
     * 가격 옵션이 있는지 확인
     */
    public function getHasPricingOptionsAttribute()
    {
        return $this->pricingOptions()->count() > 0;
    }

    /**
     * 이미지 갤러리와의 관계
     */
    public function images()
    {
        return $this->hasMany(SiteProductImage::class, 'product_id')
            ->where('enable', true)
            ->orderBy('pos')
            ->orderBy('created_at');
    }

    /**
     * 모든 이미지 (비활성 포함)
     */
    public function allImages()
    {
        return $this->hasMany(SiteProductImage::class, 'product_id')
            ->orderBy('pos')
            ->orderBy('created_at');
    }

    /**
     * 대표 이미지
     */
    public function featuredImage()
    {
        return $this->hasOne(SiteProductImage::class, 'product_id')
            ->where('enable', true)
            ->where('is_featured', true)
            ->orderBy('pos');
    }

    /**
     * 메인 이미지 (대표 이미지 우선, 없으면 첫 번째 이미지)
     */
    public function getMainImageUrlAttribute()
    {
        // 1. 대표 이미지가 있으면 사용
        $featuredImage = $this->featuredImage;
        if ($featuredImage) {
            return $featuredImage->image_url;
        }

        // 2. 갤러리의 첫 번째 이미지 사용
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return $firstImage->image_url;
        }

        // 3. 기존 image 필드 사용
        return $this->image;
    }

    /**
     * 썸네일 이미지 URL
     */
    public function getThumbnailUrlAttribute()
    {
        $featuredImage = $this->featuredImage;
        if ($featuredImage && $featuredImage->thumbnail_url) {
            return $featuredImage->thumbnail_url;
        }

        return $this->main_image_url;
    }

    /**
     * 이미지 갤러리가 있는지 확인
     */
    public function getHasGalleryAttribute()
    {
        return $this->images()->count() > 0;
    }

    /**
     * 갤러리 이미지 개수
     */
    public function getImagesCountAttribute()
    {
        return $this->images()->count();
    }

    /**
     * 이미지 타입별 조회
     */
    public function imagesByType($type)
    {
        return $this->images()->where('image_type', $type);
    }
}