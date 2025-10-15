<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 사이트 언어 모델
 */
class SiteLanguage extends Model
{
    /**
     * 테이블명
     *
     * @var string
     */
    protected $table = 'site_language';

    /**
     * 대량 할당 가능한 속성
     *
     * @var array
     */
    protected $fillable = [
        'enable',
        'lang',
        'name',
        'native_name',
        'locale',
        'description',
        'flag',
        'manager',
        'order',
        'is_default',
    ];

    /**
     * 속성 캐스팅
     *
     * @var array
     */
    protected $casts = [
        'enable' => 'boolean',
        'is_default' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * 기본 정렬
     *
     * @var array
     */
    protected $attributes = [
        'enable' => true,
        'is_default' => false,
        'order' => 0,
    ];
}
