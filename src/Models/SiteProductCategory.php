<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteProductCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'site_product_categories';

    protected $fillable = [
        'enable',
        'pos',
        'code',
        'slug',
        'title',
        'description',
        'image',
        'color',
        'icon',
        'parent_id',
        'meta_title',
        'meta_description',
        'manager',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'pos' => 'integer',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * 부모 카테고리와의 관계
     */
    public function parent()
    {
        return $this->belongsTo(SiteProductCategory::class, 'parent_id');
    }

    /**
     * 하위 카테고리들과의 관계
     */
    public function children()
    {
        return $this->hasMany(SiteProductCategory::class, 'parent_id')
            ->where('enable', true)
            ->orderBy('pos');
    }

    /**
     * 모든 하위 카테고리들 (재귀적)
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    /**
     * 이 카테고리에 속한 상품들
     */
    public function products()
    {
        return $this->hasMany(SiteProduct::class, 'category_id')
            ->where('enable', true);
    }

    /**
     * 활성화된 카테고리만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 최상위 카테고리만 조회
     */
    public function scopeRootCategories($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * 하위 카테고리만 조회
     */
    public function scopeSubCategories($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * 코드로 조회
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    /**
     * Slug로 조회
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * 검색
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', '%' . $keyword . '%')
              ->orWhere('code', 'like', '%' . $keyword . '%')
              ->orWhere('description', 'like', '%' . $keyword . '%');
        });
    }

    /**
     * 카테고리 경로 (부모 > 자식)
     */
    public function getPathAttribute()
    {
        $path = collect();
        $category = $this;

        while ($category) {
            $path->prepend($category->title);
            $category = $category->parent;
        }

        return $path->implode(' > ');
    }

    /**
     * 카테고리 깊이
     */
    public function getDepthAttribute()
    {
        $depth = 0;
        $category = $this->parent;

        while ($category) {
            $depth++;
            $category = $category->parent;
        }

        return $depth;
    }

    /**
     * 하위 카테고리 개수
     */
    public function getChildrenCountAttribute()
    {
        return $this->children()->count();
    }

    /**
     * 카테고리에 속한 상품 개수
     */
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }
}