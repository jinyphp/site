<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

/**
 * 환율 정보 관리 서비스
 */
class ExchangeRateService
{
    /**
     * 지원하는 환율 API 제공업체
     */
    const PROVIDERS = [
        'fixer' => 'https://api.fixer.io/latest',
        'exchangerate' => 'https://api.exchangerate-api.com/v4/latest',
        'currencylayer' => 'http://api.currencylayer.com/live',
        'openexchangerates' => 'https://openexchangerates.org/api/latest.json'
    ];

    protected $baseCurrency;
    protected $provider;
    protected $apiKey;

    public function __construct()
    {
        $this->baseCurrency = config('site.base_currency', 'KRW');
        $this->provider = config('site.exchange_rate_provider', 'exchangerate');
        $this->apiKey = config('site.exchange_rate_api_key');
    }

    /**
     * 모든 활성화된 통화의 환율 업데이트
     */
    public function updateAllRates(): array
    {
        $results = [];
        $activeCurrencies = $this->getActiveCurrencies();

        foreach ($activeCurrencies as $currency) {
            if ($currency->code === $this->baseCurrency) {
                continue; // 기준 통화는 스킵
            }

            try {
                $result = $this->updateRate($this->baseCurrency, $currency->code);
                $results[] = [
                    'currency_pair' => "{$this->baseCurrency}/{$currency->code}",
                    'success' => $result['success'],
                    'rate' => $result['rate'] ?? null,
                    'message' => $result['message'] ?? 'Success'
                ];
            } catch (Exception $e) {
                $results[] = [
                    'currency_pair' => "{$this->baseCurrency}/{$currency->code}",
                    'success' => false,
                    'rate' => null,
                    'message' => $e->getMessage()
                ];
            }
        }

        return $results;
    }

