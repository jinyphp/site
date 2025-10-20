<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteServiceCategory extends Model
{
    use HasFactory;

    protected $table = 'site_service_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'sort_order',
        'enable',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * 상위 카테고리 관계
     */
    public function parent()
    {
        return $this->belongsTo(SiteServiceCategory::class, 'parent_id');
    }

    /**
     * 하위 카테고리들 관계
     */
    public function children()
    {
        return $this->hasMany(SiteServiceCategory::class, 'parent_id')->where('enable', true)->orderBy('sort_order');
    }

    /**
     * 카테고리의 서비스들
     */
    public function services()
    {
        return $this->hasMany(SiteService::class, 'category_id');
    }

    /**
     * 활성화된 카테고리만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 최상위 카테고리들 조회
     */
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * 정렬된 카테고리들 조회
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}