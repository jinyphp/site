<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jiny\Site\Services\ExchangeRateService;

class SiteCurrency extends Model
{
    use HasFactory;

    protected $table = 'site_currencies';

    protected $fillable = [
        'code',
        'name',
        'symbol',
        'description',
        'decimal_places',
        'enable',
        'is_base',
        'order',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'is_base' => 'boolean',
        'decimal_places' => 'integer',
        'order' => 'integer',
    ];

    /**
     * 활성화된 통화만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 기준 통화 조회
     */
    public function scopeBase($query)
    {
        return $query->where('is_base', true);
    }

    /**
     * 순서대로 정렬
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /**
     * 통화 코드로 조회
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    /**
     * 기준 통화 가져오기
     */
    public static function getBaseCurrency()
    {
        return static::base()->first();
    }

    /**
     * 활성화된 통화 목록 가져오기
     */
    public static function getActiveCurrencies()
    {
        return static::enabled()->ordered()->get();
    }

    /**
     * 통화 코드로 통화 정보 가져오기
     */
    public static function findByCode($code)
    {
        return static::byCode($code)->first();
    }

    /**
     * 금액을 해당 통화의 소수점 자리수에 맞게 포매팅
     */
    public function formatAmount($amount)
    {
        if ($amount === null) {
            return '0';
        }

        return number_format($amount, $this->decimal_places);
    }

    /**
     * 금액을 통화 기호와 함께 포매팅
     */
    public function formatAmountWithSymbol($amount, $position = 'before')
    {
        $formattedAmount = $this->formatAmount($amount);

        if ($position === 'after') {
            return $formattedAmount . ' ' . $this->symbol;
        }

        return $this->symbol . ' ' . $formattedAmount;
    }

    /**
     * 현재 통화에서 다른 통화로 환전
     */
    public function convertTo($targetCurrencyCode, $amount)
    {
        if ($this->code === $targetCurrencyCode) {
            return $amount;
        }

        $exchangeService = new ExchangeRateService();
        return $exchangeService->convertAmount($amount, $this->code, $targetCurrencyCode);
    }

    /**
     * 다른 통화에서 현재 통화로 환전
     */
    public function convertFrom($sourceCurrencyCode, $amount)
    {
        if ($sourceCurrencyCode === $this->code) {
            return $amount;
        }

        $exchangeService = new ExchangeRateService();
        return $exchangeService->convertAmount($amount, $sourceCurrencyCode, $this->code);
    }

    /**
     * 통화 간 환율 가져오기
     */
    public function getExchangeRateTo($targetCurrencyCode)
    {
        if ($this->code === $targetCurrencyCode) {
            return 1.0;
        }

        $exchangeService = new ExchangeRateService();
        return $exchangeService->getRate($this->code, $targetCurrencyCode);
    }

    /**
     * 통화 정보의 전체 표시명 (코드 + 이름)
     */
    public function getDisplayNameAttribute()
    {
        return $this->code . ' - ' . $this->name;
    }

    /**
     * 통화가 기준 통화인지 확인
     */
    public function getIsBaseCurrencyAttribute()
    {
        return $this->is_base;
    }

    /**
     * 통화가 활성화되어 있는지 확인
     */
    public function getIsActiveAttribute()
    {
        return $this->enable;
    }

    /**
     * 해당 통화를 사용하는 국가들과의 관계
     */
    public function countries()
    {
        return $this->hasMany(SiteCountry::class, 'currency_code', 'code');
    }

    /**
     * 해당 통화를 사용하는 상품 가격 옵션들과의 관계
     */
    public function productPricingOptions()
    {
        return $this->hasMany(SiteProductPricing::class, 'currency', 'code');
    }

    /**
     * 해당 통화를 사용하는 서비스 가격 옵션들과의 관계
     */
    public function servicePricingOptions()
    {
        return $this->hasMany(SiteServicePricing::class, 'currency', 'code');
    }

    /**
     * 환율 정보 (from currency)
     */
    public function exchangeRatesFrom()
    {
        return $this->hasMany(SiteExchangeRate::class, 'from_currency', 'code');
    }

    /**
     * 환율 정보 (to currency)
     */
    public function exchangeRatesTo()
    {
        return $this->hasMany(SiteExchangeRate::class, 'to_currency', 'code');
    }

    /**
     * 통화 선택을 위한 옵션 배열 생성
     */
    public static function getSelectOptions($includeDisabled = false)
    {
        $query = static::query();

        if (!$includeDisabled) {
            $query->enabled();
        }

        return $query->ordered()
                    ->get()
                    ->pluck('display_name', 'code')
                    ->toArray();
    }

    /**
     * 기본 통화 설정
     */
    public function setAsBase()
    {
        // 기존 기준 통화 해제
        static::where('is_base', true)->update(['is_base' => false]);

        // 현재 통화를 기준으로 설정
        $this->is_base = true;
        $this->save();

        return $this;
    }

    /**
     * 통화 활성화/비활성화
     */
    public function toggleStatus()
    {
        $this->enable = !$this->enable;
        $this->save();

        return $this;
    }

    /**
     * 정렬 순서 업데이트
     */
    public function updateOrder($newOrder)
    {
        $this->order = $newOrder;
        $this->save();

        return $this;
    }

    /**
     * 통화 정보 유효성 검사
     */
    public function isValid()
    {
        return !empty($this->code) &&
               !empty($this->name) &&
               !empty($this->symbol) &&
               $this->decimal_places >= 0;
    }

    /**
     * 통화 설정 요약 정보
     */
    public function getSummaryAttribute()
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'decimal_places' => $this->decimal_places,
            'is_base' => $this->is_base,
            'is_active' => $this->enable,
            'countries_count' => $this->countries()->count(),
        ];
    }
}