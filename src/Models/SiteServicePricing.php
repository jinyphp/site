<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jiny\Site\Services\ExchangeRateService;

class SiteServicePricing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'site_service_pricing';

    protected $fillable = [
        'service_id',
        'enable',
        'pos',
        'name',
        'code',
        'description',
        'price',
        'sale_price',
        'currency',
        'duration',
        'included_services',
        'deliverables',
        'revisions',
        'rush_available',
        'rush_fee',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'pos' => 'integer',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'rush_fee' => 'decimal:2',
        'included_services' => 'array',
        'deliverables' => 'array',
        'revisions' => 'array',
        'rush_available' => 'boolean',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * 소속 서비스와의 관계
     */
    public function service()
    {
        return $this->belongsTo(SiteService::class, 'service_id');
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
     * 포맷된 급행 비용
     */
    public function getFormattedRushFeeAttribute()
    {
        if (!$this->rush_fee) {
            return null;
        }
        $symbol = $this->currency === 'KRW' ? '₩' : '$';
        return $symbol . number_format($this->rush_fee);
    }

    /**
     * 포함된 서비스 개수
     */
    public function getIncludedServicesCountAttribute()
    {
        return is_array($this->included_services) ? count($this->included_services) : 0;
    }

    /**
     * 결과물 개수
     */
    public function getDeliverablesCountAttribute()
    {
        return is_array($this->deliverables) ? count($this->deliverables) : 0;
    }

    /**
     * 통화 정보와의 관계
     */
    public function currencyInfo()
    {
        return $this->belongsTo(SiteCurrency::class, 'currency', 'code');
    }

    /**
     * 특정 통화로 가격 계산 (급행 비용 포함)
     */
    public function calculatePrice($targetCurrency = null, $userCountryCode = null, $includeRushFee = false)
    {
        $basePrice = $this->current_price;
        $baseCurrency = $this->currency;
        $targetCurrency = $targetCurrency ?: $baseCurrency;

        // 급행 비용 추가
        if ($includeRushFee && $this->rush_available && $this->rush_fee) {
            $basePrice += $this->rush_fee;
        }

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
            'base_price' => $this->current_price,
            'rush_fee' => $includeRushFee && $this->rush_available ? $this->rush_fee : 0,
            'base_price_with_rush' => $basePrice,
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
     * 특정 통화로 포맷된 가격 (급행 비용 옵션)
     */
    public function getFormattedPriceInCurrency($targetCurrency = null, $userCountryCode = null, $includeRushFee = false)
    {
        $pricing = $this->calculatePrice($targetCurrency, $userCountryCode, $includeRushFee);
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
    public function getFormattedPriceExcludingTax($targetCurrency = null, $includeRushFee = false)
    {
        $pricing = $this->calculatePrice($targetCurrency, null, $includeRushFee);
        $currencyInfo = $pricing['currency_info'];

        if ($currencyInfo) {
            return $currencyInfo->formatAmountWithSymbol($pricing['converted_price']);
        }

        // 기본 포맷팅
        $symbol = $this->getCurrencySymbol($pricing['target_currency']);
        return $symbol . number_format($pricing['converted_price'], 2);
    }

    /**
     * 급행 비용 포맷팅 (특정 통화)
     */
    public function getFormattedRushFeeInCurrency($targetCurrency = null)
    {
        if (!$this->rush_available || !$this->rush_fee) {
            return null;
        }

        $baseCurrency = $this->currency;
        $targetCurrency = $targetCurrency ?: $baseCurrency;
        $rushFee = $this->rush_fee;

        // 환율 적용
        if ($baseCurrency !== $targetCurrency) {
            $exchangeService = new ExchangeRateService();
            $rushFee = $exchangeService->convertAmount(
                $this->rush_fee,
                $baseCurrency,
                $targetCurrency
            ) ?: $this->rush_fee;
        }

        $currencyInfo = $this->getCurrencyInfo($targetCurrency);
        if ($currencyInfo) {
            return $currencyInfo->formatAmountWithSymbol($rushFee);
        }

        // 기본 포맷팅
        $symbol = $this->getCurrencySymbol($targetCurrency);
        return $symbol . number_format($rushFee, 2);
    }

    /**
     * 세금 금액 포맷팅
     */
    public function getFormattedTaxAmount($targetCurrency = null, $userCountryCode = null, $includeRushFee = false)
    {
        $pricing = $this->calculatePrice($targetCurrency, $userCountryCode, $includeRushFee);
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
     * 다중 통화 가격 정보 (급행 옵션 포함)
     */
    public function getMultiCurrencyPricing($currencies = null, $userCountryCode = null, $includeRushFee = false)
    {
        $currencies = $currencies ?: SiteCurrency::getActiveCurrencies()->pluck('code')->toArray();
        $result = [];

        foreach ($currencies as $currency) {
            $result[$currency] = $this->calculatePrice($currency, $userCountryCode, $includeRushFee);
        }

        return $result;
    }

    /**
     * 서비스 가격 비교 (다른 패키지와)
     */
    public function comparePricing($otherPricing, $targetCurrency = null, $userCountryCode = null, $includeRushFee = false)
    {
        $thisPricing = $this->calculatePrice($targetCurrency, $userCountryCode, $includeRushFee);
        $otherPricingData = $otherPricing->calculatePrice($targetCurrency, $userCountryCode, $includeRushFee);

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
            'rush_fee_included' => $includeRushFee,
        ];
    }

    /**
     * 급행 서비스 가능 여부
     */
    public function hasRushService()
    {
        return $this->rush_available && $this->rush_fee > 0;
    }

    /**
     * 급행 추가 비용 계산
     */
    public function getRushFeeOnly($targetCurrency = null)
    {
        if (!$this->hasRushService()) {
            return 0;
        }

        $baseCurrency = $this->currency;
        $targetCurrency = $targetCurrency ?: $baseCurrency;
        $rushFee = $this->rush_fee;

        if ($baseCurrency !== $targetCurrency) {
            $exchangeService = new ExchangeRateService();
            $rushFee = $exchangeService->convertAmount(
                $this->rush_fee,
                $baseCurrency,
                $targetCurrency
            ) ?: $this->rush_fee;
        }

        return $rushFee;
    }

    /**
     * 통화별 조회
     */
    public function scopeByCurrency($query, $currency)
    {
        return $query->where('currency', $currency);
    }

    /**
     * 급행 서비스 가능한 패키지만 조회
     */
    public function scopeRushAvailable($query)
    {
        return $query->where('rush_available', true)->where('rush_fee', '>', 0);
    }

    /**
     * 가격 범위로 조회 (특정 통화 기준, 급행 비용 옵션)
     */
    public function scopePriceRangeInCurrency($query, $min = null, $max = null, $currency = null, $includeRushFee = false)
    {
        if (!$currency) {
            $currency = config('site.base_currency', 'KRW');
        }

        return $query->where(function ($q) use ($min, $max, $currency, $includeRushFee) {
            $q->where('currency', $currency);

            if ($min !== null) {
                $q->where(function ($sq) use ($min, $includeRushFee) {
                    if ($includeRushFee) {
                        // 급행 비용 포함 시 계산 로직 (복잡하므로 기본 가격으로만 필터링)
                        $sq->where('sale_price', '>=', $min)
                          ->orWhere(function ($ssq) use ($min) {
                              $ssq->whereNull('sale_price')->where('price', '>=', $min);
                          });
                    } else {
                        $sq->where('sale_price', '>=', $min)
                          ->orWhere(function ($ssq) use ($min) {
                              $ssq->whereNull('sale_price')->where('price', '>=', $min);
                          });
                    }
                });
            }

            if ($max !== null) {
                $q->where(function ($sq) use ($max, $includeRushFee) {
                    if ($includeRushFee) {
                        // 급행 비용 포함 시 계산 로직
                        $sq->where('sale_price', '<=', $max)
                          ->orWhere(function ($ssq) use ($max) {
                              $ssq->whereNull('sale_price')->where('price', '<=', $max);
                          });
                    } else {
                        $sq->where('sale_price', '<=', $max)
                          ->orWhere(function ($ssq) use ($max) {
                              $ssq->whereNull('sale_price')->where('price', '<=', $max);
                          });
                    }
                });
            }
        });
    }

    /**
     * 서비스 기간별 조회
     */
    public function scopeByDuration($query, $duration)
    {
        return $query->where('duration', 'like', '%' . $duration . '%');
    }
}