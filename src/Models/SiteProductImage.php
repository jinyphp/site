<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteProductImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'site_product_images';

    protected $fillable = [
        'product_id',
        'enable',
        'pos',
        'is_featured',
        'title',
        'description',
        'alt_text',
        'image_url',
        'thumbnail_url',
        'original_filename',
        'file_size',
        'dimensions',
        'mime_type',
        'tags',
        'image_type',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'is_featured' => 'boolean',
        'pos' => 'integer',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * 소속 상품과의 관계
     */
    public function product()
    {
        return $this->belongsTo(SiteProduct::class, 'product_id');
    }

    /**
     * 활성화된 이미지만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 대표 이미지만 조회
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * 이미지 타입별 조회
     */
    public function scopeByType($query, $type)
    {
        return $query->where('image_type', $type);
    }

    /**
     * 정렬 순서대로 조회
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('pos')->orderBy('created_at');
    }

    /**
     * 태그 배열
     */
    public function getTagListAttribute()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    /**
     * 이미지 크기 배열 [width, height]
     */
    public function getDimensionsArrayAttribute()
    {
        if (!$this->dimensions) {
            return [null, null];
        }

        $parts = explode('x', $this->dimensions);
        return [
            isset($parts[0]) ? (int)$parts[0] : null,
            isset($parts[1]) ? (int)$parts[1] : null,
        ];
    }

    /**
     * 파일 크기를 사람이 읽기 쉬운 형태로 변환
     */
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) {
            return null;
        }

        $bytes = (int)$this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * 썸네일 URL (없으면 원본 이미지 사용)
     */
    public function getThumbnailAttribute()
    {
        return $this->thumbnail_url ?: $this->image_url;
    }

    /**
     * 이미지 타입 라벨
     */
    public function getImageTypeLabelAttribute()
    {
        $types = [
            'main' => '메인 이미지',
            'detail' => '상세 이미지',
            'lifestyle' => '라이프스타일',
            'tech_spec' => '기술 사양',
            'packaging' => '패키징',
            'comparison' => '비교 이미지',
            'installation' => '설치 가이드',
            'accessories' => '액세서리',
        ];

        return $types[$this->image_type] ?? $this->image_type;
    }
}