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
        'code',
        'name',
        'native_name',
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

    /**
     * 기본 정렬
     *
     * @var array
     */
    protected $attributes = [
        'enabled' => true,
    ];
}
