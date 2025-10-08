<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 사이트 메뉴 아이템 모델
 */
class SiteMenuItem extends Model
{
    /**
     * 테이블명
     *
     * @var string
     */
    protected $table = 'site_menu_items';

    /**
     * 대량 할당 가능한 속성
     *
     * @var array
     */
    protected $fillable = [
        'menu_id',
        'title',
        'url',
        'target',
        'icon',
        'order',
        'parent_id',
        'enabled',
    ];

    /**
     * 속성 캐스팅
     *
     * @var array
     */
    protected $casts = [
        'enabled' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * 메뉴 관계
     *
     * @return BelongsTo
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(SiteMenu::class, 'menu_id');
    }

    /**
     * 부모 메뉴 아이템 관계
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(SiteMenuItem::class, 'parent_id');
    }

    /**
     * 자식 메뉴 아이템 관계
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(SiteMenuItem::class, 'parent_id');
    }
}
