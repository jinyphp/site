<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteHelpCategory extends Model
{
    use HasFactory;

    protected $table = 'site_help_cate';

    protected $fillable = [
        'enable',
        'code',
        'icon',
        'title',
        'content',
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
     * 도움말과의 관계
     */
    public function helps()
    {
        return $this->hasMany(SiteHelp::class, 'cate', 'code');
    }

    /**
     * 활성화된 도움말과의 관계
     */
    public function enabledHelps()
    {
        return $this->hasMany(SiteHelp::class, 'cate', 'code')
                    ->where('enable', true)
                    ->orderBy('pos');
    }

    /**
     * 활성화된 카테고리만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 코드로 조회
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    /**
     * 도움말 개수
     */
    public function getHelpCountAttribute()
    {
        return $this->enabledHelps()->count();
    }
}