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
        'code',
        'menu_id',
        'enable',
        'header',
        'title',
        'name',
        'icon',
        'href',
        'target',
        'selected',
        'submenu',
        'ref',
        'level',
        'pos',
        'description',
        'user_id',
    ];

    /**
     * 속성 캐스팅
     *
     * @var array
     */
    protected $casts = [
        'enable' => 'boolean',
        'level' => 'integer',
        'pos' => 'integer',
        'ref' => 'integer',
        'menu_id' => 'integer',
        'user_id' => 'integer',
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
        return $this->belongsTo(SiteMenuItem::class, 'ref');
    }

    /**
     * 자식 메뉴 아이템 관계
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(SiteMenuItem::class, 'ref', 'id')->orderBy('pos');
    }

    /**
     * 메뉴 아이템을 트리 구조로 가져오기
     *
     * @param int $menuId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getTree($menuId = null)
    {
        $query = self::with('children')
            ->where('ref', 0)
            ->orderBy('pos');

        if ($menuId) {
            $query->where('menu_id', $menuId);
        }

        return $query->get();
    }

    /**
     * 다음 위치 값 가져오기
     *
     * @param int $ref
     * @param int $menuId
     * @return int
     */
    public static function getNextPosition($ref = 0, $menuId = null)
    {
        $query = self::where('ref', $ref);

        if ($menuId) {
            $query->where('menu_id', $menuId);
        }

        return $query->max('pos') + 1;
    }
}
