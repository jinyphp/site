<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 사이트 약관 모델
 */
class SiteTerms extends Model
{
    /**
     * 테이블명
     *
     * @var string
     */
    protected $table = 'site_terms';

    /**
     * 대량 할당 가능한 속성
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'title',
        'content',
        'version',
        'required',
        'enabled',
    ];

    /**
     * 속성 캐스팅
     *
     * @var array
     */
    protected $casts = [
        'required' => 'boolean',
        'enabled' => 'boolean',
    ];
}
