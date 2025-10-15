<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteFaq extends Model
{
    use HasFactory;

    protected $table = 'site_faq';

    protected $fillable = [
        'enable',
        'cate',
        'question',
        'answer',
        'image',
        'manager',
        'like',
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
        return $this->belongsTo(SiteFaqCategory::class, 'cate', 'code');
    }

    /**
     * 활성화된 FAQ만 조회
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
            $q->where('question', 'like', '%' . $keyword . '%')
              ->orWhere('answer', 'like', '%' . $keyword . '%');
        });
    }

    /**
     * 인기 FAQ (좋아요 순)
     */
    public function scopePopular($query, $limit = 5)
    {
        return $query->orderBy('like', 'desc')->limit($limit);
    }

    /**
     * 좋아요 증가
     */
    public function incrementLike()
    {
        $this->increment('like');
    }

    /**
     * 답변 요약
     */
    public function getAnswerExcerptAttribute($length = 100)
    {
        return \Str::limit(strip_tags($this->answer), $length);
    }
}