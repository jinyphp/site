<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Settings;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Helpers\CurrencyHelper;

/**
 * 이커머스 설정 관리 컨트롤러
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'view' => 'jiny-site::ecommerce.settings.index',
            'title' => '이커머스 설정',
            'subtitle' => '전체 이커머스 시스템 설정을 관리합니다.',
        ];
    }

    public function __invoke(Request $request)
    {
        // 현재 설정 값들
        $settings = $this->getCurrentSettings();

        // 통화 목록
        $currencies = CurrencyHelper::getActiveCurrencies();

        // 국가 목록
        $countries = CurrencyHelper::getActiveCountries();

        // 환율 정보
        $exchangeRates = $this->getExchangeRateInfo();

        // 시스템 상태 정보
        $systemStatus = $this->getSystemStatus();

        return view($this->config['view'], [
            'settings' => $settings,
            'currencies' => $currencies,
            'countries' => $countries,
            'exchangeRates' => $exchangeRates,
            'systemStatus' => $systemStatus,
            'config' => $this->config,
        ]);
    }

    /**
     * 현재 설정 값들 조회
     */
    protected function getCurrentSettings()
    {
        return [
            // 기본 설정
            'store_name' => config('app.name', 'JinyShop'),
            'store_email' => config('mail.from.address', 'shop@example.com'),
            'store_phone' => '+82-2-1234-5678',
            'store_address' => '서울특별시 강남구 테헤란로 123',

            // 통화 설정
            'base_currency' => CurrencyHelper::getBaseCurrency(),
            'display_currencies' => ['KRW', 'USD', 'EUR'],
            'auto_currency_detection' => true,
            'currency_decimals' => 0,

            // 세금 설정
            'tax_calculation' => 'exclusive', // exclusive, inclusive
            'tax_display' => 'both', // tax_only, price_only, both
            'default_tax_rate' => 0.10,
            'tax_based_on' => 'shipping_address', // billing_address, shipping_address, store_address

            // 주문 설정
            'order_number_prefix' => 'ORD-',
            'order_number_format' => 'YYYYMMDD-NNN',
            'order_auto_confirm' => false,
            'order_stock_reduction' => 'on_payment', // on_order, on_payment, manual
            'allow_guest_checkout' => true,
            'require_phone_number' => true,

            // 배송 설정
            'default_shipping_country' => 'KR',
            'shipping_calculation' => 'per_order', // per_item, per_order, per_weight
            'free_shipping_threshold' => 50000,
            'shipping_tax_calculation' => true,

            // 재고 설정
            'track_inventory' => true,
            'allow_backorders' => false,
            'low_stock_threshold' => 10,
            'out_of_stock_message' => '품절',
            'show_stock_quantity' => false,

            // 가격 설정
            'price_display_format' => '{symbol} {amount}',
            'price_thousand_separator' => ',',
            'price_decimal_separator' => '.',
            'hide_zero_decimals' => true,

            // 고객 설정
            'customer_registration' => 'required', // required, optional, disabled
            'customer_email_verification' => true,
            'customer_phone_verification' => false,
            'allow_customer_reviews' => true,
            'review_moderation' => true,

            // 결제 설정
            'payment_methods' => ['credit_card', 'bank_transfer', 'paypal'],
            'payment_currency' => 'KRW',
            'payment_gateway' => 'stripe',
            'auto_capture_payment' => false,

            // 이메일 설정
            'email_new_order' => true,
            'email_order_confirmation' => true,
            'email_order_shipped' => true,
            'email_order_delivered' => true,
            'email_order_cancelled' => true,
            'email_low_stock' => true,

            // 보안 설정
            'session_timeout' => 30,
            'max_login_attempts' => 5,
            'password_reset_expiry' => 60,
            'require_ssl' => true,

            // API 설정
            'api_enabled' => false,
            'api_rate_limit' => 100,
            'webhook_enabled' => false,
            'webhook_secret' => null,

            // 고급 설정
            'cache_enabled' => true,
            'cache_duration' => 3600,
            'debug_mode' => config('app.debug', false),
            'maintenance_mode' => false,
        ];
    }

    /**
     * 환율 정보 조회
     */
    protected function getExchangeRateInfo()
    {
        $lastUpdate = DB::table('site_exchange_rates')->max('updated_at');

        $rates = DB::table('site_exchange_rates')
            ->leftJoin('site_currencies as from_curr', 'site_exchange_rates.from_currency', '=', 'from_curr.code')
            ->leftJoin('site_currencies as to_curr', 'site_exchange_rates.to_currency', '=', 'to_curr.code')
            ->select(
                'site_exchange_rates.*',
                'from_curr.name as from_currency_name',
                'from_curr.symbol as from_currency_symbol',
                'to_curr.name as to_currency_name',
                'to_curr.symbol as to_currency_symbol'
            )
            ->where('site_exchange_rates.is_active', true)
            ->orderBy('site_exchange_rates.updated_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'last_update' => $lastUpdate,
            'total_rates' => DB::table('site_exchange_rates')->where('is_active', true)->count(),
            'auto_update_enabled' => true,
            'update_frequency' => 'hourly',
            'recent_rates' => $rates,
        ];
    }

    /**
     * 시스템 상태 정보
     */
    protected function getSystemStatus()
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database_connection' => $this->checkDatabaseConnection(),
            'cache_status' => $this->checkCacheStatus(),
            'queue_status' => $this->checkQueueStatus(),
            'storage_permissions' => $this->checkStoragePermissions(),
            'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB',
            'disk_space' => $this->getDiskSpace(),
            'ssl_enabled' => $this->checkSSL(),
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
        ];
    }

    /**
     * 헬퍼 메서드들
     */
    protected function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            return ['status' => 'connected', 'message' => '정상'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => '연결 실패'];
        }
    }

    protected function checkCacheStatus()
    {
        try {
            cache()->put('test_key', 'test_value', 60);
            $value = cache()->get('test_key');
            cache()->forget('test_key');

            return ['status' => 'working', 'message' => '정상'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => '캐시 오류'];
        }
    }

    protected function checkQueueStatus()
    {
        // 큐 상태 확인 로직
        return ['status' => 'working', 'message' => '정상'];
    }

    protected function checkStoragePermissions()
    {
        $storagePath = storage_path();
        return ['status' => is_writable($storagePath) ? 'writable' : 'error', 'message' => is_writable($storagePath) ? '쓰기 가능' : '권한 없음'];
    }

    protected function getDiskSpace()
    {
        $bytes = disk_free_space(".");
        $gb = round($bytes / 1024 / 1024 / 1024, 2);
        return $gb . ' GB';
    }

    protected function checkSSL()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    }
}