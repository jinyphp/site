<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 사이트 레이아웃 모델
 */
class SiteLayout extends Model
{
    /**
     * 테이블명
     *
     * @var string
     */
    protected $table = 'site_layouts';

    /**
     * 대량 할당 가능한 속성
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'path',
        'description',
        'preview',
        'enabled',
    ];

    /**
     * 속성 캐스팅
     *
     * @var array
     */
    protected $casts = [
        'enabled' => 'boolean',
    ];
}
