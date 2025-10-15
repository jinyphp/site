<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteHelp extends Model
{
    use HasFactory;

    protected $table = 'site_help';

    protected $fillable = [
        'enable',
        'cate',
        'slug',
        'title',
        'content',
        'image',
        'like',
        'manager',
        'pos',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'like' => 'integer',
        'pos' => 'integer',
    ];

    /**
     * 카테고리와의 관계
     */
    public function category()
    {
        return $this->belongsTo(SiteHelpCategory::class, 'cate', 'code');
    }

    /**
     * 활성화된 도움말만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 카테고리별 조회
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('cate', $category);
    }

    /**
     * 검색
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', '%' . $keyword . '%')
              ->orWhere('content', 'like', '%' . $keyword . '%');
        });
    }

    /**
     * 좋아요 증가
     */
    public function incrementLike()
    {
        $this->increment('like');
    }

    /**
     * 내용 요약
     */
    public function getExcerptAttribute($length = 150)
    {
        return \Str::limit(strip_tags($this->content), $length);
    }
}