    /**
     * 특정 통화 쌍의 환율 업데이트
     */
    public function updateRate(string $fromCurrency, string $toCurrency): array
    {
        try {
            // API에서 환율 정보 가져오기
            $apiResponse = $this->fetchRateFromAPI($fromCurrency, $toCurrency);

            if (!$apiResponse['success']) {
                throw new Exception($apiResponse['message']);
            }

            $newRate = $apiResponse['rate'];
            $inverseRate = 1 / $newRate;

            // 기존 환율 정보 가져오기
            $existingRate = DB::table('site_exchange_rates')
                ->where('from_currency', $fromCurrency)
                ->where('to_currency', $toCurrency)
                ->first();

            $oldRate = $existingRate ? $existingRate->rate : null;

            // 환율 변동량 계산
            $rateChange = $oldRate ? ($newRate - $oldRate) : 0;
            $rateChangePercent = $oldRate ? (($newRate - $oldRate) / $oldRate) * 100 : 0;

            // 환율 정보 업데이트 또는 생성
            $rateData = [
                'from_currency' => $fromCurrency,
                'to_currency' => $toCurrency,
                'rate' => $newRate,
                'inverse_rate' => $inverseRate,
                'source' => 'api',
                'provider' => $this->provider,
                'rate_date' => now(),
                'expires_at' => now()->addHours(1), // 1시간 후 만료
                'is_active' => true,
                'notes' => "API 자동 업데이트",
                'updated_at' => now(),
            ];

            if ($existingRate) {
                DB::table('site_exchange_rates')
                    ->where('id', $existingRate->id)
                    ->update($rateData);
                $action = 'update';
            } else {
                $rateData['created_at'] = now();
                DB::table('site_exchange_rates')->insert($rateData);
                $action = 'create';
            }

            // 로그 기록
            $this->logRateChange([
                'from_currency' => $fromCurrency,
                'to_currency' => $toCurrency,
                'old_rate' => $oldRate,
                'new_rate' => $newRate,
                'rate_change' => $rateChange,
                'rate_change_percent' => $rateChangePercent,
                'action' => $action,
                'source' => 'api',
                'provider' => $this->provider,
                'rate_date' => now(),
                'api_response' => $apiResponse['raw_data'],
                'api_status' => 'success',
            ]);

            return [
                'success' => true,
                'rate' => $newRate,
                'old_rate' => $oldRate,
                'change' => $rateChange,
                'change_percent' => $rateChangePercent,
                'provider' => $this->provider
            ];

        } catch (Exception $e) {
            // 에러 로깅
            $this->logRateChange([
                'from_currency' => $fromCurrency,
                'to_currency' => $toCurrency,
                'old_rate' => null,
                'new_rate' => 0,
                'rate_change' => 0,
                'rate_change_percent' => 0,
                'action' => 'error',
                'source' => 'api',
                'provider' => $this->provider,
                'rate_date' => now(),
                'api_status' => 'error',
                'api_error' => $e->getMessage(),
            ]);

            Log::error('Exchange rate update failed', [
                'from' => $fromCurrency,
                'to' => $toCurrency,
                'provider' => $this->provider,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * API에서 환율 정보 가져오기
     */
    protected function fetchRateFromAPI(string $fromCurrency, string $toCurrency): array
    {
        try {
            switch ($this->provider) {
                case 'exchangerate':
                    return $this->fetchFromExchangeRateAPI($fromCurrency, $toCurrency);
                case 'fixer':
                    return $this->fetchFromFixerAPI($fromCurrency, $toCurrency);
                case 'currencylayer':
                    return $this->fetchFromCurrencyLayerAPI($fromCurrency, $toCurrency);
                default:
                    return $this->fetchFromExchangeRateAPI($fromCurrency, $toCurrency);
            }
        } catch (Exception $e) {
            throw new Exception("API 호출 실패: " . $e->getMessage());
        }
    }

    /**
     * ExchangeRate-API에서 환율 정보 가져오기 (무료, API 키 불필요)
     */
    protected function fetchFromExchangeRateAPI(string $fromCurrency, string $toCurrency): array
    {
        $url = "https://api.exchangerate-api.com/v4/latest/{$fromCurrency}";

        $response = Http::timeout(10)->get($url);

        if (!$response->successful()) {
            throw new Exception("API 호출 실패: HTTP " . $response->status());
        }

        $data = $response->json();

        if (!isset($data['rates'][$toCurrency])) {
            throw new Exception("통화 {$toCurrency}에 대한 환율 정보가 없습니다.");
        }

        return [
            'success' => true,
            'rate' => (float) $data['rates'][$toCurrency],
            'raw_data' => $data
        ];
    }

    /**
     * Fixer.io API에서 환율 정보 가져오기
     */
    protected function fetchFromFixerAPI(string $fromCurrency, string $toCurrency): array
    {
        if (!$this->apiKey) {
            throw new Exception("Fixer.io API 키가 설정되지 않았습니다.");
        }

        $url = "https://api.fixer.io/latest";
        $params = [
            'access_key' => $this->apiKey,
            'base' => $fromCurrency,
            'symbols' => $toCurrency
        ];

        $response = Http::timeout(10)->get($url, $params);

        if (!$response->successful()) {
            throw new Exception("API 호출 실패: HTTP " . $response->status());
        }

        $data = $response->json();

        if (!$data['success']) {
            throw new Exception("API 에러: " . ($data['error']['info'] ?? 'Unknown error'));
        }

        if (!isset($data['rates'][$toCurrency])) {
            throw new Exception("통화 {$toCurrency}에 대한 환율 정보가 없습니다.");
        }

        return [
            'success' => true,
            'rate' => (float) $data['rates'][$toCurrency],
            'raw_data' => $data
        ];
    }

    /**
     * CurrencyLayer API에서 환율 정보 가져오기
     */
    protected function fetchFromCurrencyLayerAPI(string $fromCurrency, string $toCurrency): array
    {
        if (!$this->apiKey) {
            throw new Exception("CurrencyLayer API 키가 설정되지 않았습니다.");
        }

        $url = "http://api.currencylayer.com/live";
        $params = [
            'access_key' => $this->apiKey,
            'source' => $fromCurrency,
            'currencies' => $toCurrency
        ];

        $response = Http::timeout(10)->get($url, $params);

        if (!$response->successful()) {
            throw new Exception("API 호출 실패: HTTP " . $response->status());
        }

        $data = $response->json();

        if (!$data['success']) {
            throw new Exception("API 에러: " . ($data['error']['info'] ?? 'Unknown error'));
        }

        $quoteKey = $fromCurrency . $toCurrency;
        if (!isset($data['quotes'][$quoteKey])) {
            throw new Exception("통화 {$toCurrency}에 대한 환율 정보가 없습니다.");
        }

        return [
            'success' => true,
            'rate' => (float) $data['quotes'][$quoteKey],
            'raw_data' => $data
        ];
    }

    /**
     * 환율 변경 로그 기록
     */
    protected function logRateChange(array $logData): void
    {
        $logData['created_at'] = now();
        $logData['updated_at'] = now();
        $logData['ip_address'] = request()->ip() ?? null;
        $logData['user_agent'] = request()->userAgent() ?? null;

        // JSON 데이터를 문자열로 변환 (SQLite 호환성)
        if (isset($logData['api_response']) && is_array($logData['api_response'])) {
            $logData['api_response'] = json_encode($logData['api_response']);
        }

        DB::table('site_exchange_rate_logs')->insert($logData);
    }

    /**
     * 활성화된 통화 목록 가져오기
     */
    protected function getActiveCurrencies()
    {
        return DB::table('site_currencies')
            ->where('enable', true)
            ->orderBy('order')
            ->get();
    }

    /**
     * 환율 정보 가져오기 (캐시 포함)
     */
    public function getRate(string $fromCurrency, string $toCurrency): ?float
    {
        $rate = DB::table('site_exchange_rates')
            ->where('from_currency', $fromCurrency)
            ->where('to_currency', $toCurrency)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->value('rate');

        return $rate ? (float) $rate : null;
    }

    /**
     * 금액 환전
     */
    public function convertAmount(?float $amount, string $fromCurrency, string $toCurrency): ?float
    {
        // null 체크 - 기본값 0 반환
        if ($amount === null || $amount < 0) {
            return 0.0;
        }

        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        $rate = $this->getRate($fromCurrency, $toCurrency);

        if (!$rate) {
            // 환율 정보가 없으면 자동 업데이트 시도
            $result = $this->updateRate($fromCurrency, $toCurrency);
            if ($result['success']) {
                $rate = $result['rate'];
            }
        }

        return $rate ? $amount * $rate : null;
    }

    /**
     * 환율 정보 만료 체크 및 자동 업데이트
     */
    public function checkAndUpdateExpiredRates(): array
    {
        $expiredRates = DB::table('site_exchange_rates')
            ->where('is_active', true)
            ->where('expires_at', '<=', now())
            ->get();

        $results = [];
        foreach ($expiredRates as $rate) {
            $result = $this->updateRate($rate->from_currency, $rate->to_currency);
            $results[] = array_merge($result, [
                'currency_pair' => "{$rate->from_currency}/{$rate->to_currency}"
            ]);
        }

        return $results;
    }
}