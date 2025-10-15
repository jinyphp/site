<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 사이트 메뉴 모델
 */
class SiteMenu extends Model
{
    /**
     * 테이블명
     *
     * @var string
     */
    protected $table = 'site_menus';

    /**
     * 대량 할당 가능한 속성
     *
     * @var array
     */
    protected $fillable = [
        'enable',
        'code',
        'description',
        'blade',
        'manager',
    ];

    /**
     * 속성 캐스팅
     *
     * @var array
     */
    protected $casts = [
        'enable' => 'boolean',
    ];

    /**
     * 메뉴 아이템 관계
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(SiteMenuItem::class, 'menu_id');
    }
}
