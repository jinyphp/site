<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jiny\Site\Services\ExchangeRateService;

class SiteProductPricing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'site_product_pricing';

    protected $fillable = [
        'product_id',
        'enable',
        'pos',
        'name',
        'code',
        'description',
        'price',
        'sale_price',
        'currency',
        'billing_period',
        'features',
        'limitations',
        'min_quantity',
        'max_quantity',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'pos' => 'integer',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'features' => 'array',
        'limitations' => 'array',
        'min_quantity' => 'integer',
        'max_quantity' => 'integer',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * 소속 상품과의 관계
     */
    public function product()
    {
        return $this->belongsTo(SiteProduct::class, 'product_id');
    }

    /**
     * 활성화된 가격 옵션만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 할인 여부 확인
     */
    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    /**
     * 할인율 계산
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->is_on_sale) {
            return 0;
        }
        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    /**
     * 현재 가격 (할인가 우선)
     */
    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?: $this->price;
    }

    /**
     * 포맷된 가격
     */
    public function getFormattedPriceAttribute()
    {
        $symbol = $this->currency === 'KRW' ? '₩' : '$';
        return $symbol . number_format($this->current_price);
    }

    /**
     * 포맷된 원가 (할인가가 있을 때)
     */
    public function getFormattedOriginalPriceAttribute()
    {
        if (!$this->is_on_sale) {
            return null;
        }
        $symbol = $this->currency === 'KRW' ? '₩' : '$';
        return $symbol . number_format($this->price);
    }

    /**
     * 결제 주기 텍스트
     */
    public function getBillingPeriodTextAttribute()
    {
        $periods = [
            'once' => '일시결제',
            'monthly' => '월 결제',
            'yearly' => '연 결제',
            'quarterly' => '분기 결제',
        ];

        return $periods[$this->billing_period] ?? $this->billing_period;
    }

    /**
     * 통화 정보와의 관계
     */
    public function currencyInfo()
    {
        return $this->belongsTo(SiteCurrency::class, 'currency', 'code');
    }

    /**
     * 특정 통화로 가격 계산
     */
    public function calculatePrice($targetCurrency = null, $userCountryCode = null)
    {
        $basePrice = $this->current_price;
        $baseCurrency = $this->currency;
        $targetCurrency = $targetCurrency ?: $baseCurrency;

        // 1. 환율 적용 (통화 변환)
        $convertedPrice = $basePrice;
        if ($baseCurrency !== $targetCurrency) {
            $exchangeService = new ExchangeRateService();
            $convertedPrice = $exchangeService->convertAmount(
                $basePrice,
                $baseCurrency,
                $targetCurrency
            ) ?: $basePrice;
        }

        // 2. 세율 적용
        $taxRate = $this->getTaxRate($userCountryCode);
        $taxAmount = $convertedPrice * $taxRate;
        $totalPrice = $convertedPrice + $taxAmount;

        return [
            'base_price' => $basePrice,
            'base_currency' => $baseCurrency,
            'converted_price' => $convertedPrice,
            'target_currency' => $targetCurrency,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total_price' => $totalPrice,
            'currency_info' => $this->getCurrencyInfo($targetCurrency),
        ];
    }

    /**
     * 국가별 세율 가져오기
     */
    protected function getTaxRate($countryCode = null)
    {
        if (!$countryCode) {
            // 기본 국가의 세율 사용
            $defaultCountry = \DB::table('site_countries')
                ->where('is_default', true)
                ->first();

            return $defaultCountry ? $defaultCountry->tax_rate : 0;
        }

        $country = \DB::table('site_countries')
            ->where('code', $countryCode)
            ->first();

        return $country ? $country->tax_rate : 0;
    }

    /**
     * 통화 정보 가져오기
     */
    protected function getCurrencyInfo($currencyCode)
    {
        return SiteCurrency::findByCode($currencyCode);
    }

    /**
     * 특정 통화로 포맷된 가격
     */
    public function getFormattedPriceInCurrency($targetCurrency = null, $userCountryCode = null)
    {
        $pricing = $this->calculatePrice($targetCurrency, $userCountryCode);
        $currencyInfo = $pricing['currency_info'];

        if ($currencyInfo) {
            return $currencyInfo->formatAmountWithSymbol($pricing['total_price']);
        }

        // 기본 포맷팅
        $symbol = $this->getCurrencySymbol($pricing['target_currency']);
        return $symbol . number_format($pricing['total_price'], 2);
    }

    /**
     * 세금 별도 가격 포맷팅
     */
    public function getFormattedPriceExcludingTax($targetCurrency = null)
    {
        $pricing = $this->calculatePrice($targetCurrency);
        $currencyInfo = $pricing['currency_info'];

        if ($currencyInfo) {
            return $currencyInfo->formatAmountWithSymbol($pricing['converted_price']);
        }

        // 기본 포맷팅
        $symbol = $this->getCurrencySymbol($pricing['target_currency']);
        return $symbol . number_format($pricing['converted_price'], 2);
    }

    /**
     * 세금 금액 포맷팅
     */
    public function getFormattedTaxAmount($targetCurrency = null, $userCountryCode = null)
    {
        $pricing = $this->calculatePrice($targetCurrency, $userCountryCode);
        $currencyInfo = $pricing['currency_info'];

        if ($currencyInfo) {
            return $currencyInfo->formatAmountWithSymbol($pricing['tax_amount']);
        }

        // 기본 포맷팅
        $symbol = $this->getCurrencySymbol($pricing['target_currency']);
        return $symbol . number_format($pricing['tax_amount'], 2);
    }

    /**
     * 통화 기호 가져오기
     */
    private function getCurrencySymbol($currencyCode)
    {
        $symbols = [
            'KRW' => '₩',
            'USD' => '$',
            'EUR' => '€',
            'JPY' => '¥',
            'GBP' => '£',
            'CNY' => '¥',
        ];

        return $symbols[$currencyCode] ?? '$';
    }

    /**
     * 다중 통화 가격 정보
     */
    public function getMultiCurrencyPricing($currencies = null, $userCountryCode = null)
    {
        $currencies = $currencies ?: SiteCurrency::getActiveCurrencies()->pluck('code')->toArray();
        $result = [];

        foreach ($currencies as $currency) {
            $result[$currency] = $this->calculatePrice($currency, $userCountryCode);
        }

        return $result;
    }

    /**
     * 가격 비교 (다른 옵션과)
     */
    public function comparePricing($otherPricing, $targetCurrency = null, $userCountryCode = null)
    {
        $thisPricing = $this->calculatePrice($targetCurrency, $userCountryCode);
        $otherPricingData = $otherPricing->calculatePrice($targetCurrency, $userCountryCode);

        $difference = $thisPricing['total_price'] - $otherPricingData['total_price'];
        $percentageDifference = $otherPricingData['total_price'] > 0
            ? ($difference / $otherPricingData['total_price']) * 100
            : 0;

        return [
            'this_price' => $thisPricing['total_price'],
            'other_price' => $otherPricingData['total_price'],
            'difference' => $difference,
            'percentage_difference' => $percentageDifference,
            'is_cheaper' => $difference < 0,
            'is_more_expensive' => $difference > 0,
            'currency' => $targetCurrency ?: $this->currency,
        ];
    }

    /**
     * 통화별 조회
     */
    public function scopeByCurrency($query, $currency)
    {
        return $query->where('currency', $currency);
    }

    /**
     * 가격 범위로 조회 (특정 통화 기준)
     */
    public function scopePriceRangeInCurrency($query, $min = null, $max = null, $currency = null, $userCountryCode = null)
    {
        if (!$currency) {
            $currency = config('site.base_currency', 'KRW');
        }

        return $query->where(function ($q) use ($min, $max, $currency, $userCountryCode) {
            $q->where('currency', $currency);

            if ($min !== null) {
                $q->where(function ($sq) use ($min) {
                    $sq->where('sale_price', '>=', $min)
                      ->orWhere(function ($ssq) use ($min) {
                          $ssq->whereNull('sale_price')->where('price', '>=', $min);
                      });
                });
            }

            if ($max !== null) {
                $q->where(function ($sq) use ($max) {
                    $sq->where('sale_price', '<=', $max)
                      ->orWhere(function ($ssq) use ($max) {
                          $ssq->whereNull('sale_price')->where('price', '<=', $max);
                      });
                });
            }
        });
    }
}