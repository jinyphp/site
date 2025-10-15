<?php

namespace Jiny\Site\Services;

use Jiny\Site\Models\SiteCart;
use Jiny\Site\Models\SiteCurrency;
use Jiny\Site\Models\SiteProduct;
use Jiny\Site\Models\SiteService;
use Illuminate\Support\Collection;

/**
 * 카트 가격 계산 서비스
 * 통화 변환, 세율 적용, 할인 등을 처리
 */
class CartPricingService
{
    protected $exchangeRateService;
    protected $baseCurrency;

    public function __construct()
    {
        $this->exchangeRateService = new ExchangeRateService();
        $this->baseCurrency = config('site.base_currency', 'KRW');
    }

    /**
     * 카트 전체 가격 계산
     */
    public function calculateCartTotal($userId = null, $sessionId = null, $targetCurrency = null, $userCountryCode = null)
    {
        $cartItems = $this->getCartItems($userId, $sessionId);
        $targetCurrency = $targetCurrency ?: $this->baseCurrency;

        $summary = [
            'items' => [],
            'subtotal' => 0,
            'total_tax' => 0,
            'total_amount' => 0,
            'currency' => $targetCurrency,
            'currency_info' => SiteCurrency::findByCode($targetCurrency),
            'item_count' => $cartItems->count(),
            'total_quantity' => 0,
        ];

        foreach ($cartItems as $cartItem) {
            $itemPricing = $this->calculateCartItemPrice($cartItem, $targetCurrency, $userCountryCode);

            $summary['items'][] = $itemPricing;
            $summary['subtotal'] += $itemPricing['subtotal_excluding_tax'];
            $summary['total_tax'] += $itemPricing['total_tax_amount'];
            $summary['total_amount'] += $itemPricing['subtotal'];
            $summary['total_quantity'] += $cartItem->quantity;
        }

        // 세율 요약 정보
        $summary['tax_summary'] = $this->calculateTaxSummary($cartItems, $targetCurrency, $userCountryCode);

        return $summary;
    }

    /**
     * 개별 카트 아이템 가격 계산
     */
    public function calculateCartItemPrice(SiteCart $cartItem, $targetCurrency = null, $userCountryCode = null)
    {
        $targetCurrency = $targetCurrency ?: $this->baseCurrency;
        $pricingData = $cartItem->calculatePrice($targetCurrency, $userCountryCode);

        return [
            'cart_item_id' => $cartItem->id,
            'item_type' => $cartItem->item_type,
            'item_id' => $cartItem->item_id,
            'pricing_option_id' => $cartItem->pricing_option_id,
            'quantity' => $cartItem->quantity,
            'title' => $cartItem->title,
            'unit_price' => $pricingData['converted_price'],
            'unit_price_with_tax' => $pricingData['total_price'],
            'unit_tax_amount' => $pricingData['tax_amount'],
            'subtotal_excluding_tax' => $pricingData['converted_price'] * $cartItem->quantity,
            'total_tax_amount' => $pricingData['tax_amount'] * $cartItem->quantity,
            'subtotal' => $pricingData['total_price'] * $cartItem->quantity,
            'tax_rate' => $pricingData['tax_rate'],
            'base_currency' => $pricingData['base_currency'],
            'target_currency' => $targetCurrency,
            'pricing_data' => $pricingData,
        ];
    }

    /**
     * 카트 아이템 목록 가져오기
     */
    protected function getCartItems($userId = null, $sessionId = null)
    {
        return SiteCart::forUserOrSession($userId, $sessionId)
                      ->with(['item', 'pricingOption'])
                      ->get();
    }

    /**
     * 세율 요약 계산
     */
    protected function calculateTaxSummary($cartItems, $targetCurrency, $userCountryCode = null)
    {
        $taxSummary = [];

        foreach ($cartItems as $cartItem) {
            $pricingData = $cartItem->calculatePrice($targetCurrency, $userCountryCode);
            $taxRate = $pricingData['tax_rate'];
            $taxAmount = $pricingData['tax_amount'] * $cartItem->quantity;

            $country = $this->getCountryInfo($userCountryCode);
            $taxName = $country ? $country->tax_name : 'Tax';

            if (!isset($taxSummary[$taxRate])) {
                $taxSummary[$taxRate] = [
                    'tax_rate' => $taxRate,
                    'tax_name' => $taxName,
                    'tax_amount' => 0,
                    'taxable_amount' => 0,
                ];
            }

            $taxSummary[$taxRate]['tax_amount'] += $taxAmount;
            $taxSummary[$taxRate]['taxable_amount'] += $pricingData['converted_price'] * $cartItem->quantity;
        }

        return array_values($taxSummary);
    }

    /**
     * 국가 정보 가져오기
     */
    protected function getCountryInfo($countryCode = null)
    {
        if (!$countryCode) {
            return \DB::table('site_countries')->where('is_default', true)->first();
        }

        return \DB::table('site_countries')->where('code', $countryCode)->first();
    }

    /**
     * 다중 통화 가격 비교
     */
    public function getMultiCurrencyPricing($userId = null, $sessionId = null, $currencies = null, $userCountryCode = null)
    {
        $currencies = $currencies ?: SiteCurrency::getActiveCurrencies()->pluck('code')->toArray();
        $result = [];

        foreach ($currencies as $currency) {
            $result[$currency] = $this->calculateCartTotal($userId, $sessionId, $currency, $userCountryCode);
        }

        return $result;
    }

