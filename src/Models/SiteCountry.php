<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 사이트 국가 모델
 */
class SiteCountry extends Model
{
    /**
     * 테이블명
     *
     * @var string
     */
    protected $table = 'site_country';

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
}
