<?php

namespace Jiny\Site\Helpers;

use Illuminate\Support\Facades\DB;
use Jiny\Site\Services\ExchangeRateService;

/**
 * 통화 및 세율 관련 헬퍼 클래스
 */
class CurrencyHelper
{
    /**
     * 현재 설정된 기본 통화 조회
     */
    public static function getBaseCurrency(): string
    {
        static $baseCurrency = null;

        if ($baseCurrency === null) {
            $baseCurrency = DB::table('site_currencies')
                ->where('is_base', true)
                ->value('code') ?? 'KRW';
        }

        return $baseCurrency;
    }

    /**
     * 사용자 국가 기본 통화 조회 (세션 또는 IP 기반)
     */
    public static function getUserCurrency(): string
    {
        // 세션에서 통화 설정 확인
        $sessionCurrency = session('user_currency');
        if ($sessionCurrency && static::isValidCurrency($sessionCurrency)) {
            return $sessionCurrency;
        }

        // 기본 국가의 통화 반환
        $defaultCountry = static::getDefaultCountry();
        return $defaultCountry->currency_code ?? static::getBaseCurrency();
    }

    /**
     * 사용자 국가 조회 (세션 또는 기본값)
     */
    public static function getUserCountry(): ?object
    {
        // 세션에서 국가 설정 확인
        $sessionCountry = session('user_country');
        if ($sessionCountry) {
            $country = DB::table('site_countries')
                ->where('code', $sessionCountry)
                ->where('enable', true)
                ->first();
            if ($country) {
                return $country;
            }
        }

        // 기본 국가 반환
        return static::getDefaultCountry();
    }

    /**
     * 기본 국가 조회
     */
    public static function getDefaultCountry(): ?object
    {
        static $defaultCountry = null;

        if ($defaultCountry === null) {
            $defaultCountry = DB::table('site_countries')
                ->where('is_default', true)
                ->where('enable', true)
                ->first();

            // 기본 국가가 없으면 첫 번째 활성화된 국가 사용
            if (!$defaultCountry) {
                $defaultCountry = DB::table('site_countries')
                    ->where('enable', true)
                    ->orderBy('order')
                    ->first();
            }
        }

        return $defaultCountry;
    }

    /**
     * 통화 코드 유효성 검사
     */
    public static function isValidCurrency(string $currencyCode): bool
    {
        return DB::table('site_currencies')
            ->where('code', $currencyCode)
            ->where('enable', true)
            ->exists();
    }

    /**
     * 금액을 다른 통화로 변환
     */
    public static function convertAmount(
        ?float $amount,
        string $fromCurrency,
        string $toCurrency = null
    ): float {
        // null 체크 - 기본값 0 반환
        if ($amount === null || $amount < 0) {
            return 0.0;
        }

        if ($toCurrency === null) {
            $toCurrency = static::getUserCurrency();
        }

        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        $exchangeService = app(ExchangeRateService::class);
        $convertedAmount = $exchangeService->convertAmount($amount, $fromCurrency, $toCurrency);

        return $convertedAmount ?? $amount;
    }

    /**
     * 금액에 세금 적용
     */
    public static function applyTax(?float $amount, string $countryCode = null): array
    {
        // null 체크 - 기본값 0 사용
        if ($amount === null || $amount < 0) {
            $amount = 0.0;
        }
        if ($countryCode === null) {
            $country = static::getUserCountry();
        } else {
            $country = DB::table('site_countries')
                ->where('code', $countryCode)
                ->where('enable', true)
                ->first();
        }

        if (!$country) {
            return [
                'subtotal' => $amount,
                'tax_rate' => 0,
                'tax_amount' => 0,
                'total' => $amount,
                'tax_name' => 'N/A'
            ];
        }

        $taxRate = (float) $country->tax_rate;
        $taxAmount = $amount * $taxRate;
        $total = $amount + $taxAmount;

        return [
            'subtotal' => $amount,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'tax_name' => $country->tax_name ?? 'Tax',
            'country_code' => $country->code,
            'country_name' => $country->name
        ];
    }