    /**
     * 카트에 아이템 추가 시 가격 미리보기
     */
    public function previewAddItem($userId, $sessionId, $itemType, $itemId, $quantity = 1, $pricingOptionId = null, $targetCurrency = null, $userCountryCode = null)
    {
        // 현재 카트 총액
        $currentTotal = $this->calculateCartTotal($userId, $sessionId, $targetCurrency, $userCountryCode);

        // 추가할 아이템의 가격 계산
        $newItemPricing = $this->calculateNewItemPrice($itemType, $itemId, $quantity, $pricingOptionId, $targetCurrency, $userCountryCode);

        // 예상 총액
        $expectedTotal = [
            'subtotal' => $currentTotal['subtotal'] + $newItemPricing['subtotal_excluding_tax'],
            'total_tax' => $currentTotal['total_tax'] + $newItemPricing['total_tax_amount'],
            'total_amount' => $currentTotal['total_amount'] + $newItemPricing['subtotal'],
            'currency' => $targetCurrency ?: $this->baseCurrency,
            'item_count' => $currentTotal['item_count'] + 1,
            'total_quantity' => $currentTotal['total_quantity'] + $quantity,
        ];

        return [
            'current_total' => $currentTotal,
            'new_item' => $newItemPricing,
            'expected_total' => $expectedTotal,
            'difference' => [
                'subtotal' => $newItemPricing['subtotal_excluding_tax'],
                'tax' => $newItemPricing['total_tax_amount'],
                'total' => $newItemPricing['subtotal'],
            ],
        ];
    }

    /**
     * 새 아이템 가격 계산
     */
    protected function calculateNewItemPrice($itemType, $itemId, $quantity, $pricingOptionId, $targetCurrency, $userCountryCode)
    {
        // 임시 카트 아이템 생성 (저장하지 않음)
        $tempCartItem = new SiteCart([
            'item_type' => $itemType,
            'item_id' => $itemId,
            'pricing_option_id' => $pricingOptionId,
            'quantity' => $quantity,
        ]);

        return $this->calculateCartItemPrice($tempCartItem, $targetCurrency, $userCountryCode);
    }

    /**
     * 할인 쿠폰 적용 (기본 구조)
     */
    public function applyCoupon($cartTotal, $couponCode)
    {
        // TODO: 향후 쿠폰 시스템 구현 시 확장
        $coupon = $this->getCouponByCode($couponCode);

        if (!$coupon || !$this->validateCoupon($coupon, $cartTotal)) {
            return [
                'success' => false,
                'message' => '유효하지 않은 쿠폰입니다.',
                'discount_amount' => 0,
            ];
        }

        $discountAmount = $this->calculateCouponDiscount($coupon, $cartTotal);

        return [
            'success' => true,
            'coupon' => $coupon,
            'discount_amount' => $discountAmount,
            'new_total' => max(0, $cartTotal['total_amount'] - $discountAmount),
        ];
    }

    /**
     * 결제 요약 정보 생성
     */
    public function generatePaymentSummary($userId = null, $sessionId = null, $targetCurrency = null, $userCountryCode = null, $couponCode = null)
    {
        $cartTotal = $this->calculateCartTotal($userId, $sessionId, $targetCurrency, $userCountryCode);

        $summary = [
            'cart_total' => $cartTotal,
            'discount' => null,
            'final_amount' => $cartTotal['total_amount'],
            'currency_info' => $cartTotal['currency_info'],
        ];

        // 쿠폰 적용
        if ($couponCode) {
            $couponResult = $this->applyCoupon($cartTotal, $couponCode);
            if ($couponResult['success']) {
                $summary['discount'] = $couponResult;
                $summary['final_amount'] = $couponResult['new_total'];
            }
        }

        return $summary;
    }

    /**
     * 가격 포맷팅 헬퍼
     */
    public function formatPrice($amount, $currencyCode = null)
    {
        $currencyCode = $currencyCode ?: $this->baseCurrency;
        $currency = SiteCurrency::findByCode($currencyCode);

        if ($currency) {
            return $currency->formatAmountWithSymbol($amount);
        }

        // 기본 포맷팅
        $symbols = [
            'KRW' => '₩',
            'USD' => '$',
            'EUR' => '€',
            'JPY' => '¥',
            'GBP' => '£',
        ];

        $symbol = $symbols[$currencyCode] ?? '$';
        $decimals = in_array($currencyCode, ['KRW', 'JPY']) ? 0 : 2;

        return $symbol . number_format($amount, $decimals);
    }

    /**
     * 빈 카트 정보
     */
    public function getEmptyCartSummary($targetCurrency = null)
    {
        $targetCurrency = $targetCurrency ?: $this->baseCurrency;

        return [
            'items' => [],
            'subtotal' => 0,
            'total_tax' => 0,
            'total_amount' => 0,
            'currency' => $targetCurrency,
            'currency_info' => SiteCurrency::findByCode($targetCurrency),
            'item_count' => 0,
            'total_quantity' => 0,
            'tax_summary' => [],
        ];
    }

    /**
     * 쿠폰 관련 메서드들 (향후 확장)
     */
    protected function getCouponByCode($couponCode)
    {
        // TODO: 쿠폰 테이블에서 조회
        return null;
    }

    protected function validateCoupon($coupon, $cartTotal)
    {
        // TODO: 쿠폰 유효성 검사 로직
        return false;
    }

    protected function calculateCouponDiscount($coupon, $cartTotal)
    {
        // TODO: 쿠폰 할인 계산 로직
        return 0;
    }
}