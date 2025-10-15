<?php

namespace Jiny\Site\Http\Controllers\Site\Cart;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Helpers\CurrencyHelper;

/**
 * 장바구니 목록 컨트롤러
 */
class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = auth()->id();
        $sessionId = $userId ? null : session()->getId();

        // 장바구니 아이템 조회
        $cartItems = DB::table('site_cart')
            ->leftJoin('site_products', function($join) {
                $join->on('site_cart.item_id', '=', 'site_products.id')
                     ->where('site_cart.item_type', '=', 'product');
            })
            ->leftJoin('site_services', function($join) {
                $join->on('site_cart.item_id', '=', 'site_services.id')
                     ->where('site_cart.item_type', '=', 'service');
            })
            ->leftJoin('site_product_pricing', function($join) {
                $join->on('site_cart.pricing_option_id', '=', 'site_product_pricing.id')
                     ->where('site_cart.item_type', '=', 'product');
            })
            ->leftJoin('site_service_pricing', function($join) {
                $join->on('site_cart.pricing_option_id', '=', 'site_service_pricing.id')
                     ->where('site_cart.item_type', '=', 'service');
            })
            ->select(
                'site_cart.*',
                // 상품 정보
                'site_products.title as product_title',
                'site_products.image as product_image',
                'site_products.slug as product_slug',
                'site_products.price as product_base_price',
                // 서비스 정보
                'site_services.title as service_title',
                'site_services.image as service_image',
                'site_services.slug as service_slug',
                'site_services.price as service_base_price',
                // 가격 옵션 정보
                'site_product_pricing.name as product_pricing_name',
                'site_product_pricing.price as product_pricing_price',
                'site_service_pricing.name as service_pricing_name',
                'site_service_pricing.price as service_pricing_price'
            )
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('site_cart.user_id', $userId);
                } else {
                    $query->where('site_cart.session_id', $sessionId);
                }
            })
            ->whereNull('site_cart.deleted_at')
            ->orderBy('site_cart.created_at', 'desc')
            ->get();

        // 사용자 통화 및 국가 정보 가져오기
        $userCurrency = CurrencyHelper::getUserCurrency();
        $userCountry = CurrencyHelper::getUserCountry();
        $baseCurrency = CurrencyHelper::getBaseCurrency();

        // 각 아이템의 정보 정리
        $cartItems = $cartItems->map(function($item) use ($baseCurrency, $userCurrency) {
            if ($item->item_type === 'product') {
                $item->title = $item->product_title;
                $item->image = $item->product_image;
                $item->slug = $item->product_slug;
                $item->base_price = $item->product_base_price;
                $item->pricing_name = $item->product_pricing_name;
                $item->pricing_price = $item->product_pricing_price;
            } else {
                $item->title = $item->service_title;
                $item->image = $item->service_image;
                $item->slug = $item->service_slug;
                $item->base_price = $item->service_base_price;
                $item->pricing_name = $item->service_pricing_name;
                $item->pricing_price = $item->service_pricing_price;
            }

            // 기준 가격 (KRW) - null 체크 추가
            $basePrice = $item->pricing_price ?: $item->base_price;
            $basePrice = $basePrice ?: 0; // null이면 0으로 설정

            // 사용자 통화로 변환
            $convertedPrice = CurrencyHelper::convertAmount($basePrice, $baseCurrency, $userCurrency);

            // 가격 정보 설정
            $item->base_price_krw = $basePrice;
            $item->final_price = $convertedPrice;
            $item->final_price_formatted = CurrencyHelper::formatCurrency($convertedPrice, $userCurrency);
            $item->total_price = $convertedPrice * $item->quantity;
            $item->total_price_formatted = CurrencyHelper::formatCurrency($item->total_price, $userCurrency);
            $item->currency = $userCurrency;

            return $item;
        });

        // 총 금액 계산 (국가별 세율 적용)
        $subtotal = $cartItems->sum('total_price');
        $taxInfo = CurrencyHelper::applyTax($subtotal, $userCountry->code ?? null);

        // 추가 통화 정보
        $currencyInfo = [
            'user_currency' => $userCurrency,
            'base_currency' => $baseCurrency,
            'user_country' => $userCountry,
            'exchange_rate' => CurrencyHelper::getExchangeRate($baseCurrency, $userCurrency),
            'currency_symbol' => DB::table('site_currencies')->where('code', $userCurrency)->value('symbol') ?? $userCurrency
        ];

        // 다중 통화 가격 표시 (선택적)
        $multiCurrencyPrices = CurrencyHelper::getPriceDisplay($taxInfo['total'], $userCurrency);

        return view('jiny-site::www.cart.index', [
            'cartItems' => $cartItems,
            'summary' => [
                'item_count' => $cartItems->count(),
                'total_quantity' => $cartItems->sum('quantity'),
                'subtotal' => $taxInfo['subtotal'],
                'subtotal_formatted' => CurrencyHelper::formatCurrency($taxInfo['subtotal'], $userCurrency),
                'tax_rate' => $taxInfo['tax_rate'],
                'tax_rate_percent' => $taxInfo['tax_rate'] * 100,
                'tax_amount' => $taxInfo['tax_amount'],
                'tax_amount_formatted' => CurrencyHelper::formatCurrency($taxInfo['tax_amount'], $userCurrency),
                'tax_name' => $taxInfo['tax_name'],
                'total' => $taxInfo['total'],
                'total_formatted' => CurrencyHelper::formatCurrency($taxInfo['total'], $userCurrency),
                'country_name' => $taxInfo['country_name'] ?? 'Unknown'
            ],
            'currency' => $currencyInfo,
            'multi_currency_prices' => $multiCurrencyPrices
        ]);
    }
}