    /**
     * 금액을 사용자 통화로 변환하고 세금 적용
     */
    public static function calculatePrice(
        ?float $baseAmount,
        string $baseCurrency = null,
        string $targetCurrency = null,
        string $countryCode = null
    ): array {
        // null 체크 - 기본값 0 사용
        if ($baseAmount === null || $baseAmount < 0) {
            $baseAmount = 0.0;
        }
        if ($baseCurrency === null) {
            $baseCurrency = static::getBaseCurrency();
        }

        if ($targetCurrency === null) {
            $targetCurrency = static::getUserCurrency();
        }

        // 통화 변환
        $convertedAmount = static::convertAmount($baseAmount, $baseCurrency, $targetCurrency);

        // 세금 적용
        $priceWithTax = static::applyTax($convertedAmount, $countryCode);

        return array_merge($priceWithTax, [
            'base_amount' => $baseAmount,
            'base_currency' => $baseCurrency,
            'target_currency' => $targetCurrency,
            'converted_amount' => $convertedAmount,
            'exchange_rate' => $baseAmount > 0 ? ($convertedAmount / $baseAmount) : 1,
        ]);
    }

    /**
     * 통화 포맷팅
     */
    public static function formatCurrency(
        ?float $amount,
        string $currencyCode = null,
        int $decimals = null
    ): string {
        // null 체크 - 기본값 0 사용
        if ($amount === null || $amount < 0) {
            $amount = 0.0;
        }
        if ($currencyCode === null) {
            $currencyCode = static::getUserCurrency();
        }

        $currency = DB::table('site_currencies')
            ->where('code', $currencyCode)
            ->first();

        if (!$currency) {
            return number_format($amount, 2);
        }

        if ($decimals === null) {
            $decimals = (int) $currency->decimal_places;
        }

        $symbol = $currency->symbol ?? $currencyCode;

        return $symbol . ' ' . number_format($amount, $decimals);
    }

    /**
     * 활성화된 통화 목록 조회
     */
    public static function getActiveCurrencies(): array
    {
        static $currencies = null;

        if ($currencies === null) {
            $currencies = DB::table('site_currencies')
                ->where('enable', true)
                ->orderBy('order')
                ->orderBy('name')
                ->get()
                ->toArray();
        }

        return $currencies;
    }

    /**
     * 활성화된 국가 목록 조회
     */
    public static function getActiveCountries(): array
    {
        static $countries = null;

        if ($countries === null) {
            $countries = DB::table('site_countries')
                ->where('enable', true)
                ->orderBy('order')
                ->orderBy('name')
                ->get()
                ->toArray();
        }

        return $countries;
    }

    /**
     * 사용자 통화/국가 설정 (세션)
     */
    public static function setUserPreferences(string $currencyCode = null, string $countryCode = null): void
    {
        if ($currencyCode && static::isValidCurrency($currencyCode)) {
            session(['user_currency' => $currencyCode]);
        }

        if ($countryCode) {
            $country = DB::table('site_countries')
                ->where('code', $countryCode)
                ->where('enable', true)
                ->first();

            if ($country) {
                session(['user_country' => $countryCode]);

                // 통화도 함께 설정 (기본값)
                if (!$currencyCode && $country->currency_code) {
                    session(['user_currency' => $country->currency_code]);
                }
            }
        }
    }

    /**
     * 환율 정보 조회
     */
    public static function getExchangeRate(string $fromCurrency, string $toCurrency): ?float
    {
        $exchangeService = app(ExchangeRateService::class);
        return $exchangeService->getRate($fromCurrency, $toCurrency);
    }

    /**
     * 가격 표시용 배열 생성 (다중 통화 지원)
     */
    public static function getPriceDisplay(
        ?float $baseAmount,
        string $baseCurrency = null,
        array $displayCurrencies = null
    ): array {
        // null 체크 - 기본값 0 사용
        if ($baseAmount === null || $baseAmount < 0) {
            $baseAmount = 0.0;
        }
        if ($baseCurrency === null) {
            $baseCurrency = static::getBaseCurrency();
        }

        if ($displayCurrencies === null) {
            $displayCurrencies = ['KRW', 'USD', 'EUR', 'JPY'];
        }

        $prices = [];
        foreach ($displayCurrencies as $currency) {
            $converted = static::convertAmount($baseAmount, $baseCurrency, $currency);
            $prices[$currency] = [
                'amount' => $converted,
                'formatted' => static::formatCurrency($converted, $currency),
                'symbol' => DB::table('site_currencies')->where('code', $currency)->value('symbol') ?? $currency
            ];
        }

        return $prices;
    }
}