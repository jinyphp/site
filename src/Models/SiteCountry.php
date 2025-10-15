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
    protected $table = 'site_countries';

    /**
     * 대량 할당 가능한 속성
     *
     * @var array
     */
    protected $fillable = [
        'enable',
        'code',
        'name',
        'name_ko',
        'native_name',
        'description',
        'capital',
        'currency',
        'currency_code',
        'tax_rate',
        'tax_name',
        'tax_description',
        'continent',
        'timezone',
        'phone_code',
        'flag',
        'region',
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
        'tax_rate' => 'decimal:4',
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

    /**
     * 활성화된 국가만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 기본 국가 조회
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * 통화 정보와의 관계
     */
    public function currencyInfo()
    {
        return $this->belongsTo(SiteCurrency::class, 'currency_code', 'code');
    }

    /**
     * 기본 국가 가져오기
     */
    public static function getDefaultCountry()
    {
        return static::default()->first();
    }

    /**
     * 국가 코드로 국가 정보 가져오기
     */
    public static function findByCode($code)
    {
        return static::where('code', $code)->first();
    }

    /**
     * 세율을 백분율로 변환
     */
    public function getTaxRatePercentageAttribute()
    {
        return $this->tax_rate * 100;
    }

    /**
     * 세율 포맷팅
     */
    public function getFormattedTaxRateAttribute()
    {
        return number_format($this->tax_rate_percentage, 2) . '%';
    }

    /**
     * 국가 표시명 (한국어 우선)
     */
    public function getDisplayNameAttribute()
    {
        return $this->name_ko ?: $this->name;
    }
}
