<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jiny\Site\Services\ExchangeRateService;

class SiteCart extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'site_cart';

    protected $fillable = [
        'user_id',
        'session_id',
        'item_type',
        'item_id',
        'pricing_option_id',
        'quantity',
        'options',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'options' => 'array',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * 사용자와의 관계
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * 상품과의 관계 (동적)
     */
    public function item()
    {
        switch ($this->item_type) {
            case 'product':
                return $this->belongsTo(SiteProduct::class, 'item_id');
            case 'service':
                return $this->belongsTo(SiteService::class, 'item_id');
            default:
                return null;
        }
    }

    /**
     * 상품 가격 옵션과의 관계
     */
    public function productPricingOption()
    {
        return $this->belongsTo(SiteProductPricing::class, 'pricing_option_id');
    }

    /**
     * 서비스 가격 옵션과의 관계
     */
    public function servicePricingOption()
    {
        return $this->belongsTo(SiteServicePricing::class, 'pricing_option_id');
    }

    /**
     * 가격 옵션 가져오기 (동적)
     */
    public function getPricingOptionAttribute()
    {
        if (!$this->pricing_option_id) {
            return null;
        }

        switch ($this->item_type) {
            case 'product':
                return $this->productPricingOption;
            case 'service':
                return $this->servicePricingOption;
            default:
                return null;
        }
    }

    /**
     * 아이템 정보 가져오기 (동적)
     */
    public function getItemDetailsAttribute()
    {
        switch ($this->item_type) {
            case 'product':
                return SiteProduct::find($this->item_id);
            case 'service':
                return SiteService::find($this->item_id);
            default:
                return null;
        }
    }

    /**
     * 기본 가격 가져오기 (옵션 또는 아이템의 기본 가격)
     */
    public function getBasePriceAttribute()
    {
        $pricingOption = $this->pricing_option;
        if ($pricingOption) {
            return $pricingOption->sale_price ?: $pricingOption->price;
        }

        $item = $this->item_details;
        if ($item) {
            return $item->sale_price ?: $item->price;
        }

        return 0;
    }

    /**
     * 기본 통화 가져오기
     */
    public function getBaseCurrencyAttribute()
    {
        $pricingOption = $this->pricing_option;
        if ($pricingOption && isset($pricingOption->currency)) {
            return $pricingOption->currency;
        }

        return config('site.base_currency', 'KRW');
    }

    /**
     * 특정 통화로 가격 계산
     */
    public function calculatePrice($targetCurrency = null, $userCountryCode = null)
    {
        $basePrice = $this->base_price;
        $baseCurrency = $this->base_currency;
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
            'quantity' => $this->quantity,
            'subtotal' => $totalPrice * $this->quantity,
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
     * 카트 아이템의 총 가격 계산 (세율 포함)
     */
    public function getTotalPriceWithTaxAttribute()
    {
        $pricing = $this->calculatePrice();
        return $pricing['subtotal'];
    }

    /**
     * 카트 아이템의 세금 금액
     */
    public function getTaxAmountAttribute()
    {
        $pricing = $this->calculatePrice();
        return $pricing['tax_amount'] * $this->quantity;
    }

    /**
     * 카트 아이템 제목
     */
    public function getTitleAttribute()
    {
        $item = $this->item_details;
        $title = $item ? $item->title : 'Unknown Item';

        $pricingOption = $this->pricing_option;
        if ($pricingOption) {
            $title .= ' (' . $pricingOption->name . ')';
        }

        return $title;
    }

    /**
     * 사용자별 카트 조회
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * 세션별 카트 조회 (비로그인 사용자)
     */
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId)->whereNull('user_id');
    }

    /**
     * 사용자 또는 세션별 카트 조회
     */
    public function scopeForUserOrSession($query, $userId = null, $sessionId = null)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }

        if ($sessionId) {
            return $query->where('session_id', $sessionId)->whereNull('user_id');
        }

        return $query->whereRaw('1 = 0'); // 빈 결과
    }

    /**
     * 아이템 타입별 조회
     */
    public function scopeByItemType($query, $itemType)
    {
        return $query->where('item_type', $itemType);
    }

    /**
     * 특정 상품/서비스 조회
     */
    public function scopeByItem($query, $itemType, $itemId)
    {
        return $query->where('item_type', $itemType)
                    ->where('item_id', $itemId);
    }

    /**
     * 카트에 동일한 상품이 있는지 확인
     */
    public static function findExisting($userId, $sessionId, $itemType, $itemId, $pricingOptionId = null)
    {
        $query = static::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId)->whereNull('user_id');
        }

        $query->where('item_type', $itemType)
              ->where('item_id', $itemId);

        if ($pricingOptionId) {
            $query->where('pricing_option_id', $pricingOptionId);
        } else {
            $query->whereNull('pricing_option_id');
        }

        return $query->first();
    }

    /**
     * 카트에 상품 추가 또는 수량 업데이트
     */
    public static function addOrUpdate($userId, $sessionId, $itemType, $itemId, $quantity = 1, $pricingOptionId = null, $options = [])
    {
        $existing = self::findExisting($userId, $sessionId, $itemType, $itemId, $pricingOptionId);

        if ($existing) {
            $existing->quantity += $quantity;
            $existing->options = array_merge($existing->options ?: [], $options);
            $existing->save();
            return $existing;
        }

        return self::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'item_type' => $itemType,
            'item_id' => $itemId,
            'pricing_option_id' => $pricingOptionId,
            'quantity' => $quantity,
            'options' => $options,
        ]);
    }

    /**
     * 비로그인 사용자의 카트를 로그인 사용자로 이전
     */
    public static function transferSessionToUser($sessionId, $userId)
    {
        $sessionCarts = self::where('session_id', $sessionId)
                           ->whereNull('user_id')
                           ->get();

        foreach ($sessionCarts as $sessionCart) {
            $existing = self::findExisting(
                $userId,
                null,
                $sessionCart->item_type,
                $sessionCart->item_id,
                $sessionCart->pricing_option_id
            );

            if ($existing) {
                $existing->quantity += $sessionCart->quantity;
                $existing->options = array_merge($existing->options ?: [], $sessionCart->options ?: []);
                $existing->save();
                $sessionCart->delete();
            } else {
                $sessionCart->user_id = $userId;
                $sessionCart->session_id = null;
                $sessionCart->save();
            }
        }
    }
}